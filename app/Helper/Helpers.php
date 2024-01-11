<?php

use App\Models\AuditLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

if(!function_exists('insert_audit_log')){
    function insert_audit_log($activity){
        DB::transaction(function () use ($activity) {
            $data = [
                'created_by' => auth()->id(),
                'activity' => $activity,
                'created_at' => now(),
                'updated_at' => null
            ];

            AuditLog::create($data);
        }, 3); // 3 is the number of attempts to make if a deadlock occurs

        if (DB::transactionLevel() === 0) {
            app('log')->error('insert audit log error: Transaction failed.');
        }
    }
}

if(!function_exists('redis_reset_api')){
    function redis_reset_api($endpoint){
        $url = env('API_URL') . 'redis-reset/' . $endpoint;

        $response = Http::withHeaders([
            'Accept' => '*/*',
            'Authorization' => env('BASIC_AUTH'),
        ])->delete($url);

        return $response->body();
    }
}

if(!function_exists('upload_image_api')){
    function upload_image_api($file, $name){
        $url = env('API_URL') . 'files/web/image/upload';

        $response = Http::attach('image', $file, $name)
        ->withHeaders([
            'Accept' => '*/*',
            'Authorization' => env('BASIC_AUTH'),
        ])->post($url);

        return $response->body();
    }
}


if(!function_exists('get_image_api')){
    function get_image_api($filename){
        $url = env('API_URL') . 'files/web/image/get/' . $filename;

        $response = Http::withHeaders([
            'Accept' => '*/*',
            'Authorization' => env('BASIC_AUTH'),
        ])->get($url);

        if ($response->successful()) {
            // Return raw image content without additional headers
            return $response->body();
        } else {
            // Handle error case (e.g., image not found)
            return null;
        }
    }
}


if(!function_exists('check_img_path')){
    function check_img_path($filename){
        $imgContent = get_image_api($filename);

        if ($imgContent !== null) {
            $base64Image = base64_encode($imgContent);
            return "data:image/*;base64," . $base64Image;
        }

        return asset('gambar/no-image.png'); // Gambar default
    }
}