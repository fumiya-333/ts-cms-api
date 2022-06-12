<?php
namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Requests\Users\LoginRequest;
use App\Models\MUser;
use App\Libs\AppConstants;
use Auth;

class LoginController extends Controller
{
     /** エラーメッセージ */
    const ERR_MSG = 'ログインに失敗しました。メールアドレスもしくはパスワードが異なります。';

    /**
     * ログイン
     *
     * @param  LoginRequest $request リクエストパラメータ
     * @return view
     */
    public function login(LoginRequest $request){
        if(Auth::attempt([MUser::COL_EMAIL => $request->email, MUser::COL_PASSWORD => $request->password])){
            $token = $request->user()->createToken(AppConstants::KEY_TOKEN_NAME);
            return response()->success([AppConstants::KEY_API_TOKEN => $token->plainTextToken]);
        }else{
            return response()->error([AppConstants::KEY_MSG => self::ERR_MSG]);
        }
    }
}
