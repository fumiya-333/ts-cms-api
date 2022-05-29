<?php
namespace App\Libs;

use Str;
use App\Libs\AppConstants;

class StrUtil {


    /**
     * UUIDを取得
     *
     * @return uuid
     */
    public static function getUuid(){
        return (string) Str::uuid();
    }

    /**
     * ハッシュ値の取得
     *
     * @return ハッシュ値
     */
    public static function getHash(){
        return hash(AppConstants::HASH_KEY_SHA256, uniqid(rand(), true));
    }

    /**
     * ハッシュ値への変換
     *
     * @param  mixed $str 文字列
     * @return 文字列変換ハッシュ値
     */
    public static function convToHash($str){
        return hash(AppConstants::HASH_KEY_SHA256, uniqid($str, true));
    }
}