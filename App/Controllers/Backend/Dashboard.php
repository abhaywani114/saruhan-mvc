<?php
namespace App\Controllers\Backend;

use System\Kernel\Controller;
use Model;
use View;


class Dashboard extends Controller
{

	public function index()
	{

        $languages = Model::run('languages','backend')->languages();
        $data = $languages;

        View::theme('saruhanweb')->render('home',$data);
	}

        public function set_admin_lang($lang) {
		$is_lang_exist = \DB::select('*')->table('languages')->where('seo', '=', $lang)->getRow();
		if (!empty($is_lang_exist)) {
 			set_lang($lang,'admin');
                }

		echo "{'status':'true'}";
	}
}
