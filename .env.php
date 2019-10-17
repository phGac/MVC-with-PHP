<?php
return array (
	'server' => [
		'status' => 'develop'
	],
	'db' => [
		'host' => '127.0.0.1',
		'dbname' => 'base',
		'user' => 'root',
		'pass' => '',
		'charset' => 'UTF-8',
		'type' => 'mysql', //sqlsrv
    ],
    'login' => [
        'table' => 'users',
        'user-column' => 'userName',
        'password-column' => 'userPassword',
        'class' => 'App\\Models\\User'
    ],
    'session' => [
		'limit' => '3600',
		'validate-session' => 'USER',
		'go-away' => 'http://php-mvc.phgac/login',
    ],
	'auth' => [
		'key' => 'hy2uL4up0VFHlG1LzKLf8gttqH3QmnudeyZXR77P8yYxeH3lOda3zgpHHuJluXSREDE7nzS0Wsr4drDkHE'
	]
);
?>