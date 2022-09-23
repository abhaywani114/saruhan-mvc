<?php

namespace App\Models\Backend;
use DB;

class Users
{
    public function add($data)
    {
        return DB::table('admin')->insert($data);
    }
    public function delete($ID)
    {
        return DB::table('admin')
            ->where('id','=',$ID)
            ->delete();
    }
    public function edit($data,$ID)
    {
        return DB::table('admin')
            ->where('id','=',$ID)
            ->update($data);
    }
    public function user($ID)
    {
        return DB::select('*')
            ->table('admin')
            ->where('id','=',$ID)
            ->getRow();
    }
    public function users()
    {
        return DB::select('*')
            ->table('admin')
            ->getAll();
    }
    public function userControl($nickname)
    {
        return DB::select('*')
            ->table('admin')
            ->where('nickname','=',$nickname)
            ->getRow();
    }
    public function userControlNoID($nickname,$ID)
    {
        return DB::select('*')
            ->table('admin')
            ->where('id','!=',$ID)
            ->where('nickname','=',$nickname)
            ->getAll();
    }
    public function userEmailControlNoID($email,$ID)
    {
        return DB::select('*')
            ->table('admin')
            ->where('id','!=',$ID)
            ->where('email','=',$email)
            ->getAll();
    }
}