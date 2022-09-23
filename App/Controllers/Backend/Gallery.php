<?php

namespace App\Controllers\Backend;

use System\Facades\Request;
use System\Facades\Upload;
use System\Kernel\Controller;
use View;
use Model;
use System\Libs\Verot\Verot;

class Gallery extends Controller
{
    public function index(){
    }
    public function editGallery($ID)
    {
        if (Request::post()) {
            $titles = Request::post('title');
            $descriptions = Request::post('description');
            $urls = Request::post('url');
            $category_id = Request::post('category_id');
            $order_id = Request::post('order_id');

            $sameControl = array_count_values($titles);
            foreach ($sameControl as $same)
            {
                if ($same > 1)
                {
                    $msg = lang('dashboard','add_page_seo_warning');
                    $msgTitle = lang('dashboard','warning_title');
                    $result = [
                        'statu' => 'warning',
                        'title' => $msgTitle,
                        'content' => $msg
                    ];
                    print_r(json_encode($result));
                    return false;
                }
            }

            $data = [
                'category_id' => $category_id,
                'order_id' => $order_id,
            ];
            
            $editGallery = Model::run('gallery','backend')->editGallery($ID,$data);
            
            $editGalleryContentCount = 0;
            foreach ($titles as $key => $title)
            {
                $newData = [
                    'title' => $title,
                    'seo' => slug($title),
                    'description' => $descriptions[$key],
                    'url' => $urls[$key],
                ];
                $editGalleryContent = Model::run('gallery','backend')->editGalleryContent($ID,$key,$newData);
                if ($editGalleryContent)
                {
                    $editGalleryContentCount++;
                }
            }

            if ($editGallery == 1 OR $editGalleryContentCount > 0)
            {
                $msg = lang('dashboard','edit_success');
                $title = lang('dashboard','success_title');
                $result = [
                    'statu' => 'success',
                    'title' => $title,
                    'content' => $msg
                ];
                print_r(json_encode($result));
                return false;
            }
            else
            {
                $msg = lang('dashboard','edit_error');
                $title = lang('dashboard','error_title');
                $result = [
                    'statu' => 'danger',
                    'title' => $title,
                    'content' => $msg
                ];
                print_r(json_encode($result));
                return false;
            }

            
        }
        else{
            $languages = Model::run('languages','backend')->languages();
            $data = $languages;
            $data['categories'] = Model::run('gallery','backend')->galleryCategories();
            $data['gallery'] = Model::run('gallery','backend')->gallery($ID);
            foreach ($data['langs'] as $key => $lang)
            {
                if(empty($data['gallery']->content[$lang->seo]))
                {
                    $data['gallery']->content[$lang->seo] = [
                        'title' => '',
                        'description' => '',
                        'url' => ''
                    ];
                }
            }
            View::theme('saruhanweb')->render('editGallery',$data);
        }
    }

    public function addGallery()
    {
        if (Request::post())
        {
            $titles = Request::post('title');
            $category_id = Request::post('category_id');

            $sameControl = array_count_values($titles);
            foreach ($sameControl as $same)
            {
                if ($same > 1)
                {
                    $msg = lang('dashboard','add_page_seo_warning');
                    $msgTitle = lang('dashboard','warning_title');
                    $result = [
                        'statu' => 'warning',
                        'title' => $msgTitle,
                        'content' => $msg
                    ];
                    print_r(json_encode($result));
                    return false;
                }
            }

            $files = Request::files('file');
            $addContent = "";
            $addGalleryContentCount = 0;
            foreach ($files['error'] as $key => $file)
            {
                if ($file == UPLOAD_ERR_OK)
                {
                    $name = $files['name'][$key];
                    $type = $files['type'][$key];
                    $tmp_name = $files['tmp_name'][$key];
                    $error = $files['error'][$key];
                    $size = $files['size'][$key];

                    $fileData = ['name' => $name, 'type' => $type, 'tmp_name' => $tmp_name, 'error' => $error, 'size' => $size];
                    $foo = new Verot($fileData);
                    $foo->start_verot($fileData,"en_GB");

                    if ($foo->uploaded)
                    {
                        //$foo->file_max_size = '20971520'; // 20MB
                        $foo->file_max_size = '2097152'; // 2MB
                        $foo->allowed        = array ( 'image/*' );
                        $foo->process(public_path('/upload'));
                        if ($foo->processed)
                        {
                            $image_name = $foo->file_dst_name;
                            $data = [
                                'name' => $image_name,
                                'category_id' => $category_id,
                            ];
                            $addGallery = Model::run('gallery','backend')->addGallery($data);
                            if ($addGallery)
                            {
                                foreach ($titles as $key => $title)
                                {
                                    $newData = [
                                        'gallery_id' => $addGallery,
                                        'locale' => $key,
                                        'title' => $title,
                                        'seo' => slug($title),
                                    ];
                                    $addGalleryContent = Model::run('gallery','backend')->addGalleryContent($newData);
                                    if ($addGalleryContent)
                                    {
                                        $addGalleryContentCount++;
                                    }
                                }
                                $addContent.= '<span class="alert-success">'.$image_name.'</span>';
                            }
                        }
                        else
                        {
                            $addContent.= '<span class="alert-danger">'.$foo->error.'</span>';
                        }
                    }
                    else
                    {
                        $addContent.= '<span class="alert-danger">'.$name.'</span>';
                    }
                }
                else{
                    $addContent.= '<span class="alert-danger">'.$files['name'][$key].'</span>';
                }
            }

            $result = [
                'statu' => 'success',
                'title' => lang('dashboard','upload_complete'),
                'content' => $addContent
            ];
            print_r(json_encode($result));
            return false;
        }
        else
        {
            $languages = Model::run('languages','backend')->languages();
            $data = $languages;
            $categories = Model::run('gallery','backend')->galleryCategories();
            $data['categories'] = $categories;

            $gallery = Model::run('gallery','backend')->galleryList();
            $data['gallery'] = $gallery;

            View::theme('saruhanweb')->render('gallery',$data);
        }
    }

    //gallery-category
    public function galleryCategory()
    {
        $languages = Model::run('languages','backend')->languages();
        $data = $languages;

        $galleryCategories = Model::run('gallery','backend')->galleryCategories();
        $data['categories'] = $galleryCategories;

        View::theme('saruhanweb')->render('galleryCategory',$data);
    }
    public function addGalleryCategory()
    {
        if (Request::post())
        {
            $parent_id = Request::post('parent_id');
            $order_id = Request::post('order_id');
            $statu = Request::post('statu');
            $titles = Request::post('title');
            $descriptions = Request::post('description');

            $sameControl = array_count_values($titles);
            foreach ($sameControl as $same)
            {
                if ($same > 1)
                {
                    $msg = lang('dashboard','add_page_seo_warning');
                    $result = [
                        'statu' => 'warning',
                        'content' => $msg
                    ];
                    print_r(json_encode($result));
                    return false;
                }
            }
            $controlCount = 0;
            foreach ($titles as $title)
            {
                $pageControl = Model::run('gallery','backend')->galleryCategoryControl(slug($title));
                if (!$pageControl)
                {
                    $controlCount++;
                }
                else
                {
                    $msg = lang('dashboard','add_warning');
                    $result = [
                        'statu' => 'warning',
                        'content' => $msg
                    ];
                    print_r(json_encode($result));
                    return false;
                }
            }
            if ($controlCount != count($titles))
            {
                return false;
            }
            if (empty($order_id))
            {
                $order_id = 0;
            }
            $data = [
                'parent_id' => $parent_id,
                'order_id' => $order_id,
                'statu' => $statu
            ];
            $addCategory = Model::run('gallery','backend')->addGalleryCategory($data);
            if ($addCategory)
            {
                $contentCount = 0;
                foreach ($titles as $key => $title)
                {
                    $contentData = [
                        'category_id' => $addCategory,
                        'locale' => $key,
                        'title' => $title,
                        'seo' => slug($title),
                        'description' => $descriptions[$key]
                    ];
                    $addContent = Model::run('gallery','backend')->addGalleryCategoryContent($contentData);
                    if ($addContent)
                    {
                        $contentCount++;
                    }
                }
                if ($contentCount == count($titles))
                {
                    $msg = lang('dashboard','add_success');
                    $result = [
                        'statu' => 'success',
                        'content' => $msg,
                    ];
                    print_r(json_encode($result));
                    return false;
                }
                else
                {
                    $msg = lang('dashboard','public_error');
                    $result = [
                        'statu' => 'error',
                        'content' => $msg,
                    ];
                    print_r(json_encode($result));
                    return false;
                }
            }
            else
            {
                $msg = lang('dashboard','add_error');
                $result = [
                    'statu' => 'error',
                    'content' => $msg,
                ];
                print_r(json_encode($result));
                return false;
            }
        }
    }
    public function editGalleryCategory($ID)
    {
        if (Request::post())
        {
            $parent_id = Request::post('parent_id');
            $order_id = Request::post('order_id');
            $statu = Request::post('statu');
            $titles = Request::post('title');
            $descriptions = Request::post('description');

            $sameControl = array_count_values($titles);
            foreach ($sameControl as $same)
            {
                if ($same > 1)
                {
                    $msg = lang('dashboard','add_page_seo_warning');
                    $result = [
                        'statu' => 'warning',
                        'content' => $msg
                    ];
                    print_r(json_encode($result));
                    return false;
                }
            }
            foreach($titles as $title)
            {
                $control = Model::run('gallery','backend')->galleryCategoryControlNoID(slug($title),$ID);
                if ($control)
                {
                    $msg = lang('dashboard','add_warning');
                    $result = [
                        'statu' => 'warning',
                        'content' => $msg
                    ];
                    print_r(json_encode($result));
                    return false;
                }
            }
            if (!empty($parent_id) OR !empty($order_id) OR !empty($statu))
            {
                $data = [
                    'parent_id' => $parent_id,
                    'order_id' => $order_id,
                    'statu' => $statu
                ];
                $edit = Model::run('gallery','backend')->editGalleryCategory($data,$ID);
            }
            if (!empty($titles) OR !empty($descriptions))
            {
                $contentCount = 0;
                foreach ($titles as $key => $title)
                {
                    $contentData = [
                        'title' => $title,
                        'seo' => slug($title),
                        'description' => $descriptions[$key]
                    ];
                    $editContent = Model::run('gallery','backend')->editGalleryCategoryContent($ID,$key,$contentData);
                    if ($editContent)
                    {
                        $contentCount++;
                    }
                }
            }
            if ($edit = 1 OR ($contentCount>0))
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
            $category = Model::run('gallery','backend')->galleryCategory($ID);

            $data['id'] = $category->id;
            $data['parent_id'] = $category->parent_id;
            $data['order_id'] = $category->order_id;
            $data['statu'] = $category->statu;
            $data['content'] = $category->content;

            $categories = Model::run('gallery','backend')->galleryCategoryNoID($category->id);
            $data['categories'] = $categories;

            View::theme('saruhanweb')->render('editGalleryCategory',$data);
        }
    }
    public function deleteGalleryCategory()
    {
        $ID = Request::post('ID');
        $delete = Model::run('gallery','backend')->deleteGalleryCategory($ID);
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

    //video
    public function videoGallery()
    {
        $languages = Model::run('languages','backend')->languages();
        $data = $languages;

        $videos = Model::run('gallery','backend')->videos();
        $data['videos'] = $videos;
        View::theme('saruhanweb')->render('videoGallery',$data);
    }
    public function addVideo()
    {
        if (Request::post())
        {
            $url = Request::post('url');
            $urlReplace = str_replace("https://www.youtube.com/watch?v=","",$url);
            $embedEx = explode("&",$urlReplace);
            $embed = $embedEx[0];
            $order_id = Request::post('order_id');
            $statu = Request::post('statu');

            $control = Model::run('gallery','backend')->videoControl($embed);
            if ($control)
            {
                $msg = lang('dashboard','video_control_msg');
                $result = [
                    'statu' => 'warning',
                    'content' => $msg
                ];
                print_r(json_encode($result));
                return false;
            }
            $data = [
                'embed' => $embed,
                'order_id' => $order_id,
                'statu' => $statu
            ];
            $add = Model::run('gallery','backend')->addVideo($data);
            if ($add)
            {
                $titles = Request::post('title');
                $addCount = 0;
                foreach ($titles as $key => $title)
                {
                    $newData = [
                        'video_id' => $add,
                        'locale' => $key,
                        'title' => $title,
                        'seo' => slug($title)
                    ];
                    $addContent = Model::run('gallery','backend')->addVideoContent($newData);
                    if ($addContent)
                    {
                        $addCount++;
                    }
                }
                if ($addCount == count($titles))
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
                    $msg = lang('dashboard','public_error');
                    $result = [
                        'statu' => 'success',
                        'content' => $msg
                    ];
                    print_r(json_encode($result));
                    return false;
                }
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
    public function editVideo($ID)
    {
        if (Request::post())
        {
            $titles = Request::post('title');
            $order_id = Request::post('order_id');
            $statu = Request::post('statu');

            if (!empty($order_id) OR !empty($statu))
            {
                $data = [
                    'order_id' => $order_id,
                    'statu' => $statu
                ];
                $updateVideo = Model::run('Gallery','backend')->editVideo($data,$ID);
            }
            if (!empty($titles))
            {
                $updateCount = 0;
                foreach ($titles as $key => $title)
                {
                    $contentData = [
                        'title' => $title,
                        'seo' => slug($title)
                    ];
                    $updateContent = Model::run('Gallery','backend')->editVideoContent($contentData,$key,$ID);
                    if ($updateContent)
                    {
                        $updateCount++;
                    }
                }
            }
            if ($updateVideo OR ($updateCount > 0))
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

            $video = Model::run('gallery','backend')->video($ID);
            $data['id'] = $video->id;
            $data['embed'] = $video->embed;
            $data['order_id'] = $video->order_id;
            $data['statu'] = $video->statu;
            $data['title'] = $video->title;

            foreach ($data['langs'] as $key => $lang)
            {
                if(empty($data['title'][$lang->seo]))
                {
                    $data['title'][$lang->seo] = [
                        'title' => ''
                    ];
                }
            }
            View::theme('saruhanweb')->render('editVideo',$data);
        }
    }
    public function deleteVideo()
    {
        $ID = Request::post('ID');
        $delete = Model::run('gallery','backend')->deleteVideo($ID);
        if ($delete)
        {
            $msg = lang('dashboard','delete_success');
            $result = [
                'statu' => 'success',
                'content' => $msg
            ];
        }
        else
        {
            $msg = lang('dashboard','delete_error');
            $result = [
                'statu' => 'error',
                'content' => $msg
            ];
        }
        print_r(json_encode($result));
        return false;
    }
}