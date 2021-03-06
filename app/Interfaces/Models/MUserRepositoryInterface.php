<?php

namespace App\Interfaces\Models;

interface MUserRepositoryInterface
{
    public function store(
        string $user_id,
        $name,
        $email,
        $password,
        $email_verified,
        $email_verify_token,
        $email_verified_at
    );
    public function update(&$m_user, $name, $email_verified, $email_verify_token, $email_verified_at);
    public function emailFindUser($email);
    public function emailVerifyTokenFindUser($email_verify_token);
    public function emailPasswordResetTokenFindUser($email_password_reset_token);
    public function updateEmailVerifiedPassword($m_user, $request);
    public function updatePasswordResetToken($m_user, $email_password_reset_token);
    public function updatePasswordReset($m_user, $password);
}
