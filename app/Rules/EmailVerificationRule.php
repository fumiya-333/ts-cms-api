<?php
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use App\Models\MUser;
use App\Libs\AppConstants;

class EmailVerificationRule implements Rule
{
    /** 仮登録済みのメールアドレス */
    const ERR_MSG_EMAIL_VERIFIED_OFF = "仮登録済のメールアドレスです。メールにて本登録を完了させて下さい。";
    /** 本登録済みのメールアドレス */
    const ERR_MSG_EMAIL_VERIFIED_ON = "このメールアドレスは既に本登録されています。他のメールアドレスを入力して下さい。";

    /** ユーザー情報 */
    private $m_user;
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
        if($this->m_user->count()){
            if(!$this->m_user->email_verified){
                $this->msg = self::ERR_MSG_EMAIL_VERIFIED_OFF;
                return false;
            }else{
                $this->msg = self::ERR_MSG_EMAIL_VERIFIED_ON;
                return false;
            }
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
