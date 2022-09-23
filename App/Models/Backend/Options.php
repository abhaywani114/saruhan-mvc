<?php

namespace App\Models\Backend;

use DB;

class Options
{
    public function optionControl($locale)
    {
        return DB::table('options_content')
            ->where('locale','=',$locale)
            ->getAll();
    }
    public function optionsContent()
    {
        return DB::table('options_content')
            ->getAll();
    }
    public function update($data,$locale)
    {
        return DB::table('options_content')
            ->where('locale','=',$locale)
            ->update($data);
    }
    public function add($data)
    {
        return DB::table('options_content')->insert($data);
    }
    public function defaultSiteLang()
    {
        return DB::table('options')
            ->select('site_language')
            ->getRow();
    }

    public function defaultLang()
    {
        return DB::table('options')
            ->select('admin_language')
            ->getRow();
    }

    public function logo()
    {
        return DB::table('options')
            ->select('logo')
            ->getRow();
    }
    public function addLogo($data)
    {
        return DB::table('options')
            ->update($data);
    }
    public function deleteLogo()
    {
        $data = [
            'logo' => ''
        ];
        return DB::table('options')
            ->update($data);
    }

    public function favicon()
    {
        return DB::table('options')
            ->select('favicon')
            ->getRow();
    }
    public function addFavicon($data)
    {
        return DB::table('options')
            ->update($data);
    }
    public function deleteFavicon()
    {
        $data = [
            'favicon' => ''
        ];
        return DB::table('options')
            ->update($data);
    }
}