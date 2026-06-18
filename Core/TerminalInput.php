<?php
    namespace Core;

    use Interfaces\Input;
    use Interfaces\Renderer;
    use Characters\Character;

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

        function getBattleAction(): int 
        {
            $choice = (int) readline();

            switch($choice){
                case 1: return BattleOption::ATTACK;
                case 2: return BattleOption::DEFEND;
                case 3: return BattleOption::SPECIAL;
                default: $renderer->invalidSelectionWarning();
            }
        }
    }