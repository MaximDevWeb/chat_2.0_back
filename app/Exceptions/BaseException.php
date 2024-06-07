<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Http\Response;

abstract class BaseException extends Exception
{
    protected array $errors = [];

    /**
     * Метод вывода сообщения об ошибке
     *
     * @return Response
     */
    public function render(): Response
    {
        $data['message'] = $this->getMessage();
        $data['errors'] = $this->getErrors();

        if (env('APP_DEBUG')) {
            $data['exception'] = get_class($this);
            $data['file'] = $this->getFile();
            $data['line'] = $this->getLine();
            $data['trace'] = $this->getTrace();
        }

        return response($data, $this->getCode());
    }

    /**
     * Функция получения массива ошибок исключения
     *
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
