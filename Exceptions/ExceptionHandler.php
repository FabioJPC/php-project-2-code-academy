<?php
    namespace Exceptions;

    use Utils\Colors;
    use Throwable;
    use GameException;

    class ExceptionHandler
    {
        public static function handle(Throwable $e): void 
        {
            $message = ($e instanceof GameException) ? $e->getUserMessage() : $e->getMessage();

            echo Colors::RED
            . "[ERRO] " 
            . $message
            . Colors::RESET
            . PHP_EOL;
        }
    }