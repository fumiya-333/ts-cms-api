<?php

namespace App\Interfaces\BusinessLogics;

use App\Requests\Users\CreateRequest;
use App\Models\MUser;

interface CreateRepositoryInterface
{
    public function emailVerifyTokenFindUser(String $email_verify_token);
    public function exec(CreateRequest $request, &$msg);
}
