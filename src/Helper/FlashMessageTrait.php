<?php

namespace Yago\Aluraplay\Helper;

trait FlashMessageTrait
{
    private function addErrorMesage(string $errorMessage): void
    {
        $_SESSION['error_message'] = $errorMessage;
    }

}