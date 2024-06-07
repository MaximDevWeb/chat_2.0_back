<?php

namespace App\Exceptions;

class UserNotCreatedException extends BaseException
{
    public function __construct()
    {
        $this->code = 404;
        $this->message = 'Ошибка создания пользователя.';
        parent::__construct();
    }
}
