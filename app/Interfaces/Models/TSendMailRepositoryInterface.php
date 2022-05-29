<?php

namespace App\Interfaces\Models;

interface TSendMailRepositoryInterface
{
    public function create(string $send_mail_id, $email, $subject, $message);
}
