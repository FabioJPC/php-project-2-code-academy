<?php
    namespace Players;

    use Characters\Character;

    class Player
    {
        private string $name;
        private Character $character;

        public function getName(): string 
        {
            return $this->name;
        }
        public function setName(string $name): void
        {
            $this->name = $name;
        }

        public function getCharacter() : Character 
        {
            return $this->character;
        }
        
        public function setCharacter(Character $character): void 
        {
            $this->character = $character;
        }
        
        public function isAlive(): bool 
        {
            return $this->character->isAlive();
        }

    }