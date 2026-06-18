<?php
    namespace Interfaces;

    use Characters\Character;
    use Players\Player;

    interface Renderer
    {
        public function clear(): void;

        public function showGreetings(): void;

        public function renderStatusBoard(array $player1Data, array $player2Data): void;

        public function showBattleOptions(bool $isSpecialReady): void;

        public function showWarning(string $message): void;

    }