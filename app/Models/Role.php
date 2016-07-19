<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    public function users() {
        return $this->belongsToMany('App\Models\User',
            'user_role', 'role_id', 'user_id');
    }

    public static function getId($user_id) {
        $role = User::find($user_id)->roles()->first();
        return $role->pivot->role_id;
    }

//    public function rootUrl($user_id) {
//        if (User::isAdministrator($user_id)) {
//            return url('admin/dashboard');
//        } elseif (User::isCashier($user_id)) {
//            return url('cashier/dashboard');
//        } elseif (User::isCardholder($user_id)) {
//            return url('cardholder/dashboard');
//        }
//    }

    public static function array2json($arr) {
        if(function_exists('json_encode')) return json_encode($arr); //Lastest versions of PHP already has this functionality.
        $parts = array();
        $is_list = false;

        //Find out if the given array is a numerical array
        $keys = array_keys($arr);
        $max_length = count($arr)-1;
        if(($keys[0] == 0) and ($keys[$max_length] == $max_length)) {//See if the first key is 0 and last key is length - 1
            $is_list = true;
            for($i=0; $i<count($keys); $i++) { //See if each key correspondes to its position
                if($i != $keys[$i]) { //A key fails at position check.
                    $is_list = false; //It is an associative array.
                    break;
                }
            }
        }

        foreach($arr as $key=>$value) {
            if(is_array($value)) { //Custom handling for arrays
                if($is_list) $parts[] = array2json($value); /* :RECURSION: */
                else $parts[] = '"' . $key . '":' . array2json($value); /* :RECURSION: */
            } else {
                $str = '';
                if(!$is_list) $str = '"' . $key . '":';

                //Custom handling for multiple data types
                if(is_numeric($value)) $str .= $value; //Numbers
                elseif($value === false) $str .= 'false'; //The booleans
                elseif($value === true) $str .= 'true';
                else $str .= '"' . addslashes($value) . '"'; //All other things
                // :TODO: Is there any more datatype we should be in the lookout for? (Object?)

                $parts[] = $str;
            }
        }
        $json = implode(',',$parts);

        if($is_list) return '[' . $json . ']';//Return numerical JSON
        return '{' . $json . '}';//Return associative JSON
    }
}
