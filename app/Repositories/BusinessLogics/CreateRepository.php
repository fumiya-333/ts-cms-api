<?php

namespace App\Repositories\BusinessLogics;

use Illuminate\Support\Facades\DB;
use App\Requests\Users\CreateRequest;
use App\Interfaces\BusinessLogics\CreateRepositoryInterface;
use App\Interfaces\Models\MUserRepositoryInterface;
use App\Models\MUser;
use App\Libs\DateUtil;

class CreateRepository implements CreateRepositoryInterface
{
    /** ユーザー情報本登録完了 */
    const INFO_MSG = '本登録が完了しました。';
    /** 無効なトークン */
    const ERR_MSG_EMAIL_VERIFY_TOKEN_VALID = '無効なトークンです。URLが途切れていないかご確認下さい。';
    /** 本登録済み */
    const ERR_MSG_USER_REGIST_COMPLETED = '既に本登録されています。ログインを行いご利用下さい。';
    /** メール認証発効後24時間以上経過 */
    const ERR_MSG_EMAIL_AUTH_24HOURS_PASSED = 'メール認証の発行から24時間以上経過しています。再度アカウント設定を行って下さい。';

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
    public function exec(CreateRequest $request, &$msg)
    {
        $m_user = new MUser();
        // バリデーション処理
        if (self::validate($request, $msg, $m_user)) {
            // 本登録処理
            self::store($request, $msg, $m_user);
        } else {
            return false;
        }
        $msg = self::INFO_MSG;
        return true;
    }

    /**
     * バリデーション処理
     *
     * @param  mixed $request リクエストパラメータ
     * @param  mixed $msg エラーメッセージ
     * @return バリデーション判定フラグ
     */
    public function validate(CreateRequest $request, &$msg, &$m_user)
    {
        $m_user = $this->m_user_repository->emailFindUser($request->email);
        // 本登録メール判定
        return self::isCreated($m_user, $msg);
    }

    /**
     * 本登録処理
     *
     * @param  mixed $request リクエストパラメータ
     * @param  mixed $m_user ユーザー情報
     * @return void
     */
    public function store($request, $m_user)
    {
        DB::transaction(function () use ($request, $m_user) {
            // メールアドレスに紐づくユーザー情報取得
            $m_user = $this->m_user_repository->emailFindUser($request->email);

            // 本登録処理
            $this->m_user_repository->updateEmailVerifiedPassword($m_user, $request);
        });
    }

    /**
     * 本登録判定
     *
     * @param  mixed $m_user ユーザー情報
     * @param  mixed $msg エラーメッセージ
     * @return 本登録判定フラグ
     */
    public function isCreated($m_user, &$msg)
    {
        // 登録されているトークンか判定
        if (!$m_user->count()) {
            $msg .= self::ERR_MSG_EMAIL_VERIFY_TOKEN_VALID;
            return false;
        }
        // 本登録されているか判定
        if ($m_user->email_verified) {
            $msg .= self::ERR_MSG_USER_REGIST_COMPLETED;
            return false;
        }
        // メール認証の発行から、1日以上経過している場合
        if (DateUtil::isAddDay($m_user->email_verified_at)) {
            $msg .= self::ERR_MSG_EMAIL_AUTH_24HOURS_PASSED;
            return false;
        }
        return true;
    }
}
