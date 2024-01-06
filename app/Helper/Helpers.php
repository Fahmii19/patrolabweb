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
        $url = 'http://api-sit.patrol.adonara.co.id/redis-reset/' . $endpoint;

        Http::withHeaders([
            'Accept' => '*/*',
            'Authorization' => 'Basic cGF0cm9sOnBhdHJvbCMxMjM0',
        ])->delete($url);
    }
}
