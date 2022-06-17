<?php
namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;
use App\Libs\AppConstants;
use App\Interfaces\BusinessLogics\CreateRepositoryInterface;
use App\Requests\Users\CreateRequest;
use App\Libs\StrUtil;
use App\Models\MUser;

class CreateController extends Controller
{
    private CreateRepositoryInterface $create_repository;

    public function __construct(CreateRepositoryInterface $create_repository)
    {
        $this->create_repository = $create_repository;
    }

    public function fetch(Request $request){
        $users = $this->create_repository->emailVerifyTokenFindUser($request->email_verify_token);
        return response()->success([MUser::COL_NAME => $users->name, MUser::COL_EMAIL => $users->email, StrUtil::convToCamel(MUser::COL_EMAIL_VERIFIED) => $users->email_verified]);
    }

    /**
     * 本登録処理
     *
     * @param  mixed $request リクエストパラメータ
     * @return void
     */
    public function store(CreateRequest $request){
        $msg = "";
        try {
            // 本登録処理実行
            $this->create_repository->exec($request, $msg);
        } catch (\Exception $e) {
            return response()->error([AppConstants::KEY_MSG => $msg, AppConstants::KEY_LOG => $e->getMessage()]);
        }
        return response()->success([AppConstants::KEY_MSG => $msg]);
    }
}
