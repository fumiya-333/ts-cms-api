<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Libs\DateUtil;
use App\Models\MUser;

class EmailCreateAuthRule implements Rule
{
    /** メール認証失敗 */
    const ERR_MSG_EMAIL_AUTH_FAILED = 'メール認証に失敗しました。再度、メールからリンクをクリックしてください。';
    /** 無効なトークン */
    const ERR_MSG_EMAIL_VERIFY_TOKEN_VALID = '無効なトークンです。URLが途切れていないかご確認下さい。';
    /** 本登録済み */
    const ERR_MSG_USER_REGIST_COMPLETED = '既に本登録されています。ログインを行いご利用下さい。';
    /** メール認証発効後24時間以上経過 */
    const ERR_MSG_EMAIL_AUTH_24HOURS_PASSED = 'メール認証の発行から24時間以上経過しています。再度アカウント設定を行って下さい。';

    /** メールアドレス */
    private $email;
    /** メッセージ */
    private $msg;

    public function __construct($email)
    {
        $this->m_user = MUser::emailFindUser($email);
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        // 本登録メール認証
        if(!self::isEmailCreateAuth()){
            $this->msg .= self::ERR_MSG_EMAIL_AUTH_FAILED;
            return false;
        }
        return true;
    }

    /**
     * 本登録メール認証
     *
     * @return 本登録メール認証フラグ
     */
    private function isEmailCreateAuth(){
        // 登録されているトークンか判定
        if(!$this->m_user->count()){
            $this->msg .= self::ERR_MSG_EMAIL_VERIFY_TOKEN_VALID;
            return false;
        }

        // 本登録されているか判定
        if($this->m_user->email_verified){
            $this->msg .= self::ERR_MSG_USER_REGIST_COMPLETED;
            return false;
        }

        // メール認証の発行から、24時間以上経過しているか
        if(DateUtil::isAddDay($this->m_user->email_verified_at)){
            $this->msg .= self::ERR_MSG_EMAIL_AUTH_24HOURS_PASSED;
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->msg;
    }
}
