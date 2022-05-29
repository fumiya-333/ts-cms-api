<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Base extends Model
{
    /** 削除フラグ */
    const COL_DEL_FLG = "del_flg";

    /** プライマリーキー データ型 */
    protected $keyType = 'string';

    /** オートインクリメントをオフ */
    public $incrementing = false;
}
