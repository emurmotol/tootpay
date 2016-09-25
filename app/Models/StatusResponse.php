<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;

class StatusResponse extends Model
{
    protected $fillable = [
        'name',
    ];

    public function transactions() {
        return $this->hasMany(Transaction::class);
    }

    public static function json($index = null) {
        $path  = resource_path('assets/json/status_responses.json');
        $status_responses = collect(json_decode(file_get_contents($path), true));

        if (is_null($index)) {
            return $status_responses->all();
        }
        return $status_responses[$index]['id'];
    }

    public static function def($status_response_id, $other = null) {
        if (is_null($other)) {
            $response = [
                'status' => self::find($status_response_id)->name
            ];
        } else {
            $response = [
                'status' => self::find($status_response_id)->name,
                'other' => $other,
            ];
        }
        $status = collect($response);
        Log::debug($status->toArray());
        return response()->make($status->toJson());
    }
}
