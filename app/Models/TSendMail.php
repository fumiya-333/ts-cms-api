<?php
namespace App\Models;

use App\Models\Base;

class TSendMail extends Base
{
    /** メール送信ID */
    const COL_SEND_MAIL_ID = 'send_mail_id';
    /** メールアドレス */
    const COL_EMAIL = 'email';
    /** 件名 */
    const COL_SUBJECT = 'subject';
    /** 本文 */
    const COL_MESSAGE = 'message';

    protected $fillable = [self::COL_SEND_MAIL_ID, self::COL_EMAIL, self::COL_SUBJECT, self::COL_MESSAGE];

    /** 件名（仮登録） */
    const CREATE_PRE_EMAIL_SUBJECT = '【TF_CMS】仮登録の完了のお知らせ';
    /** 件名（パスワードリセット仮登録） */
    const PASSWORD_RESET_EMAIL_SUBJECT = '【TF_CMS】パスワードリセット仮登録の完了のお知らせ';
}
