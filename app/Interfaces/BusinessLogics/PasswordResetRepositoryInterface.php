<?php

namespace App\Interfaces\BusinessLogics;

use App\Requests\Users\PasswordResetRequest;

interface PasswordResetRepositoryInterface
{
    public function exec(PasswordResetRequest $request, &$msg);
    public function validate(PasswordResetRequest $request, &$msg, &$m_user);
    public function update(PasswordResetRequest $request, $msg, $m_user);
    public function isPasswordReseted($m_user, &$msg);
}
