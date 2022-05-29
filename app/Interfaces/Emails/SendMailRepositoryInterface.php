<?php

namespace App\Interfaces\Emails;

interface SendMailRepositoryInterface
{
    public function exec($email, $subject, $variables, $text_file_path);
}
