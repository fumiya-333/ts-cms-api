<?php
namespace App\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

use App\Libs\AppConstants;

class BaseRequest extends FormRequest
{
    /**********************************************
    /* エラーメッセージ
    **********************************************/
    /** 未入力 */
    const ERR_MSG_REQUIRED = 'を入力して下さい。';
    /** パスワードとパスワード（確認用不一致） */
    const ERR_MSG_PASSWORD_CONFIRMD = 'とパスワード（確認用）の入力が異なります。';
    /** 未登録 */
    const ERR_MSG_NOT_REGIST = 'は登録されていません。';

    /**********************************************
    /* バリデーションルールキー
    **********************************************/
    /** 入力チェック */
    const VALIDATION_RULE_KEY_REQUIRED = 'required';
    /** パスワードとパスワード（確認用）一致チェック */
    const VALIDATION_RULE_KEY_CONFIRMD = 'confirmed';
    /** データ存在チェック */
    const VALIDATION_RULE_KEY_EXISTS = 'exists';

    /** バリデーションエラーのカスタム属性 */
    const VALIDATION_ATTRIBUTE = ':attribute';

    protected $req_rules = [];

    protected $req_messages = [];

    protected $req_attributes = [];

    protected function failedValidation(Validator $validator)
    {
        $response = implode('\n', $validator->errors()->all());
        throw new HttpResponseException(response()->error([AppConstants::KEY_MSG => $response]));
    }
}
