<?php

namespace App\Controllers;

use App\Modules\Controller;

class HomeController extends Controller
{
	public function login()
	{
		require(_VIEWS.'home/login.php');
	}

	public function register()
	{
		require(_VIEWS.'home/register.php');
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

}

?>
