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
}
