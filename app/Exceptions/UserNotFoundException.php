<?php

namespace App\Exceptions;

class UserNotFoundException extends BaseException
{
    public function __construct()
    {
        $this->code = 404;
        $this->message = 'Пользователь не найден.';
        parent::__construct();
    }
}
