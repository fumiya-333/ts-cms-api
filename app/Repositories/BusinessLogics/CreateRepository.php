<?php

namespace App\Repositories\BusinessLogics;

use Illuminate\Support\Facades\DB;
use App\Requests\Users\CreateRequest;
use App\Interfaces\BusinessLogics\CreateRepositoryInterface;
use App\Interfaces\Models\MUserRepositoryInterface;
use App\Models\MUser;

class CreateRepository implements CreateRepositoryInterface
{
    /** ユーザー情報本登録完了 */
    const INFO_MSG_USER_REGIST_SUCCESS = 'ユーザー情報の本登録が完了しました。ログインを行いご利用下さい。';
    /** ユーザー情報本登録失敗 */
    const ERR_MSG_USER_REGIST_FAILED = 'ユーザー情報の本登録に失敗しました。管理者に連絡を行って下さい。';

    private MUserRepositoryInterface $m_user_repository;

    public function __construct(MUserRepositoryInterface $m_user_repository)
    {
        $this->m_user_repository = $m_user_repository;
    }

    /**
     * メールアドレスURLトークンに紐づくユーザー情報取得
     *
     * @param  mixed $email_verify_token メールアドレスURLトークン
     * @return void
     */
    public function emailVerifyTokenFindUser(String $email_verify_token) {
        return $this->m_user_repository->emailVerifyTokenFindUser($email_verify_token);
    }

    /**
     * 本登録処理実行
     *
     * @param  mixed $request リクエストパラメータ
     * @param  mixed $msg メッセージ
     * @return void
     */
    public function exec(CreateRequest $request, &$msg) {

        DB::transaction(function () use ($request, &$msg) {

            // メールアドレスに紐づくユーザー情報取得
            $m_user = $this->m_user_repository->emailFindUser($request->email);

            // 本登録処理
            if($this->m_user_repository->updateVerifiedPassword($m_user, $request)){
                $msg .= self::INFO_MSG_USER_REGIST_SUCCESS;
            }else{
                $msg .= self::ERR_MSG_USER_REGIST_FAILED;
            }

        });
    }
}
