<?php
    namespace Core;

    use Utils\Colors;
    use Interfaces\Renderer;
    use Interfaces\Logger;

    class TerminalRenderer implements Renderer
    {
        private Logger $logger;

        public function __construct(Logger $logger)
        {
            $this->logger = $logger;
        }

        public function showActionMessage(string $string): void 
        {
            echo "\n" . $string;
            $this->logger->add("[LOG]: $string");
            $this->wait(1300);
        } 
        
        public function showPlayerJoinedMessage(string $playerName, string $characterName): void 
        {
            $message = "{$playerName} entrou no jogo com o personagem {$characterName}!";            
            echo $message;

            $this->logger->add("[LOG]: $message"); 
        }

        function showGreetings(): void 
        {
            echo "\n\n\n\t\t\t\t------- Bem vindo a arena de batalha ------\n\n";
        }

        function askNameDialog(): void 
        {
            echo "Olá novo jogador, digite seu nome: ";
        }

        public function showTurnMessage(string $playerName): void 
        {
            echo "É a sua vez " . $playerName . "\n";
        }

        public function askCharacterDialog(array $availableCharacters): void 
        {
            $this->clear();
            echo "Selecione um personagem:\n";

            foreach($availableCharacters as $index => $char){
                echo $index + 1 . ". ";
                echo $char->presentation();
                echo "\n";
            }
        }

        function renderStatusBoard(array $player1Data, array $player2Data): void 
        {
            system("clear");

            $width = 30;
            $border = "+" . str_repeat("-", $width) . "+";

            $p1Bar = $this->renderHealthBar($player1Data["currentHp"], $player1Data["maxHp"]);
            $p2Bar = $this->renderHealthBar($player2Data["currentHp"], $player2Data["maxHp"]);

            printf("%s    %s\n", $border, $border);

            printf("|%-{$width}s|    |%-{$width}s|\n", $player1Data["name"], $player2Data["name"]);
            printf("|%-{$width}s|    |%-{$width}s|\n", $player1Data["type"], $player2Data["type"]);

            printf("%s    %s\n", $border, $border);

            printf("|%-{$width}s|    |%-{$width}s|\n", 
                "HP: " . $player1Data["currentHp"] . " " . $p1Bar,
                "HP: " . $player2Data["currentHp"] . " " . $p2Bar
            );

            printf("|%-{$width}s|    |%-{$width}s|\n", 
                "ATK: " . $player1Data["currentAttack"],
                "ATK: " . $player2Data["currentAttack"]
            );

            printf("|%-{$width}s|    |%-{$width}s|\n", 
                "DEF: " . $player1Data["currentDefense"],
                "DEF: " . $player2Data["currentDefense"]
            );

            printf("|%-{$width}s|    |%-{$width}s|\n", 
                "SPECIAL: " . $player1Data["specialPoints"],
                "SPECIAL: " . $player2Data["specialPoints"]
            );

            printf("|%-{$width}s|    |%-{$width}s|\n", 
                "EFEITOS: " . $player1Data["statusAbbreviations"],
                "EFEITOS: " . $player2Data["statusAbbreviations"]
            );

            printf("%s    %s\n", $border, $border);

            echo "\n";
        } 

        function showBattleOptions(bool $isSpecialReady): void 
        {   
            echo "\n";
            echo "1. Atacar\n";
            echo "2. Defender\n";
            echo "3. Usar especial (" . (($isSpecialReady) ? "Pronto" : "Indisponível"). ")";
            echo "\n";
        }

        public function renderHealthBar(int $currentHp, int $maxHp): string 
        {
            $size = 10;
            $currentHp = max(0, min($currentHp, $maxHp));

            $filledLength = (int) round(($currentHp / $maxHp) * $size);
            $emptyLength = $size - $filledLength;

            $filledPart = str_repeat("#", $filledLength);
            $emptyPart = str_repeat("-", $emptyLength);

            return "[{$filledPart}{$emptyPart}]";
        }

        function clear(): void 
        {
            system("clear");
        }

        function showWarning(string $message): void
        {
            echo Colors::RED
            . $message
            . Colors::RESET
            . PHP_EOL;
        }

        public function wait(int $milliseconds = 1000): void 
        {
            usleep($milliseconds * 1000);
        }

    }