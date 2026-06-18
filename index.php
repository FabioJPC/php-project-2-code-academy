<?php

    require_once __DIR__ . '/vendor/autoload.php';

    use Characters\Paladin;
    use Characters\Orc;
    use Characters\Mage;
    use Core\TerminalRenderer;
    use Core\TerminalLogger;
    use Core\TerminalInput;
    use Core\BattleManager;
    use Core\GameSetup;

    
    $availableCharacters = [new Paladin(), new Orc(), new Mage()];

    $logger = new TerminalLogger();
    $renderer = new TerminalRenderer($logger);
    $input = new TerminalInput($renderer);

    $setup = new GameSetup($input, $renderer, $availableCharacters);

    list($player1, $player2) = $setup->config();

    $game = new BattleManager($input, $renderer, $player1, $player2);

    $winner = $game->start();

    $renderer->clear();

    $renderer->showActionMessage(
            "O jogador {$winner->getName()} venceu com" . 
            " {$winner->getCharacter()->getCurrentHp()} pontos de vida restantes"
        );
