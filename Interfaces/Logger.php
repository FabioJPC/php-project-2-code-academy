<?php
    namespace Interfaces;

    interface Logger
    {
        public function add(string $message) : void;

        public function warning(string $message): void;
        
        public function error(string $message): void;
    }