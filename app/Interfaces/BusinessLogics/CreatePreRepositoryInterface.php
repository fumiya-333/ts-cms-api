<?php

namespace App\Interfaces\BusinessLogics;

use App\Requests\Users\CreatePreRequest;

interface CreatePreRepositoryInterface
{
    public function exec(CreatePreRequest $request, &$msg);
    public function validate(CreatePreRequest $request, &$m_user);
    public function store(CreatePreRequest $request);
    public function update(CreatePreRequest $request, $m_user);
    public function sendWithStoreMail($m_user);
}
