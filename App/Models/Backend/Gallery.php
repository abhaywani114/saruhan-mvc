<?php

namespace App\Models\Backend;
use DB;

class Gallery
{
    //gallery
    public function gallery($ID)
    {
        $gallery =  DB::table('gallery')->where('gallery_id','=',$ID)->getRow();

        if ($gallery) {
            $galleryContent = DB::table('gallery_content')->where('gallery_id','=',$ID)->getAll();
            foreach ($galleryContent as $galValue)
            {
                $contentData[$galValue->locale] = [
                    'title' => $galValue->title,
                    'description' => $galValue->description,
                    'url' => $galValue->url
                ];
                $gallery->content = $contentData;
            }
            return $gallery;
        }
    }

    public function editGallery($ID,$data)
    {
        return DB::table('gallery')
            ->where('gallery_id','=',$ID)
            ->update($data);
    }
    public function editGalleryContent($ID,$locale,$newData)
    {
        $control = DB::table('gallery_content')
            ->where('gallery_id','=',$ID)
            ->where('locale','=',$locale)
            ->getAll();
        if ($control)
        {
            return DB::table('gallery_content')
                ->where('gallery_id','=',$ID)
                ->where('locale','=',$locale)
                ->update($newData);
        }
        else
        {
            $newData['gallery_id'] = $ID;
            $newData['locale'] = $locale;
            return DB::table('gallery_content')
                ->insert($newData);
        }
    }

    //galleryList
    public function galleryList()
    {
        return DB::table('gallery')->orderBy('gallery_id', 'desc')->getAll();
    }
    public function addGallery($data)
    {
        $add = DB::table('gallery')->insert($data);
        if ($add)
        {
            return DB::lastInsertID();
        }
        else
        {
            return false;
        }
    }

    public function addGalleryContent($newData)
    {
        return DB::table('gallery_content')->insert($newData);
    }
    //gallery-category
    public function galleryCategory($ID)
    {
        $category = DB::table('gallery_category')->where('id','=',$ID)->getRow();
        if ($category)
        {
            $categoryContent = DB::table('gallery_category_content')->where('category_id','=',$ID)->getAll();
            foreach ($categoryContent as $categoryContent)
            {
                $contentData[$categoryContent->locale] = [
                    'title' => $categoryContent->title,
                    'description' => $categoryContent->description
                ];
                $category->content = $contentData;
            }
            return $category;
        }
    }
    public function galleryCategories()
    {
        $categories = DB::table('gallery_category')->getAll();
        if ($categories > 0)
        {
            foreach ($categories as $category)
            {
                $locale = get_lang();
                $content = DB::table('gallery_category_content')->where('category_id','=',$category->id)->where('locale','=',$locale)->getRow();
                $category->title = $content->title;
                $parent = DB::table('gallery_category')->where('id','=',$category->parent_id)->getRow();
                if ($parent)
                {
                    $parentTitle = DB::table('gallery_category_content')->where('category_id','=',$parent->id)->where('locale','=',$locale)->getRow();
                    $category->parent = $parentTitle->title;
                }
                else
                {
                    $category->parent = lang('dashboard','none');
                }
            }
            return $categories;
        }
    }
    public function galleryCategoryControl($seo)
    {
        return DB::table('gallery_category_content')->where('seo','=',$seo)->getAll();
    }
    public function galleryCategoryControlNoID($seo,$ID)
    {
        return DB::table('gallery_category_content')->where('category_id','!=',$ID)->where('seo','=',$seo)->getRow();
    }

    public function galleryCategoryNoID($ID)
    {
        $categories = DB::table('gallery_category')->where('id','!=',$ID)->getAll();
        if ($categories > 0)
        {
            foreach ($categories as $category)
            {
                $locale = get_lang();
                $content = DB::table('gallery_category_content')->where('category_id','=',$category->id)->where('locale','=',$locale)->getRow();
                $category->title = $content->title;
                $parent = DB::table('gallery_category')->where('id','=',$category->parent_id)->getRow();
                if ($parent)
                {
                    $parentTitle = DB::table('gallery_category_content')->where('category_id','=',$parent->id)->where('locale','=',$locale)->getRow();
                    $category->parent = $parentTitle->title;
                }
                else
                {
                    $category->parent = lang('dashboard','none');
                }
            }
            return $categories;
        }
    }
    public function addGalleryCategory($data)
    {
        $add = DB::table('gallery_category')->insert($data);
        if ($add)
        {
            return DB::lastInsertID();
        }
        else
        {
            return false;
        }
    }
    public function addGalleryCategoryContent($contentData)
    {
        return DB::table('gallery_category_content')->insert($contentData);
    }
    public function deleteGalleryCategory($ID)
    {
        $delete = DB::table('gallery_category')->where('id','=',$ID)->delete();
        if ($delete)
        {
            $deleteContent = DB::table('gallery_category_content')->where('category_id','=',$ID)->delete();
            if ($deleteContent)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }

    public function editGalleryCategory($data,$ID)
    {
        return DB::table('gallery_category')
            ->where('id','=',$ID)
            ->update($data);
    }
    public function editGalleryCategoryContent($ID,$locale,$contentData)
    {
        return DB::table('gallery_category_content')
            ->where('category_id', '=', $ID)
            ->where('locale', '=', $locale)
            ->update($contentData);
    }
    //video
    public function video($ID)
    {
        $video = DB::table('video')
            ->where('id','=',$ID)
            ->getRow();
        if ($video)
        {
            $contents = DB::table('video_content')
                ->where('video_id','=',$ID)
                ->getAll();
            foreach ($contents as $content)
            {
                $contentData[$content->locale]['title'] = $content->title;
            }
            $video->title = $contentData;
            return $video;
        }
    }
    public function videos()
    {
        $videos = DB::table('video')->getAll();
        if ($videos)
        {
            foreach($videos as $key => $video)
            {
                $content = DB::table('video_content')->where('video_id','=',$video->id)->getRow();
                $video->title = $content->title;
            }
            return $videos;
        }
    }
    public function videoControl($embed)
    {
        return DB::table('video')
            ->where('embed','=',$embed)
            ->getAll();
    }
    public function addVideo($data)
    {
        $add = DB::table('video')->insert($data);
        if ($add)
        {
            return DB::lastInsertID();
        }
        else
        {
            return false;
        }
    }
    public function addVideoContent($newData)
    {
        return DB::table('video_content')
            ->insert($newData);
    }
    public function editVideo($data,$ID)
    {
        return DB::table('video')
            ->where('id','=',$ID)
            ->update($data);
    }
    public function editVideoContent($contentData,$locale,$ID)
    {
        $control = DB::table('video_content')
            ->where('video_id','=',$ID)
            ->where('locale','=',$locale)
            ->getAll();
        if ($control)
        {
            return DB::table('video_content')
                ->where('video_id','=',$ID)
                ->where('locale','=',$locale)
                ->update($contentData);
        }
        else
        {
            $contentData['video_id'] = $ID;
            $contentData['locale'] = $locale;
            return DB::table('video_content')
                ->where('video_id','=',$ID)
                ->insert($contentData);
        }
    }
    public function deleteVideo($ID)
    {
        $deleteVideo = DB::table('video')->where('id','=',$ID)->delete();
        if($deleteVideo)
        {
            $deleteVideoContent = DB::table('video_content')->where('video_id','=',$ID)->delete();
            if ($deleteVideoContent)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
    }
}