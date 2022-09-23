<?php
namespace App\Controllers\Frontend;

use System\Kernel\Controller;
use View;

class Home extends Controller
{
	public function index()
	{	
//		$data = [];
//		$data["title"] = lang('home','title');
//
//        $defaultLang = Model::run('options','backend')->defaultSiteLang();
//        set_lang($defaultLang->site_language);

		View::theme('templateone')->render('home');
	}


}
