<?php
    namespace Core;

    use Interfaces\Logger;

    class TerminalLogger implements Logger
    {
        private $actions = [];
        private $path;

        public function __construct()
        {
            $dateTime = date('d-m-Y-H-i'); 
        
            $this->path = __DIR__ . "/../logs/battle-log-{$dateTime}.log";
        }

        public function add(string $message) : void 
        {
            $this->actions[] = $message;

            $cleanMessage = preg_replace('/\x1b\[[0-9;]*m/', '', $message);

            $formattedMessage = $cleanMessage . PHP_EOL;

            file_put_contents($this->path, $formattedMessage, FILE_APPEND);
        }

        public function warning(string $message): void 
        {
            $this->add("[WARNING]: $message");
        }
        
        public function error(string $message): void 
        {
            $this->add("[ERROR]: $message");
        }

    }