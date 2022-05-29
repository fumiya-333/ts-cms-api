<?php

namespace App\Interfaces\BusinessLogics;

use App\Requests\Users\PasswordResetPreRequest;

interface PasswordResetPreRepositoryInterface
{
    public function exec(PasswordResetPreRequest $request);
}
