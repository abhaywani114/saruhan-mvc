<?php

namespace App\Models\Backend;
use DB;
class Languages
{
    public function languageList()
    {
        $languages = DB::select('*')
            ->table('languages')
            ->getAll();
        if (!empty($languages))
        {
            foreach ($languages as $key => $lang)
            {
                $data['langs'][$key] = $lang;
            }
        }
        else
        {
            $data['langs'] = "";
        }
        return $data;
    }
    public function lang($ID)
    {
        return DB::table('languages')->select('*')->where('id','=',$ID)->getRow();
    }
    public function add($data)
    {
        return DB::table('languages')->insert($data);
    }
    public function edit($ID,$data){
        return DB::table('languages')->where('id','=',$ID)->update($data);
    }
    public function delete($ID)
    {
        return DB::table('languages')->where('id','=',$ID)->delete();
    }
    public function languages()
    {
        $languages = DB::select('*')
            ->table('languages')
            ->where('statu','=',1)
            ->getAll();

        if (!empty($languages))
        {
            foreach ($languages as $key => $lang)
            {
                $data['langs'][$key] = $lang;
            }
        }
        else
        {
            $data['langs'] = "";
        }
        return $data;
    }
    public function updateSiteLang($lang)
    {
        $data = [
            'site_language' => $lang
        ];
        return DB::table('options')
            ->update($data);
    }
    public function updateAdminLang($lang)
    {
        $data = [
            'admin_language' => $lang
        ];
        return DB::table('options')
            ->update($data);
    }

}