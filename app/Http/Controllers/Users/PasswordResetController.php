<?php
namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Libs\AppConstants;
use App\Interfaces\BusinessLogics\PasswordResetRepositoryInterface;
use App\Interfaces\Models\MUserRepositoryInterface;
use App\Requests\Users\PasswordResetRequest;
use App\Libs\StrUtil;
use App\Models\MUser;

class PasswordResetController extends Controller
{
    /** 完了メッセージ */
    const INFO_MSG = '本登録が完了いたしました。';

    /** エラーメッセージ */
    const ERR_MSG = '本登録に失敗しました。管理者にご連絡下さい。';

    private PasswordResetRepositoryInterface $password_reset_repository;
    private MUserRepositoryInterface $m_user_repository;

    // PasswordResetRepositoryInterface $password_reset_repository,
    public function __construct(MUserRepositoryInterface $m_user_repository)
    {
        // $this->password_reset_repository = $password_reset_repository;
        $this->m_user_repository = $m_user_repository;
    }

    /**
     * 初期表示
     *
     * @param  mixed $request リクエストパラメータ
     * @return void
     */
    public function index(Request $request){
        $users = $this->m_user_repository->emailPasswordResetTokenFindUser($request->email_password_reset_token);
        if($users->exists()){
            return response()->success([MUser::COL_EMAIL => $users->email, StrUtil::convToCamel(MUser::COL_EMAIL_PASSWORD_RESET_VERIFIED) => $users->email_password_reset_verified]);
        }else{
            return response()->error([AppConstants::KEY_MSG => AppConstants::ERR_MSG]);
        }
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
            $this->password_reset_repository->exec($request);
        } catch (\Exception $e) {
            return response()->error([AppConstants::KEY_MSG => self::ERR_MSG, AppConstants::KEY_LOG => $e->getMessage()]);
        }
        return response()->success([AppConstants::KEY_MSG => self::INFO_MSG]);
    }
}
