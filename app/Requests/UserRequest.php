<?php
namespace App\Requests;

use App\Requests\BaseRequest;
use App\Models\MUser;

class UserRequest extends BaseRequest
{
    protected $req_rules = [
        MUser::COL_EMAIL => [self::VALIDATION_RULE_KEY_REQUIRED],
        MUser::COL_PASSWORD => [self::VALIDATION_RULE_KEY_REQUIRED],
    ];

    protected $req_messages = [
        MUser::COL_EMAIL . '.' . self::VALIDATION_RULE_KEY_REQUIRED => self::VALIDATION_ATTRIBUTE . self::ERR_MSG_REQUIRED,
        MUser::COL_PASSWORD . '.' . self::VALIDATION_RULE_KEY_REQUIRED => self::VALIDATION_ATTRIBUTE . self::ERR_MSG_REQUIRED,
    ];

    protected $req_attributes = [
        MUser::COL_EMAIL => MUser::COL_JP_EMAIL,
        MUser::COL_PASSWORD => MUser::COL_JP_PASSWORD
    ];
}
