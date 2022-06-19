<?php

namespace App\Interfaces\BusinessLogics;

use App\Requests\Users\PasswordResetPreRequest;

interface PasswordResetPreRepositoryInterface
{
    public function validate(PasswordResetPreRequest $request, &$msg);
    public function exec(PasswordResetPreRequest $request, &$msg);
}
