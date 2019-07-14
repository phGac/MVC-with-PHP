<?php

namespace App\Controllers;

use App\Models\User;
use App\Modules\Controller;

class UserController extends Controller
{
    function login()
    {
        $user = $this->params['user'];
        $password = $this->params['password'];
        $userClass = new User();
        $USER = $userClass->login($user, $password);
        if($USER != null)
        {
            $session = unserialize(SESSION); //new Session();
            if( !$session->setSession($USER) )
            {
                $session->killSession();
                $session->goAway();
                
            }else{
                $jsondata = array('status' => 'true');
                header('Content-type: application/json; charset=utf-8');
                echo(json_encode($jsondata));
            }
        }
        else
        {
            $jsondata = array('status' => 'false');
            header('Content-type: application/json; charset=utf-8');
            echo(json_encode($jsondata));
        }
    }

    public function register()
    {
        $username = $this->params['user'];
        $password = $this->params['password'];

        $userClass = new User();
        $resultado = $userClass->register($username, $password);
        if($resultado){
            $jsondata = array('status' => "true");
            header('Content-type: application/json; charset=utf-8');
            echo(json_encode($jsondata));
        }else{
            $jsondata = array('status' => "false");
            header('Content-type: application/json; charset=utf-8');
            echo(json_encode($jsondata));
        }
    }

    function logout()
    {
        if(!isset($_SESSION['USER'])){
            header('Location: /login');
            exit();
        }
        $userClass = new User();
        $logout = $userClass->logout();
        if($logout){
            header('Location: /login');
        }else{
            header('Location: /');
        }
    }

    public function index() : void
	{
		require(_VIEWS.'home/home.php');
	}

	public function new() : void
	{

	}

	public function show() : void
	{

	}

	public function create() : void
	{

	}

	public function edit() : void
	{

	}

	public function update() : void
	{

	}
	
	public function destroy() : void
	{

    }
    
    public function all() : void
    {
        $userClass = new User();
        $userClass->all();
    }
    
}

?>