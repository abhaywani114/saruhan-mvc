<?php

namespace App\Controllers\Backend;

use System\Facades\View;
use System\Kernel\Controller;
use Request;
use Model;
use Session;

class Login extends Controller
{
    public function index()
    {
        $data = [
            'login_title' => lang("dashboard","login_title"),
            'info' => lang("dashboard","info"),
            'nickname' => lang("dashboard","nickname"),
            'nickname_warning' => lang("dashboard","nickname_warning"),
            'password' => lang("dashboard","password"),
            'password_warning' => lang("dashboard","password_warning"),
            'login_btn' => lang("dashboard","login_btn"),
        ];
        View::theme('saruhanweb')->render('login',$data);
    }
    public function login()
    {
        if (Request::post())
        {
            $nickname = Request::post('nickname');
            $password = Request::post('password');

            $data = [
                'nickname' => $nickname,
                'password' => $password
            ];

            $login = Model::run('login','backend')->login($data);
            if ($login)
            {
                Session::set('swLogin', $login->id);
                $return = [
                    'statu' => 'success',
                    'title' => 'Başarılı',
                    'text' => 'Giriş başarılı, Lütfen bekleyiniz'
                ];
                print_r(json_encode($return));
                return false;
            }
            else
            {
                $return = [
                    'statu' => 'error',
                    'title' => 'HATA!',
                    'text' => 'Kullanıcı adı veya Şifre hatalı. Tekrar deneyiniz'
                ];
                print_r(json_encode($return));
                return false;
            }
        }
    }
    public function logout()
    {
        Session::destroy();
        redirect(link_to('saruhanweb'));
    }
}