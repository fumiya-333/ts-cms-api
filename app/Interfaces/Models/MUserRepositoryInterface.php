<?php

namespace App\Interfaces\Models;

interface MUserRepositoryInterface
{
    public function create(string $user_id, $name, $email, $password, $email_verified, $email_verify_token, $email_verified_at);
    public function emailFindUser($email);
}
