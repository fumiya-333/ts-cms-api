<?php
namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Libs\AppConstants;
use App\Interfaces\BusinessLogics\CreatePreRepositoryInterface;
use App\Requests\Users\CreatePreRequest;

class CreatePreController extends Controller
{
    /** 完了メッセージ */
    const INFO_MSG = '仮登録が完了しました。入力して頂いたメールアドレス宛てに、本登録を行う為のURLをメールにてお送りしました。24時間以内にメールのURLより本登録画面へ進んで頂き、アカウントの本登録を実施して下さい。※仮登録受付完了メールが届かない場合は、管理者にご連絡下さい。';

    /** エラーメッセージ */
    const ERR_MSG = '仮登録に失敗しました。管理者にご連絡下さい。';

    private CreatePreRepositoryInterface $create_pre_repository;

    public function __construct(CreatePreRepositoryInterface $create_pre_repository)
    {
        $this->create_pre_repository = $create_pre_repository;
    }

    /**
     * 仮登録処理
     *
     * @param  mixed $request
     * @return void
     */
    public function store(CreatePreRequest $request)
    {
        $msg = '';
        try {
            // バリデーション処理
            if ($this->create_pre_repository->validate($request, $msg)) {
                // 仮登録処理実行
                $this->create_pre_repository->exec($request);
            } else {
                return response()->error([AppConstants::KEY_MSG => $msg]);
            }
        } catch (\Exception $e) {
            return response()->error([
                AppConstants::KEY_MSG => self::ERR_MSG,
                AppConstants::KEY_LOG => $e->getMessage(),
            ]);
        }
        return response()->success([AppConstants::KEY_MSG => self::INFO_MSG]);
    }
}
