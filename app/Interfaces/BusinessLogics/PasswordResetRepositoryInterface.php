<?php

namespace App\Interfaces\BusinessLogics;

use App\Requests\Users\PasswordResetRequest;

interface PasswordResetRepositoryInterface
{
    public function exec(PasswordResetRequest $request);
}
