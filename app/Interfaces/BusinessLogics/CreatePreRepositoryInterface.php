<?php

namespace App\Interfaces\BusinessLogics;

use App\Requests\Users\CreatePreRequest;

interface CreatePreRepositoryInterface
{
    public function exec(CreatePreRequest $request);
}
