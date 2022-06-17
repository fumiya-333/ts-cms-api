<?php
namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Libs\AppConstants;
use App\Interfaces\BusinessLogics\PasswordResetRepositoryInterface;
use App\Requests\Users\PasswordResetRequest;

class PasswordResetController extends Controller
{
    /** 完了メッセージ */
    const INFO_MSG = '入力して頂いたメールアドレス宛てに、本登録を行う為のURLをメールにてお送りしました。24時間以内にメールのURLより本登録画面へ進んで頂き、パスワードの本更新を実施して下さい。※受付完了メールが届かない場合は、管理者にご連絡下さい。';

    /** エラーメッセージ */
    const ERR_MSG = 'パスワード仮更新に失敗しました。管理者にご連絡下さい。';

    private PasswordResetRepositoryInterface $password_reset__repository;

    public function __construct(PasswordResetRepositoryInterface $password_reset__repository)
    {
        $this->password_reset__repository = $password_reset__repository;
    }

    /**
     * パスワードリセット処理
     *
     * @param  mixed $request
     * @return void
     */
    public function store(PasswordResetRequest $request){
        try {
            // パスワードリセット処理実行
            $this->password_reset__repository->exec($request);
        } catch (\Exception $e) {
            return response()->error([AppConstants::KEY_MSG => self::ERR_MSG, AppConstants::KEY_LOG => $e->getMessage()]);
        }
        return response()->success([AppConstants::KEY_MSG => self::INFO_MSG]);
    }
}
