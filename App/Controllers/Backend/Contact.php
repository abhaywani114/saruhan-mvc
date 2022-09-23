<?php

namespace App\Controllers\Backend;

use System\Kernel\Controller;
use View;
use Model;
class Contact extends Controller
{
    public function index(){
        $languages = Model::run('languages','backend')->languages();
        $data = $languages;
        View::theme('saruhanweb')->render('contact',$data);
    }
}