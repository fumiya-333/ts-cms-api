<?php
namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use App\Libs\AppConstants;
use App\Interfaces\BusinessLogics\CreatePreRepositoryInterface;
use App\Requests\Users\CreatePreRequest;

class CreatePreController extends Controller
{
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
            $this->create_pre_repository->exec($request, $msg);
        } catch (\Exception $e) {
            return response()->error([
                AppConstants::KEY_MSG => AppConstants::ERR_MSG,
                AppConstants::KEY_LOG => $e->getMessage(),
            ]);
        }
        return response()->success([AppConstants::KEY_MSG => $msg]);
    }
}
