<?php

use Illuminate\Database\Seeder;
use App\Models\StatusResponse;

class StatusResponsesTableSeeder extends Seeder
{
    public function run()
    {
        foreach (StatusResponse::json() as $status_response) {
            StatusResponse::create($status_response);
        }
    }
}
