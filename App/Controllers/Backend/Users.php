<?php

namespace App\Controllers\Backend;

use System\Facades\Request;
use System\Kernel\Controller;
use View;
use Model;
use Date;

class Users extends Controller
{
    public function index(){
        $languages = Model::run('languages','backend')->languages();
        $data = $languages;

        $users = Model::run('users','backend')->users();
        foreach ($users as $key => $user)
        {
            $data['users'][$key] = $user;
        }

        View::theme('saruhanweb')->render('users',$data);
    }
    public function userStatistic(){
        $languages = Model::run('languages','backend')->languages();
        $data = $languages;
        View::theme('saruhanweb')->render('userStatistic',$data);
    }
    public function add()
    {
        if (Request::post())
        {
            $nickname = Request::post('nickname');
            $name = Request::post('name');
            $surname = Request::post('surname');
            $email = Request::post('email');
            $password = md5(Request::post('password1'));
            $control = Model::run('users','backend')->userControl($nickname);
            if($control)
            {
                $msg = lang('dashboard','add_user_nickname_warning');
                $result = [
                    'statu' => 'warning',
                    'content' => $msg
                ];
                print_r(json_encode($result));
                return false;
            }
            else {
                $date = Date::now()->get('d.m.Y');
                $data = [
                    'nickname' => $nickname,
                    'password' => $password,
                    'name' => $name,
                    'surname' => $surname,
                    'email' => $email,
                    'statu' => 1,
                    'record_time' => $date
                ];
                $add = Model::run('users','backend')->add($data);
                if ($add)
                {
                    $msg = lang('dashboard','add_success');
                    $result = [
                        'statu' => 'success',
                        'content' => $msg
                    ];
                    print_r(json_encode($result));
                    return false;
                }
                else
                {
                    $msg = lang('dashboard','add_error');
                    $result = [
                        'statu' => 'error',
                        'content' => $msg
                    ];
                    print_r(json_encode($result));
                    return false;
                }
            }
        }
    }
    public function edit($ID)
    {
        if (Request::post())
        {
            $nickname = Request::post('nickname');
            $name = Request::post('name');
            $surname = Request::post('surname');
            $email = Request::post('email');
            $password = Request::post('password1');

            $nnControl = Model::run('users','backend')->userControlNoID($nickname,$ID);
            if ($nnControl)
            {
                $msg = lang('dashboard','add_user_nickname_warning');
                $result = [
                    'statu' => 'warning',
                    'content' => $msg
                ];
                print_r(json_encode($result));
                return false;
            }
            $emailControl = Model::run('users','backend')->userEmailControlNoID($email,$ID);
            if ($emailControl)
            {
                $msg = lang('dashboard','add_user_email_warning');
                $result = [
                    'statu' => 'warning',
                    'content' => $msg
                ];
                print_r(json_encode($result));
                return false;
            }
            if (!empty($password)){
                $newpassword = md5($password);
            }
            else
            {
                $user = Model::run('users','backend')->user($ID);
                $newpassword = $user->password;
            }
            $data = [
                'nickname' => $nickname,
                'name' => $name,
                'surname' => $surname,
                'email' => $email,
                'password' => $newpassword
            ];
            $edit = Model::run('users','backend')->edit($data,$ID);
            if ($edit)
            {
                $msg = lang('dashboard','edit_success');
                $result = [
                    'statu' => 'success',
                    'content' => $msg
                ];
                print_r(json_encode($result));
                return false;
            }
            else
            {
                $msg = lang('dashboard','edit_error');
                $result = [
                    'statu' => 'error',
                    'content' => $msg
                ];
                print_r(json_encode($result));
                return false;
            }
        }
        else
        {
            $languages = Model::run('languages','backend')->languages();
            $data = $languages;
            $user = Model::run('users','backend')->user($ID);
            if ($user)
            {
                $data['user'] = $user;
            }
            else
            {
                $data['user'] = '';
            }
            View::theme('saruhanweb')->render('editUser',$data);
        }
    }
    public function delete()
    {
        $ID = Request::post('ID');
        $delete = Model::run('users','backend')->delete($ID);
        if ($delete)
        {
            $msg = lang('dashboard','delete_success');
            $result = [
                'statu' => 'success',
                'content' => $msg
            ];
            print_r(json_encode($result));
            return false;
        }
        else
        {
            $msg = lang('dashboard','delete_error');
            $result = [
                'statu' => 'error',
                'content' => $msg
            ];
            print_r(json_encode($result));
            return false;
        }
    }
}