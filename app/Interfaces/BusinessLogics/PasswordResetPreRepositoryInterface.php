<?php

namespace App\Interfaces\BusinessLogics;

use App\Requests\Users\PasswordResetPreRequest;

interface PasswordResetPreRepositoryInterface
{
    public function exec(PasswordResetPreRequest $request, &$msg);
    public function validate(PasswordResetPreRequest $request, &$msg, &$m_user);
    public function update(PasswordResetPreRequest $request, &$m_user);
    public function sendWithStoreMail($m_user);
}
