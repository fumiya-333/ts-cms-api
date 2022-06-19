<?php

namespace App\Repositories\BusinessLogics;

use Illuminate\Support\Facades\DB;
use App\Interfaces\Models\MUserRepositoryInterface;
use App\Interfaces\Emails\SendMailRepositoryInterface;
use App\Interfaces\Models\TSendMailRepositoryInterface;
use App\Interfaces\BusinessLogics\PasswordResetPreRepositoryInterface;
use App\Requests\Users\PasswordResetPreRequest;
use App\Libs\AppConstants;
use App\Libs\StrUtil;
use App\Models\MUser;
use App\Models\TSendMail;

class PasswordResetPreRepository implements PasswordResetPreRepositoryInterface
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
     * バリデーション処理
     *
     * @param  mixed $request リクエストパラメータ
     * @param  mixed $msg エラーメッセージ
     * @return バリデーション判定フラグ
     */
    public function validate(PasswordResetPreRequest $request, &$msg)
    {
        $m_user = $this->m_user_repository->emailFindUser($request->email);
        // 仮登録メール判定
        if (!$this->m_user_repository->isPasswordResetPred($m_user, $msg)) {
            return false;
        }
        return true;
    }

    /**
     * パスワードリセット処理実行
     *
     * @param  mixed $request
     * @return void
     */
    public function exec(PasswordResetPreRequest $request, &$msg)
    {
        DB::transaction(function () use ($request) {
            // メールアドレスに紐づくユーザー情報取得
            $m_user = $this->m_user_repository->emailFindUser($request->email);

            // パスワードリセットトークン情報登録
            $this->m_user_repository->updatePasswordResetToken($m_user, StrUtil::getUuid());

            // メール送信処理実行
            $variables = [
                MUser::COL_EMAIL => $m_user->email,
                MUser::COL_EMAIL_PASSWORD_RESET_TOKEN => $m_user->email_password_reset_token,
            ];
            $email = $this->send_mail_repository->exec(
                $m_user->email,
                TSendMail::PASSWORD_RESET_EMAIL_SUBJECT,
                $variables,
                'emails.passwordResetPre'
            );

            // メール送信情報登録
            $this->t_send_mail_repository->create(
                StrUtil::getUuid(),
                $m_user->email,
                TSendMail::PASSWORD_RESET_EMAIL_SUBJECT,
                $email->getMessage()
            );

            $msg = self::INFO_MSG;
        });
    }
}
