<?php

namespace App\Controllers\Backend;

use System\Facades\Request;
use System\Kernel\Controller;
use Model;
use View;


class Languages extends Controller
{

    public function index(){
        $languages = Model::run('languages','backend')->languageList();
        $data = $languages;

        View::theme('saruhanweb')->render('languages',$data);
    }

    public function add(){
        if (Request::post()){
            $title = Request::post('title');
            $seo = Request::post('seo');
            $locale = Request::post('locale');
            $statu = Request::post('statu');
            $data = [
                'title' => $title,
                'seo' => $seo,
                'locale' => $locale,
                'statu' => $statu
            ];
            $add = Model::run('languages','backend')->add($data);
            if ($add)
            {
                $title = lang('dashboard','success_title');
                $msg = lang('dashboard','add_language_success');
                $result = [
                    'statu' => 'success',
                    'title' => $title,
                    'text' => $msg
                ];
                print_r(json_encode($result));
                return false;
            }
            else
            {
                $title = lang('dashboard','error_title');
                $msg = lang('dashboard','add_language_error');
                $result = [
                    'statu' => 'error',
                    'title' => $title,
                    'text' => $msg
                ];
                print_r(json_encode($result));
                return false;
            }
        }
    }
    public function edit($ID){
        if (Request::post())
        {
            $title = Request::post('title');
            $seo = Request::post('seo');
            $locale = Request::post('locale');
            $statu = Request::post('statu');

            $data = [
                'title' => $title,
                'seo' => $seo,
                'locale' => $locale,
                'statu' => $statu
            ];
            $edit = Model::run('languages','backend')->edit($ID,$data);
            if ($edit)
            {
                $title = lang('dashboard','success_title');
                $msg = lang('dashboard','edit_success');
                $result = [
                    'statu' => 'success',
                    'title' => $title,
                    'text' => $msg,
                ];
                return false;
            }
            else
            {
                $title = lang('dashboard','error_title');
                $msg = lang('dashboard','edit_error');
                $result = [
                    'statu' => 'error',
                    'title' => $title,
                    'text' => $msg,
                ];
                print_r(json_encode($result));
                return false;
            }
        }
        else
        {

            $languages = Model::run('languages', 'backend')->languages();

            $lang = Model::run('languages','backend')->lang($ID);
            $data = [
                'ID' => $lang->id,
                'title' => $lang->title,
                'seo' => $lang->seo,
                'locale' => $lang->locale,
                'statu' => $lang->statu,
            ];

            $data = array_merge($data,$languages);
            View::theme('saruhanweb')->render('editLanguage',$data);
        }

    }
    public function delete(){
        if (Request::post())
        {
            $ID = Request::post('ID');

            $delete = Model::run('languages','backend')->delete($ID);
            if ($delete)
            {
                $title = lang('dashboard','success_title');
                $msg = lang('dashboard','delete_success');
                $data = [
                    'statu' => 'success',
                    'title' => $title,
                    'text' => $msg
                ];
                print_r(json_encode($data));
                return false;
            }
            else
            {
                $title = lang('dashboard','error_title');
                $msg = lang('dashboard','delete_error');
                $data = [
                    'statu' => 'error',
                    'title' => $title,
                    'text' => $msg
                ];
                print_r(json_encode($data));
                return false;
            }
        }
    }

    public function setSiteLang()
    {
        if (Request::post())
        {
            $lang = Request::post('lang');
            $update = Model::run('languages','backend')->updateSiteLang($lang);
            if ($update)
            {
                $title = lang('dashboard','success_title');
                $msg = lang('dashboard','edit_success');
                $result = [
                    'statu' => 'success',
                    'title' => $title,
                    'text' => $msg
                ];
                print_r(json_encode($result));
                return false;
            }
            else
            {
                $title = lang('dashboard','error_title');
                $msg = lang('dashboard','edit_error');
                $result = [
                    'statu' => 'error',
                    'title' => $title,
                    'text' => $msg
                ];
                print_r(json_encode($result));
                return false;
            }
        }
    }
    public function setAdminLang()
    {
        if (Request::post())
        {
            $lang = Request::post('lang');
            $update = Model::run('languages','backend')->updateAdminLang($lang);
            if ($update)
            {
                $title = lang('dashboard','success_title');
                $msg = lang('dashboard','edit_success');
                $result = [
                    'statu' => 'success',
                    'title' => $title,
                    'text' => $msg
                ];
                print_r(json_encode($result));
                return false;
            }
            else
            {
                $title = lang('dashboard','error_title');
                $msg = lang('dashboard','edit_error');
                $result = [
                    'statu' => 'error',
                    'title' => $title,
                    'text' => $msg
                ];
                print_r(json_encode($result));
                return false;
            }
        }
    }
}