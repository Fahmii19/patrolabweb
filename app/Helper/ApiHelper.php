<?php
namespace App\Helper;
class ApiHelper
{
    public static function response($status,$message,$data,$code){
        return response()->json([
            'status'=>$status,
            'message'=>$message,
            'data'=>$data
        ],$code);
    }
}