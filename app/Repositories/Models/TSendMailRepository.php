<?php

namespace App\Repositories\Models;

use App\Interfaces\Models\TSendMailRepositoryInterface;
use App\Models\TSendMail;

class TSendMailRepository implements TSendMailRepositoryInterface
{
    /**
     * メール送信情報登録
     *
     * @param  mixed $send_mail_id メール送信ID
     * @param  mixed $email メールアドレス
     * @param  mixed $subject 件名
     * @param  mixed $message 本文
     * @return void
     */
    public function create(string $send_mail_id, $email, $subject, $message){
        return TSendMail::create([
            TSendMail::COL_SEND_MAIL_ID => $send_mail_id,
            TSendMail::COL_EMAIL => $email,
            TSendMail::COL_SUBJECT => $subject,
            TSendMail::COL_MESSAGE => $message
        ]);
    }
}
