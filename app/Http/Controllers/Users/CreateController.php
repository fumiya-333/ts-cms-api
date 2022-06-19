<?php
namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Libs\AppConstants;
use App\Libs\StrUtil;
use App\Interfaces\BusinessLogics\CreateRepositoryInterface;
use App\Interfaces\Models\MUserRepositoryInterface;
use App\Requests\Users\CreateRequest;
use App\Models\MUser;

class CreateController extends Controller
{
    private CreateRepositoryInterface $create_repository;
    private MUserRepositoryInterface $m_user_repository;

    public function __construct(
        CreateRepositoryInterface $create_repository,
        MUserRepositoryInterface $m_user_repository
    ) {
        $this->create_repository = $create_repository;
        $this->m_user_repository = $m_user_repository;
    }

    /**
     * 初期表示
     *
     * @param  mixed $request リクエストパラメータ
     * @return void
     */
    public function index(Request $request)
    {
        $users = $this->m_user_repository->emailVerifyTokenFindUser($request->email_verify_token);
        if ($users->exists()) {
            return response()->success([
                MUser::COL_NAME => $users->name,
                MUser::COL_EMAIL => $users->email,
                StrUtil::convToCamel(MUser::COL_EMAIL_VERIFIED) => $users->email_verified,
            ]);
        } else {
            return response()->error([
                AppConstants::KEY_MSG => AppConstants::ERR_MSG,
            ]);
        }
    }

    /**
     * 本登録処理
     *
     * @param  mixed $request リクエストパラメータ
     * @return void
     */
    public function store(CreateRequest $request)
    {
        $msg = '';
        try {
            if (!$this->create_repository->exec($request, $msg)) {
                return response()->error([
                    AppConstants::KEY_MSG => $msg,
                ]);
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
