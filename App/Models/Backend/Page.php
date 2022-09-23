<?php

namespace App\Models\Backend;
use DB;

class Page
{
    public function page($ID)
    {
        $page = DB::table('page')
            ->where('page_id','=',$ID)
            ->getRow();
        if ($page)
        {
            $pageContent = DB::table('page_content')
                ->where('page_id','=',$page->page_id)
                ->getAll();
            foreach ($pageContent as $content)
            {
                $contentData[$content->locale]['title'] = $content->title;
                $contentData[$content->locale]['content'] = $content->content;
            }
            $page->content = $contentData;
            return $page;
        }
    }
    public function pages()
    {
        $pages = DB::select('*')
            ->table('page')
            ->getAll();
        if(!empty($pages))
        {
            foreach ($pages as $key => $page)
            {
                $locale = get_lang();
                $page->locale = $locale;
                $pageContent = DB::table('page_content')
                    ->where('locale','=',$locale)
                    ->where('page_id','=',$page->page_id)
                    ->getRow();
                $page->title = $pageContent->title;

                if ($page->category_id != 0)
                {
                    $category = DB::select('*')
                        ->table('page_category_content')
                        ->where('locale','=',$locale)
                        ->where('category_id','=',$page->category_id)
                        ->getRow();
                    $page->category = $category->title;
                }
                else
                {
                    $page->category = lang('dashboard','none');
                }

                $data['pages'][$key] = $page;
            }
            return $data['pages'];
        }
    }
    public function addPage($data)
    {
        $add = DB::table('page')->insert($data);
        if ($add)
        {
            return DB::lastInsertID();
        }
        else
        {
            return false;
        }
    }
    public function addContent($newData)
    {
        return DB::table('page_content')
            ->insert($newData);
    }
    public function editPage($data,$ID)
    {
        return DB::table('page')
            ->where('page_id','=',$ID)
            ->update($data);
    }
    public function editPageContent($newData)
    {
        $control = DB::table('page_content')
            ->where('page_id','=',$newData['page_id'])
            ->where('locale','=',$newData['locale'])
            ->getAll();
        if ($control)
        {
            $updateData = [
                'title' => $newData['title'],
                'seo' => slug($newData['title']),
                'content' => $newData['content'],
            ];
            $update = DB::table('page_content')
                ->where('page_id','=',$newData['page_id'])
                ->where('locale','=',$newData['locale'])
                ->update($updateData);
            return $update;
        }
        else
        {
            $add = DB::table('page_content')
                ->insert($newData);
            return $add;
        }
    }
    public function pageControl($seo)
    {
        return DB::select('*')
            ->table('page_content')
            ->where('seo','=',$seo)
            ->getAll();
    }
    public function pageControlNoID($seo,$ID)
    {
        return DB::select('*')
            ->table('page_content')
            ->where('page_id','!=',$ID)
            ->where('seo','=',$seo)
            ->getAll();
    }
    public function delete($ID)
    {
        $pageDelete = DB::table('page')->where('page_id','=',$ID)->delete();
        if ($pageDelete)
        {
            $pageContentDelete = DB::table('page_content')->where('page_id','=',$ID)->delete();
            if ($pageContentDelete)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }

    public function category($ID)
    {
        return DB::table('page_category')
            ->select('*')
            ->where('category_id','=',$ID)
            ->getRow();
    }
    public function categories(){
        $categories = DB::select('*')
            ->table('page_category')
            ->where('statu','=',1)
            ->getAll();
        if (!empty($categories))
        {
            $locale = get_lang();
            foreach ($categories as $key => $category)
            {
                $categoryContent = DB::select('*')
                    ->table('page_category_content')
                    ->where('locale','=',$locale)
                    ->where('category_id','=',$category->category_id)
                    ->getRow();
                $category->title = $categoryContent->title;
                $categories['categories'][$key] = $category;
            }
            return $categories['categories'];
        }
    }
    public function addPageCategory($data)
    {
        $add = DB::table('page_category')->insert($data);
        if ($add)
        {
            return DB::lastInsertID();
        }
        else
        {
            return false;
        }
    }
    public function addPageCategoryContent($newDataExt)
    {
        return DB::table('page_category_content')
            ->insert($newDataExt);
    }
    public function editPageCategory($data,$ID)
    {
        return DB::table('page_category')
            ->where('category_id','=',$ID)
            ->update($data);
    }
    public function editPageCategoryContent($newDataExt,$locale,$cat_ID)
    {
        $localeControl = DB::table('page_category_content')
            ->select('*')
            ->where('category_id','=',$cat_ID)
            ->where('locale','=',$locale)
            ->getRow();
        if (!empty($localeControl))
        {
            return DB::table('page_category_content')
                ->where('category_id','=',$cat_ID)
                ->where('locale','=',$locale)
                ->update($newDataExt);
        }
        else
        {
            $newDataExt['category_id'] = $cat_ID;
            $newDataExt['locale'] = $locale;
            return DB::table('page_category_content')
                ->insert($newDataExt);
        }

    }
    public function categoryContentControl($ID,$locale)
    {
        return DB::table('page_category_content')
            ->select('*')
            ->where('category_id','=',$ID)
            ->where('locale','=',$locale)
            ->getRow();
    }
    public function pageCategories(){
        return DB::select('*')
            ->table('page_category')
            ->getAll();
    }
    public function pageCategoryParent($category_ID,$locale){
        return DB::table('page_category_content')
            ->select('*')
            ->where('category_id','=',$category_ID)
            ->where('locale','=',$locale)
            ->getRow();
    }
    public function deletePageCategory($ID)
    {
        $categoryDelete = DB::table('page_category')->where('category_id','=',$ID)->delete();
        if ($categoryDelete)
        {
            $categoryContentDelete = DB::table('page_category_content')->where('category_id','=',$ID)->delete();
            if ($categoryContentDelete)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
    public function categoryList($ID)
    {
        return DB::table('page_category')
            ->select('*')
            ->where('category_id','!=',$ID)
            ->getAll();
    }
    public function categoryListTitle($ID,$locale)
    {
        return DB::table('page_category_content')
            ->select('*')
            ->where('category_id','=',$ID)
            ->where('locale','=',$locale)
            ->getRow();
    }
    public function categoryContent($ID)
    {
        return DB::table('page_category_content')
            ->where('category_id','=',$ID)
            ->getAll();
    }
    public function pageCategoryControl($seo)
    {
        return DB::select('*')
            ->table('page_category_content')
            ->where('seo','=',$seo)
            ->getAll();
    }
    public function pageCategoryControlNoID($seo,$ID)
    {
        return DB::select('*')
            ->table('page_category_content')
            ->where('category_id','!=',$ID)
            ->where('seo','=',$seo)
            ->getAll();
    }


}