<?php

namespace App\Repositories\BusinessLogics;

use App\Requests\Users\CreateRequest;
use App\Interfaces\BusinessLogics\PasswordResetRepositoryInterface;
use App\Interfaces\Models\MUserRepositoryInterface;
use App\Models\MUser;

class PasswordResetRepository implements PasswordResetRepositoryInterface
{
    /** ユーザー情報本登録完了 */
    const INFO_MSG_USER_REGIST_SUCCESS = 'パスワードリセットが完了しました。ログインを行いご利用下さい。';
    /** ユーザー情報本登録失敗 */
    const ERR_MSG_USER_REGIST_FAILED = 'パスワードリセットに失敗しました。管理者に連絡を行って下さい。';

    private MUserRepositoryInterface $m_user_repository;

    public function __construct(MUserRepositoryInterface $m_user_repository)
    {
        $this->m_user_repository = $m_user_repository;
    }

    /**
     * 本登録処理実行
     *
     * @param  mixed $request リクエストパラメータ
     * @param  mixed $msg メッセージ
     * @return void
     */
    public function exec(PasswordResetRequest $request, &$msg) {
        // メールアドレスURLトークンに紐づくユーザー情報取得
        $m_user = $this->m_user_repository->emailVerifyTokenFindUser($request->email_verify_token);

        // 本登録処理
        if($this->m_user_repository->updatePasswordReset($m_user, $request->password)){
            $msg .= self::INFO_MSG_USER_REGIST_SUCCESS;
            return true;
        }

        $msg .= self::ERR_MSG_USER_REGIST_FAILED;
        return false;
    }
}
