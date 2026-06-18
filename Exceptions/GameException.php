<?php
    namespace Exceptions;

    use Exception;

    abstract class GameException extends Exception 
    {
        public function getUserMessage(): string 
        {
            return "Ação Inválida: " . $this->getMessage();
        }
    }