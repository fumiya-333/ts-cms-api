<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\MUser;

class EmailExistsRule implements Rule
{
    /** 未登録のメールアドレス */
    const ERR_MSG_NOT_EXISTS = "未登録のメールアドレスです。";
    /** 未登録のメールアドレス */
    const ERR_MSG_EMAIL_VERIFIED_OFF = "仮登録済のメールアドレスです。メールにて本登録を完了させて下さい。";

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
        // メールアドレスが登録されているか判定
        if(!$this->m_user->count()){
            $this->msg .= self::ERR_MSG_NOT_EXISTS;
            return false;
        }

        // 本登録されているか判定
        if(!$this->m_user->email_verified){
            $this->msg .= self::ERR_MSG_EMAIL_VERIFIED_OFF;
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
