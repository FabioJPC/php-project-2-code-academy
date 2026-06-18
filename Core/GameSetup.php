<?php
    namespace Core;

    use Players\Player;
    use Interfaces\Input;
    use Interfaces\Renderer;
    use Exceptions\InvalidInputException;
    use Exceptions\ExceptionHandler;

    class GameSetup
    {
        private Input $input;
        private Renderer $renderer;
        private array $availableCharacters;
        private const DELAYTIME = 1200;
        private const DELAYINTRO = 2200;

        public function __construct(Input $input, Renderer $renderer, array $availableCharacters)
        {
            $this->input = $input;
            $this->renderer = $renderer;
            $this->availableCharacters = $availableCharacters;
        }

        public function config(): array 
        {
            $this->renderer->clear();

            $this->renderer->showGreetings();
            $this->renderer->wait(self::DELAYINTRO);
            
            $player1 = $this->configPlayer();
            $player2 = $this->configPlayer();

            return [$player1, $player2];
        }

        public function configPlayer(): Player 
        {
            $this->renderer->clear();

            $this->renderer->askNameDialog();
            $name = $this->input->readString();
            
            $selectedCharacter = $this->selectCharacter();

            $player = new Player();
            $player->setName($name);
            $player->setCharacter($selectedCharacter);

            $this->renderer->showPlayerJoinedMessage($name, $selectedCharacter->getName());
            $this->renderer->wait(1700);

            return $player;
        }

        public function selectCharacter() 
        {
            while(true) {
                $this->renderer->askCharacterDialog($this->availableCharacters);
                $choice = $this->input->readInteger();

                $actualIndex = $choice - 1;

                try {
                    if (!array_key_exists($actualIndex, $this->availableCharacters)) {
                        throw new InvalidInputException("Personagem inválido selecionado.");
                    }

                    return clone $this->availableCharacters[$actualIndex];

                } catch (InvalidInputException $e) {
                    ExceptionHandler::handle($e);
                    $this->renderer->wait(self::DELAYTIME);
                }
            }
        }
    }