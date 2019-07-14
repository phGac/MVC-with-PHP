<?php

use App\Modules\Session;

$session = new Session();

$session->validateTimeLiveSession();

define('SESSION', serialize($session));

?>