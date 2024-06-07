<?php

namespace App\Exceptions;

class EmailTokenNotFoundException extends BaseException
{
    public function __construct()
    {
        $this->code = 404;
        $this->message = 'Ошибка подтверждения email.';
        parent::__construct();
    }
}
