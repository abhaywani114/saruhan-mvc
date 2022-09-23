<?php

namespace App\Controllers\Backend;

use System\Facades\Request;
use System\Kernel\Controller;
use Model;
use View;

class Page extends Controller
{
    public function index(){
        $languages = Model::run('languages','backend')->languages();
        $data = $languages;

        $pages = Model::run('page', 'backend')->pages();
        $data['pages'] = $pages;

        View::theme('saruhanweb')->render('page',$data);
    }
    public function add(){
        if (Request::post())
        {
            $category_id = Request::post('category_id');
            $order_id = Request::post('order_id');
            $statu = Request::post('statu');
            $titles = Request::post('title');
            $contents = Request::post('content');

            $sameControl = array_count_values($titles);
            foreach ($sameControl as $same)
            {
                if ($same > 1)
                {
                    $title = lang('dashboard','warning_title');
                    $msg = lang('dashboard','add_page_seo_warning');
                    $result = [
                        'statu' => 'warning',
                        'title' => $title,
                        'text' => $msg
                    ];
                    print_r(json_encode($result));
                    return false;
                }
            }
            $controlCount = 0;
            foreach ($titles as $title)
            {
                $pageControl = Model::run('page','backend')->pageControl(slug($title));
                if (!$pageControl)
                {
                    $controlCount++;
                }
                else
                {
                    $title = lang('dashboard','warning_title');
                    $msg = lang('dashboard','add_warning');
                    $result = [
                        'statu' => 'warning',
                        'title' => $title,
                        'text' => $msg
                    ];
                    print_r(json_encode($result));
                    return false;
                }
            }
            if ($controlCount != count($titles))
            {
                return false;
            }
            if ($order_id == "")
            {
                $order_id = 0;
            }
            $data = [
                'category_id' => $category_id,
                'order_id' => $order_id,
                'statu' => $statu,
                'type' => 'page'
            ];
            $addPage = Model::run('page','backend')->addPage($data);
            if (!empty($addPage))
            {
                $addContentCount = 0;
                foreach ($titles as $key => $title)
                {
                    $newData = [
                        'page_id' => $addPage,
                        'locale' => $key,
                        'title' => $title,
                        'seo' => slug($title),
                        'content' => $contents[$key],
                    ];
                    $addContent = Model::run('page','backend')->addContent($newData);
                    if ($addContent)
                    {
                        $addContentCount++;
                    }
                }
                if ($addContentCount == count($titles))
                {
                    $title = lang('dashboard','success_title');
                    $msg = lang('dashboard','add_success');
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
                $title = lang('dashboard','error_title');
                $msg = lang('dashboard','add_error');
                $result = [
                    'statu' => 'error',
                    'title' => $title,
                    'text' => $msg
                ];
                print_r(json_encode($result));
                return false;
            }
        }
        else
        {
            $languages = Model::run('languages', 'backend')->languages();
            $data = $languages;

            $categories = Model::run('page','backend')->categories();
            $data['categories'] = $categories;

            View::theme('saruhanweb')->render('addPage', $data);
        }
    }
    public function editPage($ID){

        if (Request::post())
        {
            $category_id = Request::post('category_id');
            $order_id = Request::post('order_id');
            $statu = Request::post('statu');
            $titles = Request::post('title');
            $contents = Request::post('content');

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
                $pageControl = Model::run('page','backend')->pageControlNoID(slug($title),$ID);
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
            $data = [
                'category_id' => $category_id,
                'order_id' => $order_id,
                'statu' => $statu
            ];

            $editPage = Model::run('page','backend')->editPage($data,$ID);

            $editContentCount = 0;
            foreach ($titles as $key => $title)
            {
                $newData = [
                    'page_id' => $ID,
                    'locale' => $key,
                    'title' => $title,
                    'seo' => slug($title),
                    'content' => $contents[$key],
                ];
                $editContent = Model::run('page','backend')->editPageContent($newData);
                if ($editContent)
                {
                    $editContentCount++;
                }
            }

            if ($editPage OR ($editContentCount == count($titles)))
            {
                $title = lang('dashboard','success_title');
                $msg = lang('dashboard','edit_success');
                $result = [
                    'statu' => 'success',
                    'title' => $title,
                    'text' => $msg,
                ];
                print_r(json_encode($result));
                return false;
            }
            else
            {
                $title = lang('dashboard','error_title');
                $msg = lang('dashboard','add_error');
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
            $page = Model::run('page','backend')->page($ID);

            $languages = Model::run('languages','backend')->languages();
            $data = $languages;

            $data['page_id'] = $page->page_id;
            $data['category_id'] = $page->category_id;
            $data['order_id'] = $page->order_id;
            $data['statu'] = $page->statu;
            $data['content'] = $page->content;

            foreach ($data['langs'] as $key => $lang)
            {
                if(empty($data['content'][$lang->seo]))
                {
                    $data['content'][$lang->seo] = [
                        'title' => '',
                        'content' => ''
                    ];
                }
            }
            $categories = Model::run('page','backend')->categories();
            $data['categories'] = $categories;

            View::theme('saruhanweb')->render('editPage',$data);
        }
    }
    public function delete()
    {
        $ID = Request::post('ID');

        $delete = Model::run('page','backend')->delete($ID);
        if ($delete)
        {
            $title = lang('dashboard','success_title');
            $msg = lang('dashboard','delete_success');
            $result = [
                'statu' => 'success',
                'title' => $title,
                'text' => $msg,
            ];
            print_r(json_encode($result));
            return false;
        }
        else
        {
            $title = lang('dashboard','error_title');
            $msg = lang('dashboard','delete_error');
            $result = [
                'statu' => 'success',
                'title' => $title,
                'text' => $msg,
            ];
            print_r(json_encode($result));
            return false;
        }

    }

    public function addPageCategory(){

        if (Request::post())
        {

            $parent_id = Request::post('parent_id');
            $order_id = Request::post('order_id');
            $statu = Request::post('statu');
            $titles = Request::post('title');
            $contents = Request::post('content');

            $sameControl = array_count_values($titles);
            foreach ($sameControl as $same)
            {
                if ($same > 1)
                {
                    $title = lang('dashboard','warning_title');
                    $msg = lang('dashboard','add_page_seo_warning');
                    $result = [
                        'statu' => 'warning',
                        'title' => $title,
                        'text' => $msg
                    ];
                    print_r(json_encode($result));
                    return false;
                }
            }
            $controlCount = 0;
            foreach ($titles as $title)
            {
                $pageControl = Model::run('page','backend')->pageCategoryControl(slug($title));
                if (!$pageControl)
                {
                    $controlCount++;
                }
                else
                {
                    $title = lang('dashboard','warning_title');
                    $msg = lang('dashboard','add_warning');
                    $result = [
                        'statu' => 'warning',
                        'title' => $title,
                        'text' => $msg
                    ];
                    print_r(json_encode($result));
                    return false;
                }
            }

            if ($order_id == "")
            {
                $order_id = 0;
            }

            $data = [
                'parent_id' => $parent_id,
                'order_id' => $order_id,
                'statu' => $statu
            ];

            $addCategory = Model::run('page','backend')->addPageCategory($data);
            if ($addCategory)
            {
                foreach ($titles as $key => $title)
                {
                    $dataExt[$key]['category_id'] = $addCategory;
                    $dataExt[$key]['locale'] = $key;
                    $dataExt[$key]['title'] = $title;
                    $dataExt[$key]['seo'] = slug($title);
                    $dataExt[$key]['content'] = $contents[$key];
                }
                $addCount = 0;
                foreach($dataExt as $key => $dataValue)
                {
                    $newDataExt = [
                        'category_id' => $dataExt[$key]['category_id'],
                        'locale' => $dataExt[$key]['locale'],
                        'title' => $dataExt[$key]['title'],
                        'seo' => $dataExt[$key]['seo'],
                        'content' => $dataExt[$key]['content']
                    ];
                    $addPageContent = Model::run('page', 'backend')->addPageCategoryContent($newDataExt);
                    if ($addPageContent)
                    {
                        $addCount = $addCount + 1;
                    }
                    else
                    {
                        $addCount = $addCount;
                    }
                }
                if (count($dataExt) == $addCount)
                {
                    $title = lang('dashboard','success_title');
                    $msg = lang('dashboard','add_success');
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
                    $msg = lang('dashboard','add_error');
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
        else
        {
            $languages = Model::run('languages', 'backend')->languages();
            $data = $languages;

            $categories = Model::run('page', 'backend')->pageCategories();
            if (!empty($categories))
            {
                $locale = get_lang();
                foreach ($categories as $key => $category)
                {
                    $parent = Model::run('page','backend')->pageCategoryParent($category->category_id,$locale);
                    if (!empty($parent))
                    {
                        $category->title = $parent->title;
                    }
                    $data['categories'][$key] = $category;
                }
            }
            $categoryList = Model::run('page','backend')->categoryList(0);
            if (!empty($categoryList))
            {
                $locale = get_lang();
                foreach ($categoryList as $key => $cat)
                {
                    $categoryListTitle = Model::run('page','backend')->categoryListTitle($cat->category_id,$locale);
                    if (!empty($categoryListTitle))
                    {
                        $categoryListTitle = $categoryListTitle->title;
                    }

                    $catListData[] = [
                        'category_id' => $cat->category_id,
                        'title' => $categoryListTitle,
                    ];
                }
                $data['category_list'] = $catListData;
            }
            View::theme('saruhanweb')->render('pageCategory',$data);
        }
    }
    public function editPageCategory($ID){

        if (Request::post())
        {
            $parent_id = Request::post('parent_id');
            $order_id = Request::post('order_id');
            $statu = Request::post('statu');
            $titles = Request::post('title');
            $contents = Request::post('content');

            $sameControl = array_count_values($titles);
            foreach ($sameControl as $same)
            {
                if ($same > 1)
                {
                    $title = lang('dashboard','warning_title');
                    $msg = lang('dashboard','add_page_seo_warning');
                    $result = [
                        'statu' => 'warning',
                        'title' => $title,
                        'text' => $msg
                    ];
                    print_r(json_encode($result));
                    return false;
                }
            }
            $controlCount = 0;
            foreach ($titles as $title)
            {
                $pageControl = Model::run('page','backend')->pageCategoryControlNoID(slug($title),$ID);
                if (!$pageControl)
                {
                    $controlCount++;
                }
                else
                {
                    $title = lang('dashboard','warning_title');
                    $msg = lang('dashboard','add_warning');
                    $result = [
                        'statu' => 'warning',
                        'title' => $title,
                        'text' => $msg
                    ];
                    print_r(json_encode($result));
                    return false;
                }
            }
            if ($order_id == "")
            {
                $order_id = 0;
            }
            $data = [
                'parent_id' => $parent_id,
                'order_id' => $order_id,
                'statu' => $statu
            ];
            $edit = Model::run('page','backend')->editPageCategory($data,$ID);

            if (!empty(Request::post('title')) OR !empty(Request::post('content')) )
            {
                foreach ($titles as $key => $title)
                {
                    $dataExt[$key]['category_id'] = $ID;
                    $dataExt[$key]['locale'] = $key;
                    $dataExt[$key]['title'] = $title;
                    $dataExt[$key]['seo'] = slug($title);
                    $dataExt[$key]['content'] = $contents[$key];
                }
                $editCount = 0;
                foreach($dataExt as $key => $dataValue)
                {
                    $newDataExt = [
                        'title' => $dataExt[$key]['title'],
                        'seo' => $dataExt[$key]['seo'],
                        'content' => $dataExt[$key]['content']
                    ];
                    $cat_ID = $dataExt[$key]['category_id'];
                    $locale = $dataExt[$key]['locale'];

                    $editContent = Model::run('page', 'backend')->editPageCategoryContent($newDataExt,$locale,$cat_ID);
                    if ($editContent)
                    {
                        $editCount = $editCount + 1;
                    }
                    else
                    {
                        $editCount = $editCount;
                    }
                }
            }
            if($edit OR $editCount > 0)
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
        else
        {
            $languages = Model::run('languages', 'backend')->languages();
            $data = $languages;

            $category = Model::run('page','backend')->category($ID);

            foreach ($languages['langs'] as $lang)
            {
                $locale = $lang->seo;
                $contentControl = Model::run('page','backend')->categoryContentControl($ID,$locale);
                if (empty($contentControl))
                {
                    $newData[$lang->seo]['title'] = '';
                    $newData[$lang->seo]['content'] = '';
                }
            }
            $categoryContent = Model::run('page','backend')->categoryContent($ID);
            foreach ($categoryContent as $content)
            {
                $newData[$content->locale]['title'] = $content->title;
                $newData[$content->locale]['content'] = $content->content;
            }
            $data['category_content'] = $newData;
            $data['ID'] = $category->category_id;
            $data['parent_id'] = $category->parent_id;
            $data['order_id'] = $category->order_id;
            $data['statu'] = $category->statu;

            $categoryList = Model::run('page','backend')->categoryList(0);
            if (!empty($categoryList))
            {
                $locale = get_lang();
                foreach ($categoryList as $key => $cat)
                {
                    $categoryListTitle = Model::run('page','backend')->categoryListTitle($cat->category_id,$locale);
                    if (!empty($categoryListTitle))
                    {
                        $categoryListTitle = $categoryListTitle->title;
                    }

                    $catListData[] = [
                        'category_id' => $cat->category_id,
                        'title' => $categoryListTitle,
                    ];
                }
                $data['category_list'] = $catListData;
            }
            View::theme('saruhanweb')->render('editPageCategory',$data);
        }
    }
    public function deletePageCategory()
    {
        $ID = Request::post('ID');
        $delete = Model::run('page','backend')->deletePageCategory($ID);
        if ($delete)
        {
            $title = lang('dashboard','success_title');
            $msg = lang('dashboard','delete_success');
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
            $msg = lang('dashboard','delete_error');
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