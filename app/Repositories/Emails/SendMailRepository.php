<?php

namespace App\Repositories\Emails;

use App\Interfaces\Emails\SendMailRepositoryInterface;
use App\Emails\EmailVerification;
use Mail;

class SendMailRepository implements SendMailRepositoryInterface
{
    /**
     * メール送信
     *
     * @param  mixed $email メールアドレス
     * @param  mixed $subject 件名
     * @param  mixed $variables 本文変数配列
     * @param  mixed $text_file_path 本文ファイルパス
     * @return void
     */
    public function exec($email, $subject, $variables, $text_file_path){
        $email_verification = new EmailVerification($subject, $variables, $text_file_path);
        Mail::to($email)->send($email_verification);
        return $email_verification;
    }
}
