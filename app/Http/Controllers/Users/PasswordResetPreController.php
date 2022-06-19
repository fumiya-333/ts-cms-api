<?php
namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Libs\AppConstants;
use App\Interfaces\BusinessLogics\PasswordResetPreRepositoryInterface;
use App\Requests\Users\PasswordResetPreRequest;

class PasswordResetPreController extends Controller
{
    private PasswordResetPreRepositoryInterface $password_reset_pre_repository;

    public function __construct(PasswordResetPreRepositoryInterface $password_reset_pre_repository)
    {
        $this->password_reset_pre_repository = $password_reset_pre_repository;
    }

    /**
     * パスワードリセット処理
     *
     * @param  mixed $request
     * @return void
     */
    public function store(PasswordResetPreRequest $request)
    {
        try {
            // バリデーション処理
            if ($this->password_reset_pre_repository->validate($request, $msg)) {
                // パスワードリセット処理実行
                $this->password_reset_pre_repository->exec($request, $msg);
            } else {
                return response()->error([AppConstants::KEY_MSG => $msg]);
            }
        } catch (\Exception $e) {
            return response()->error([
                AppConstants::KEY_MSG => AppConstants::ERR_MSG,
                AppConstants::KEY_LOG => $e->getMessage(),
            ]);
        }
        return response()->success([AppConstants::KEY_MSG => $msg]);
    }
}
