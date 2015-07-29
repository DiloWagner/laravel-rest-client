<?php
namespace CursoLaravel\Exceptions;

use CursoLaravel\Exceptions\Enums\Error;

class ClientDatabaseException extends \Exception
{
    /**
     * @param string $code
     */
    public function __construct($code)
    {
        $this->code = $code;
    }

    /**
     * @return string
     * @TODO implementar outros erros referente ao banco de dados
     */
    public function getErrorMessage()
    {
        switch($this->code) {
            case 23000:
                return "You can't remove the client to have any link with the project.";
                break;
            default:
                return Error::UNEXPECTED_ERROR;
        }
    }
}