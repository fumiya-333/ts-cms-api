<?php

namespace App\Repositories\BusinessLogics;

use Illuminate\Support\Facades\DB;
use App\Interfaces\Models\MUserRepositoryInterface;
use App\Interfaces\Emails\SendMailRepositoryInterface;
use App\Interfaces\Models\TSendMailRepositoryInterface;
use App\Interfaces\BusinessLogics\CreatePreRepositoryInterface;
use App\Requests\Users\CreatePreRequest;
use App\Libs\AppConstants;
use App\Libs\StrUtil;
use App\Models\MUser;
use App\Models\TSendMail;
use Carbon\Carbon;

class CreatePreRepository implements CreatePreRepositoryInterface
{
    /** 完了メッセージ */
    const INFO_MSG = '本登録を行う為のURLをメールにてお送りしました。24時間以内にメールをご覧いただき、本登録を行ってください。';

    private MUserRepositoryInterface $m_user_repository;
    private SendMailRepositoryInterface $send_mail_repository;
    private TSendMailRepositoryInterface $t_send_mail_repository;

    public function __construct(
        MUserRepositoryInterface $m_user_repository,
        SendMailRepositoryInterface $send_mail_repository,
        TSendMailRepositoryInterface $t_send_mail_repository
    ) {
        $this->m_user_repository = $m_user_repository;
        $this->send_mail_repository = $send_mail_repository;
        $this->t_send_mail_repository = $t_send_mail_repository;
    }

    /**
     * 仮登録処理実行
     *
     * @param  mixed $request リクエストパラメータ
     * @param  mixed $msg エラーメッセージ
     * @return void
     */
    public function exec(CreatePreRequest $request, &$msg)
    {
        $m_user = new MUser();
        // バリデーション処理
        if (self::validate($request, $m_user)) {
            // 仮登録処理実行
            self::store($request);
        } else {
            // 仮更新処理実行
            self::update($request, $m_user);
        }
        $msg = self::INFO_MSG;
        return true;
    }

    /**
     * バリデーション処理
     *
     * @param  mixed $request リクエストパラメータ
     * @param  mixed $m_user ユーザー情報
     * @return バリデーション判定フラグ
     */
    public function validate(CreatePreRequest $request, &$m_user)
    {
        $m_user = $this->m_user_repository->emailFindUser($request->email);
        // 既にデータ作成されているか判定
        return !$m_user->count();
    }

    /**
     * 仮登録処理実行
     *
     * @param  mixed $request リクエストパラメータ
     * @return void
     */
    public function store(CreatePreRequest $request)
    {
        DB::transaction(function () use ($request) {
            // ユーザー情報登録
            $m_user = $this->m_user_repository->store(
                StrUtil::getUuid(),
                $request->name,
                $request->email,
                '',
                MUser::EMAIL_VERIFIED_OFF,
                StrUtil::getUuid(),
                new Carbon()
            );
            // メール送信・情報登録
            self::sendWithStoreMail($m_user);
        });
    }

    /**
     * 仮更新処理実行
     *
     * @param  mixed $request リクエストパラメータ
     * @param  mixed $m_user ユーザー情報
     * @return void
     */
    public function update(CreatePreRequest $request, $m_user)
    {
        DB::transaction(function () use ($request, $m_user) {
            $this->m_user_repository->update(
                $m_user,
                $request->name,
                MUser::EMAIL_VERIFIED_OFF,
                StrUtil::getUuid(),
                new Carbon()
            );
            // メール送信・情報登録
            self::sendWithStoreMail($m_user);
        });
    }

    /**
     * メール送信・情報登録
     *
     * @param  mixed $m_user ユーザー情報
     * @return void
     */
    public function sendWithStoreMail($m_user)
    {
        $variables = [
            MUser::COL_EMAIL => $m_user->email,
            MUser::COL_EMAIL_VERIFY_TOKEN => $m_user->email_verify_token,
        ];
        // メール送信処理実行
        $email = $this->send_mail_repository->exec(
            $m_user->email,
            TSendMail::CREATE_PRE_EMAIL_SUBJECT,
            $variables,
            'emails.createPre'
        );

        // メール送信情報登録
        $this->t_send_mail_repository->create(
            StrUtil::getUuid(),
            $m_user->email,
            TSendMail::CREATE_PRE_EMAIL_SUBJECT,
            $email->getMessage()
        );
    }
}
