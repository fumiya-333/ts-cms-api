<?php

namespace App\Interfaces\BusinessLogics;

use App\Requests\Users\PasswordResetRequest;

interface PasswordResetRepositoryInterface
{
    public function validate(PasswordResetRequest $request, &$msg);
    public function exec(PasswordResetRequest $request, &$msg);
}
