<?php

namespace App\Helpers;

use App\Models\Guest;
use App\Models\Wedding;

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

    public static function getDaftarPernikahan()
    {
        $accounts = Wedding::select('id','pengantin_pria','pengantin_wanita')
                    ->where('status','!=',1)
                    ->get();

        $akun_array=[];
        foreach ($accounts as $model){
            $akun_array[$model->id] = $model->pengantin_pria . ' & ' . $model->pengantin_wanita;
        }        

        return $akun_array;
    }

    public static function getDaftarAllPernikahan()
    {
        $accounts = Wedding::select('id','pengantin_pria','pengantin_wanita')
                    ->get();

        $akun_array=[];
        foreach ($accounts as $model){
            $akun_array[$model->id] = $model->pengantin_pria . ' & ' . $model->pengantin_wanita;
        }        

        return $akun_array;
    }
}