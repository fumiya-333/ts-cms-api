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
    private MUserRepositoryInterface $m_user_repository;
    private SendMailRepositoryInterface $send_mail_repository;
    private TSendMailRepositoryInterface $t_send_mail_repository;

    public function __construct(MUserRepositoryInterface $m_user_repository, SendMailRepositoryInterface $send_mail_repository, TSendMailRepositoryInterface $t_send_mail_repository)
    {
        $this->m_user_repository = $m_user_repository;
        $this->send_mail_repository = $send_mail_repository;
        $this->t_send_mail_repository = $t_send_mail_repository;
    }

    /**
     * 仮登録処理実行
     *
     * @param  mixed $request
     * @return void
     */
    public function exec(CreatePreRequest $request) {

        DB::transaction(function () use ($request) {

            // ユーザー情報登録
            $m_user = $this->m_user_repository->create(
                StrUtil::getUuid(),
                $request->name,
                $request->email,
                bcrypt($request->password),
                MUser::EMAIL_VERIFIED_OFF,
                StrUtil::getUuid(),
                new Carbon(),
            );

            $variables = [MUser::COL_EMAIL => $m_user->email, MUser::COL_EMAIL_VERIFY_TOKEN => $m_user->email_verify_token];
            // メール送信処理実行
            $email = $this->send_mail_repository->exec($m_user->email, TSendMail::CREATE_PRE_EMAIL_SUBJECT, $variables, 'emails.create-pre');

            // メール送信情報登録
            $this->t_send_mail_repository->create(StrUtil::getUuid(), $m_user->email, TSendMail::CREATE_PRE_EMAIL_SUBJECT, $email->getMessage());

        });
    }
}
