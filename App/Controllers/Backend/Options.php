<?php

namespace App\Controllers\Backend;

use System\Facades\Request;
use System\Kernel\Controller;
use View;
use Model;
use Uploadss;

class Options extends Controller
{
    public function index(){
        $languages = Model::run('languages','backend')->languages();
        $data = $languages;

        $optionsContent = Model::run('options','backend')->optionsContent();
        if ($optionsContent)
        {
            foreach ($optionsContent as $content)
            {
                $contents[$content->locale] = [
                    'title' => $content->title,
                    'description' => $content->description,
                ];
            }
            $data['content'] = $contents;
        }
        $logo = Model::run('options','backend')->logo();
        $data['logo'] = $logo->logo;
        $favicon = Model::run('options','backend')->favicon();
        if (!empty($favicon->favicon))
        {
            $data['favicon'] = $favicon->favicon;
        }
        else
        {
            $data['favicon'] = "";
        }

        View::theme('saruhanweb')->render('options',$data);
    }

    public function update()
    {
        if (Request::post())
        {
            $titles = Request::post('title');
            $descriptions = Request::post('description');

            $count = 0;
            foreach ($titles as $key => $title)
            {
                $control = Model::run('options','backend')->optionControl($key);
                if ($control)
                {
                    $data = [
                        'title' => $title,
                        'description' => $descriptions[$key],
                    ];
                    $update = Model::run('options','backend')->update($data,$key);
                    if ($update)
                    {
                        $count++;
                    }
                }
                else
                {
                    $data = [
                        'locale' => $key,
                        'title' => $title,
                        'description' => $descriptions[$key],
                    ];
                    $add = Model::run('options','backend')->add($data);
                    if ($add)
                    {
                        $count++;
                    }
                }
            }
            if ($count > 0)
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
    }

    public function addLogo()
    {
        if (Request::files())
        {
            $logo = Request::files('logo');
            if($logo['error'] == 0)
            {
                $name = $logo['name'];
                $type = $logo['type'];
                $tmp_name = $logo['tmp_name'];
                $error = $logo['error'];
                $size = $logo['size'];

                $mimeName = str_replace('.','',substr($name , -4));
                $title = str_replace(['.png','.jpg','.jpeg','.svg','.gif'],"",$name);
                $slug = slug($title);
                $seo = $slug.'.'.$mimeName;

                if ($logo['size'] > 2097152)
                {
                    $msg = lang('dashboard','file_max_size');
                    $result = [
                        'statu' => 'success',
                        'content' => $msg
                    ];
                    print_r(json_encode($result));
                    return false;
                }
                else
                {
                    Upload::init([
                        'allowed_types' => ['jpg','gif','png'], // izin verilen dosya tipi
                        'max_width'     => 500, // max. resim genişliği
                        'max_height'    => 500, // max. resim yüksekliği
                        'max_size'      => 2000, // max. dosya boyutu (kb)
                        'upload_path'   => public_path('upload') // upload dizini
                    ]);

                    Upload::file($_FILES["logo"]);
                    Upload::filename($seo);
                    $upload = Upload::handle();
                    if ($upload)
                    {
                        $data = [
                            'logo' => $seo
                        ];
                        $addLogo = Model::run('options','backend')->addLogo($data);
                        if ($addLogo)
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
                    else
                    {
                        $msg = lang('dashboard','no_file_upload');
                        $result = [
                            'statu' => 'success',
                            'content' => $msg
                        ];
                        print_r(json_encode($result));
                        return false;
                    }
                }
            }
        }
    }
    public function deleteLogo(){
        if (Request::post())
        {
            $action = Request::post('action');
            if ($action == "deleteLogo")
            {
                $logo = Model::run('options','backend')->logo();
                $delete = Model::run('options','backend')->deleteLogo();
                if ($delete)
                {
                    unlink('Public/upload/'.$logo->logo);
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
    }

    public function addFavicon()
    {
        if (Request::files())
        {
            $logo = Request::files('favicon');
            if($logo['error'] == 0)
            {
                $name = $logo['name'];
                $type = $logo['type'];
                $tmp_name = $logo['tmp_name'];
                $error = $logo['error'];
                $size = $logo['size'];

                $mimeName = str_replace('.','',substr($name , -4));
                $title = str_replace(['.png','.jpg','.jpeg','.svg','.gif'],"",$name);
                $slug = slug($title);
                $seo = $slug.'.'.$mimeName;

                if ($logo['size'] > 2097152)
                {
                    $msg = lang('dashboard','file_max_size');
                    $result = [
                        'statu' => 'success',
                        'content' => $msg
                    ];
                    print_r(json_encode($result));
                    return false;
                }
                else
                {
                    $this->image = new upload($logo);
                    if ($image->uploaded){

                        $image->file_new_name_body = "logo";
                        $image->file_max_size      = '2048576';
                        // $image->image_resize       = true;
                        // $image->image_y            = 16;
                        // $image->image_x            = 16;
                        // $image->image_convert      = 'png';
                        // $image->jpeg_quality       = 90;
                        $image->allowed            = array ( 'image/*' );
                        $image->Process('Public/upload');
                    }
                    else
                    {
                        echo 'sdfsdf';
                    }
                }
            }
        }
    }
    public function deleteFavicon(){
        if (Request::post())
        {
            $action = Request::post('action');
            if ($action == "deleteFavicon")
            {
                $favicon = Model::run('options','backend')->favicon();
                $delete = Model::run('options','backend')->deleteFavicon();
                if ($delete)
                {
                    unlink('Public/upload/'.$favicon->favicon);
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
    }
}