<?php

namespace App\Interfaces\BusinessLogics;

use App\Requests\Users\CreateRequest;

interface CreateRepositoryInterface
{
    public function exec(CreateRequest $request, &$msg);
    public function validate(CreateRequest $request, &$msg, &$m_user);
    public function store($request, $m_user);
    public function isCreated($m_user, &$msg);
}
