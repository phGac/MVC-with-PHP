<?php

namespace App\Controllers;

use Kernel\Base\Controller;

class HomeController extends Controller
{
	public function login()
	{
		echo $this->render('home/login');
	}

	public function register()
	{
		require(_VIEWS.'home/register.php');
	}

	public function index() : void
	{
		echo $this->render('home/index');
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
