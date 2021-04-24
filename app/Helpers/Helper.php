<?php

namespace App\Helpers;

use App\Models\Guest;

class Helper
{
    public static function getDaftarTamu()
    {
        $accounts = Guest::select('id','name','no_telp')
                    ->where('status','!=',1)
                    ->get();

        $akun_array=[];
        foreach ($accounts as $model){
            $akun_array[$model->id] = $model->name . ' - ' . $model->no_telp;
        }        

        return $akun_array;
    }
}