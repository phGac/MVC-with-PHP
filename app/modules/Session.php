<?php

namespace App\Modules;

use \Exception;
use App\Models\User;
use App\Modules\AppConfig;

class Session{
    
    private $session;
    private $timeLiveSession;
    private $maxTimeLiveSession;
    private $goAwayRoute;
    private $sessionNameValidation;

    function __construct()
    {
        session_start();
        self::sets();
    }

    private function getConfigSessionFile()
    {
        return AppConfig::session();
    }

    private function sets() : void
    {
        $cfg = self::getConfigSessionFile();
        //$this->session = unserialize(SESSION);
        $this->maxTimeLiveSession = $cfg['limit'];
        $this->goAwayRoute = $cfg['go-away'];
        $this->sessionNameValidation = $cfg['validate-session'];
    }

    function setTimeLiveSession() : void
    {
        $_SESSION['LAST_ACTIVITY'] = time();
        $this->timeLiveSession = $_SESSION['LAST_ACTIVITY'];
    }

    function setSession(User $user, bool $save_session = false) : bool
    {
        try
        {
            $user->clearConn();
            $u = serialize($user);
            $_SESSION['USER'] = $u;
            self::setTimeLiveSession();
            $this->maxTimeLiveSession = ($save_session) ? (86400 * 30) : $this->maxTimeLiveSession;
            return true;
        }
        catch(Exception $e)
        {
            return false;
        }
    }

    function getSession()
    {
        return $this->session;
    }

    function validateSession() : bool
    {
        return isset($_SESSION[$this->sessionNameValidation]);
    }

    function validateTimeLiveSession()
    {
        if ( isset( $_SESSION[ 'LAST_ACTIVITY' ] ) && 
            ( time() - $_SESSION[ 'LAST_ACTIVITY' ] > $this->maxTimeLiveSession ) ) {
            self::killSession();
        }
    }

    function killSession()
    {
        $_SESSION = array();
        if ( ini_get( 'session.use_cookies' ) ) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - $this->maxTimeLiveSession,
                $params[ 'path' ],
                $params[ 'domain' ],
                $params[ 'secure' ],
                $params[ 'httponly' ] 
            );
        }
        @session_destroy();
    }

    public function goAway(){
        header('Location: '.$this->goAwayRoute);
    }

}

?>