<?php
namespace App\Controllers\Frontend;

use System\Kernel\Controller;
use View;

class Gallery extends Controller
{
	
	public function index()
	{
		$data = [];
		$data["title"] = lang('page','title');
		View::render('gallery',$data);
	}
}