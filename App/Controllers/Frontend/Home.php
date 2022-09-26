<?php
namespace App\Controllers\Frontend;

use System\Kernel\Controller;
use View;
use Response;

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

	public function test_user_lang() {
		View::theme('templateone')->render('test_lang');
	}

	public function test_about() {
	
		View::theme('templateone')->render('test_about');
	}



	public function set_user_lang($lang, $ref) {
		$is_lang_exist = \DB::select('*')->table('languages')->where('seo', '=', $lang)->getRow();

		if (!empty($is_lang_exist))
			set_lang($lang,'user');

        $link = lang('test_lang', $ref);
		return Response::back($link);
	}

}
