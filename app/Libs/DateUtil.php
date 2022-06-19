<?php
namespace App\Libs;

use Carbon\Carbon;

class DateUtil
{
    /**
     * 年の取得
     *
     * @return 年
     */
    public static function getYear()
    {
        return Carbon::now()->year;
    }

    /**
     * 1日経過しているか判定
     *
     * @param  mixed $str 日付文字列
     * @return 1日経過判定フラグ
     */
    public static function isAddDay($str)
    {
        $date = new Carbon($str);
        return Carbon::now()->gt($date->addDay());
    }
}
