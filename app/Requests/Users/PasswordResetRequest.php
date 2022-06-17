<?php
namespace App\Requests\Users;

use App\Requests\BaseRequest;
use App\Models\MUser;
use App\Rules\EmailExistsRule;

class PasswordResetRequest extends BaseRequest
{
    /**
     * ユーザーがこのリクエストの権限を持っているかを判断する
     *
     * @return bool
     */
    public function authorize(){
        return true;
    }

    /**
     * リクエストに適用するバリデーションルールを取得
     *
     * @return array
     */
    public function rules(){
        $this->req_rules[MUser::COL_EMAIL] = [self::VALIDATION_RULE_KEY_REQUIRED, MUser::COL_EMAIL, new EmailExistsRule($this->input(MUser::COL_EMAIL))];
        return $this->req_rules;
    }

    /**
     * 定義済みバリデーションルールのエラーメッセージ取得
     *
     * @return array
     */
    public function messages(){
        $this->req_messages[MUser::COL_EMAIL . '.' . self::VALIDATION_RULE_KEY_REQUIRED] = self::VALIDATION_ATTRIBUTE . self::ERR_MSG_REQUIRED;
        $this->req_messages[MUser::COL_EMAIL . '.' . MUser::COL_EMAIL] = '有効な' . self::VALIDATION_ATTRIBUTE . self::ERR_MSG_REQUIRED;
        return $this->req_messages;
    }

    /**
     * バリデーションエラーのカスタム属性の取得
     *
     * @return array
     */
    public function attributes(){
        $this->req_attributes[MUser::COL_EMAIL] = MUser::COL_JP_EMAIL;
        return $this->req_attributes;
    }
}
