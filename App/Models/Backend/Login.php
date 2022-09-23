<?php

namespace App\Models\Backend;

use DB;

class Login
{
    public function login($data){
        $this->nickname = $data["nickname"];
        $this->password = md5($data["password"]);
        $this->control = DB::connection('primary')
            ->table('admin')
            ->select('*')
            ->where('nickname', '=', $this->nickname)
            ->whereGroupStart('AND')
            ->where('password', '=', $this->password)
            ->whereGroupEnd()
            ->getRow();
        return $this->control;
    }
}