<?php
    namespace Interfaces;

    use Characters\Character;

    interface Input 
    {
        public function readString(): string;
        
        public function readInteger(): int;
    }