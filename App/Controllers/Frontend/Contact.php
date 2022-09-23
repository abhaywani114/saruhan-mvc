<?php
namespace App\Controllers\Frontend;

use System\Kernel\Controller;
use View;

class Contact extends Controller
{
	
	public function index()
	{
		View::theme('templateone')->render('contact');
	}
}