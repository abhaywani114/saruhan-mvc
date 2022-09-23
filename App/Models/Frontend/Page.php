<?php

namespace App\Models\Frontend;

use DB;

class Page
{
    public function pagecontrol($ID){
        $page = DB::table('page')
            ->where('page_id','=',$ID)
            ->getRow();
        if ($page)
        {
            return 1;
        }
        else
        {
            return 0;
        }
    }
}