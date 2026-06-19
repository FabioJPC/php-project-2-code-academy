<?php
    namespace Core;

    use Interfaces\Input;
    
    class TerminalInput implements Input
    {
        public function readString(): string 
        {
            return readline();
        }

        public function readInteger(): int 
        {
            return (int) readline();
        }
    }