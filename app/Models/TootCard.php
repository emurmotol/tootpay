<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Sofa\Eloquence\Eloquence;

class TootCard extends Model
{
    use Eloquence;

    protected $searchableColumns = [
        'id', 'uid', 'load', 'points',
    ];

    public $incrementing = false;

    protected $dates = ['expires_at'];

    protected $fillable = [
        'id', 'uid', 'pin_code', 'load', 'points', 'is_active', 'expires_at',
    ];

    public function users() {
        return $this->belongsToMany(User::class, 'user_toot_card')->withTimestamps();
    }

    public function transactions() {
        return $this->belongsToMany(Transaction::class, 'user_toot_card_transaction')->withTimestamps();
    }

    public function fromTootCardId() {
        return $this->belongsTo(LoadShare::class, 'from_toot_card_id');
    }

    public function toTootCardId() {
        return $this->belongsTo(LoadShare::class, 'to_toot_card_id');
    }

    public function soldCards() {
        return $this->hasMany(SoldCard::class);
    }

    public function setIsActiveAttribute($value) {
        $this->attributes['is_active'] = ($value == 'on') ? 1 : 0;
    }

    public static function searchFor($keyword, $model = null) {
        if (!is_null($model)) {
            return $model->search(strtolower($keyword));
        }
        return self::search(strtolower($keyword));
    }

    public static function sort($sort, $model = null) {
        if (!is_null($model)) {
            if ($sort == str_slug(trans('sort.toot_cards')[0])) {
                return $model->orderBy('updated_at', 'desc');
            }
        } else {
            if ($sort == str_slug(trans('sort.toot_cards')[0])) {
                return self::orderBy('updated_at', 'desc');
            }
        }
    }

    public static function testJson($field = null) {
        $path  = resource_path('assets/json/toot_cards/test.json');
        $test = collect(json_decode(file_get_contents($path), true));

        if (is_null($field)) {
            return $test->all();
        }
        return $test[$field];
    }

    public static function loadExceeds($toot_card_id, $amount_due) {
        $toot_card = self::find($toot_card_id);
        $temp_load = $toot_card->load + $amount_due;

        if ($temp_load > Setting::value('toot_card_max_load_limit')) {
            return true;
        }
        return false;
    }

    public static function hasSufficientLoad($toot_card_id, $amount_due) {
        $toot_card = self::find($toot_card_id);

        if (!count($toot_card->load)) {
            return false;
        }

        if ($toot_card->load < $amount_due) {
            return false;
        }
        return true;
    }

    public static function hasSufficientPoints($toot_card_id, $amount_due) {
        $toot_card = self::find($toot_card_id);

        if (!count($toot_card->points)) {
            return false;
        }

        if ($toot_card->points < $amount_due) {
            return false;
        }
        return true;
    }

    public static function hasSufficientLoadAndPoints($toot_card_id, $amount_due) {
        $toot_card = self::find($toot_card_id);
        $balance = $toot_card->load + $toot_card->points;

        if (!count($balance)) {
            return false;
        }

        if ($balance < $amount_due) {
            return false;
        }
        return true;
    }

    public static function payUsingLoad($toot_card_id, $amount_due) {
        $toot_card = self::find($toot_card_id);
        $per_point = intval(Setting::value('per_point'));
        $load = $toot_card->load;
        $points = $toot_card->points;

        $toot_card->load = $load - $amount_due;
        $toot_card->points = $points + ($amount_due / $per_point);
        $toot_card->save();
    }

    public static function payUsingPoints($toot_card_id, $amount_due) {
        $toot_card = self::find($toot_card_id);
        $points = $toot_card->points;

        $toot_card->points = $points - $amount_due;
        $toot_card->save();
    }

    public static function payUsingLoadAndPoints($toot_card_id, $amount_due) {
        $toot_card = self::find($toot_card_id);
        $per_point = intval(Setting::value('per_point'));
        $load = $toot_card->load;
        $points = $toot_card->points;
        $balance = $load + $points;

        $toot_card->load = ($balance - $amount_due) > 1 ?: 0;
        $_points = $points - ($amount_due - $balance);
        $toot_card->points = (($_points < 1) ? 0 : $_points) + ($balance / $per_point);
        $toot_card->save();
    }

    public static function response($status_response_id, $toot_card_id) {
        $response = [
            'status' => StatusResponse::find($status_response_id)->name,
            'toot_card_uid' => self::find($toot_card_id)->uid
        ];
        $status = collect($response);
        Log::debug($status->toArray());
        return response()->make($status->toJson());
    }

    public static function saveLoad($toot_card_id, $load_amount) {
        $toot_card = TootCard::find($toot_card_id);
        $toot_card->load += $load_amount;
        $toot_card->save();
    }

    public static function active() {
        return self::where('is_active', true);
    }

    public static function inactive() {
        return self::where('is_active', false);
    }

    public static function expired() {
        return self::where('expires_at', '<', Carbon::now());
    }

    public static function notAssociated() {
        return self::whereNotIn('id', collect(DB::table('user_toot_card')->get())->pluck('toot_card_id')->toArray());
    }
}
