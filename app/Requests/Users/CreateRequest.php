<?php
namespace App\Requests\Users;

use App\Requests\BaseRequest;
use App\Models\MUser;
use App\Rules\EmailCreateAuthRule;

class CreateRequest extends BaseRequest
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
        $this->req_rules[MUser::COL_EMAIL] = [MUser::COL_EMAIL, new EmailCreateAuthRule($this->input(MUser::COL_EMAIL))];
        return $this->req_rules;
    }

    /**
     * 定義済みバリデーションルールのエラーメッセージ取得
     *
     * @return array
     */
    public function messages(){
        return $this->req_messages;
    }

    /**
     * バリデーションエラーのカスタム属性の取得
     *
     * @return array
     */
    public function attributes(){
        return $this->req_attributes;
    }

    protected function prepareForValidation()
    {
        //getで取得したパラメータをmergeする。
        $this->merge([MUser::COL_EMAIL_VERIFY_TOKEN => $this->route(MUser::COL_EMAIL_VERIFY_TOKEN)]);
    }
}
