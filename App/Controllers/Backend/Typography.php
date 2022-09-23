<?php

namespace App\Controllers\Backend;

use System\Kernel\Controller;
use View;
use Model;

class Typography extends Controller
{
    public function index(){
        $languages = Model::run('languages', 'backend')->languages();
        $data = $languages;
        View::theme('saruhanweb')->render('typography',$data);
    }
}