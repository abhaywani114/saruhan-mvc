<?php
namespace App\Controllers\Frontend;

use System\Kernel\Controller;
use View;
use Model;
use System\Facades\Request;

class Page extends Controller
{
	
	public function index($ID)
	{
		echo $ID;
        echo '<br>';

        $pageControl = Model::run('page','frontend')->pagecontrol($ID);
        echo $pageControl;
        echo '<br>';

        if ($pageControl>0)
        {
            echo 'sayfa var İşlemlere başyalabiliriz.';
            echo '<br>';
        }
        else
        {
            echo '404.sayfasına yönlenecek';
            echo '<br>';
        }

        print_r(Request::getLocales());
        echo '<br>';

        print_r(Request::getQueryString());
//		View::theme('templateone')->render('page');
	}
	
}