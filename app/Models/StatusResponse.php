<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
