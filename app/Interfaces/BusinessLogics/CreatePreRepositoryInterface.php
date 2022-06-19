<?php

namespace App\Interfaces\BusinessLogics;

use App\Requests\Users\CreatePreRequest;

interface CreatePreRepositoryInterface
{
    public function exec(CreatePreRequest $request, &$msg);
    public function validate(CreatePreRequest $request, &$msg, &$m_user);
    public function store(CreatePreRequest $request, &$msg);
    public function update(CreatePreRequest $request, &$msg, $m_user);
    public function sendWithStoreMail($m_user);
}
