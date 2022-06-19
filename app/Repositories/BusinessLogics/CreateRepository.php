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
    const INFO_MSG_USER_REGIST_SUCCESS = '本登録が完了しました。';
    /** ユーザー情報本登録失敗 */
    const ERR_MSG_USER_REGIST_FAILED = '本登録に失敗しました。';

    private MUserRepositoryInterface $m_user_repository;

    public function __construct(MUserRepositoryInterface $m_user_repository)
    {
        $this->m_user_repository = $m_user_repository;
    }

    /**
     * バリデーション処理
     *
     * @param  mixed $request リクエストパラメータ
     * @param  mixed $msg エラーメッセージ
     * @return バリデーション判定フラグ
     */
    public function validate(CreateRequest $request, &$msg){
        $m_user = $this->m_user_repository->emailFindUser($request->email);
        // 本登録メール判定
        if(!$this->m_user_repository->isCreated($m_user, $msg)){
            return false;
        }
        return true;
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
            if($this->m_user_repository->updateEmailVerifiedPassword($m_user, $request)){
                $msg .= self::INFO_MSG_USER_REGIST_SUCCESS;
            }else{
                $msg .= self::ERR_MSG_USER_REGIST_FAILED;
            }

        });
    }
}
