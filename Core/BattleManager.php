<?php
    namespace Core;

    use Players\Player;
    use Interfaces\Input;
    use Interfaces\Renderer;
    use Exceptions\InvalidInputException;
    use Exceptions\ExceptionHandler;

    class BattleManager
    {
        private Renderer $renderer;
        private Input $input;
        private Player $player1, $player2;

        public function __construct(Input $input, Renderer $renderer, Player $player1, Player $player2)
        {
            $this->renderer = $renderer;
            $this->input = $input;
            $this->player1 = $player1;
            $this->player2 = $player2;
        }

        public function start(): Player
        {
            $turnOrder = [$this->player1, $this->player2];
            $turnCount = 0;

            while(!$this->hasBattleEnded()) {
                $currentIdx = $turnCount % 2;
                $targetIdx = ($turnCount + 1) % 2;

                $currentPlayer = $turnOrder[$currentIdx];
                $targetPlayer = $turnOrder[$targetIdx];

                $preTurnResults = $this->preTurnProcessing($currentPlayer);

                if ($this->hasBattleEnded()) {
                    break;
                }

                $this->runTurn($currentPlayer, $targetPlayer);
                $turnCount++;
            }

            $winner = ($this->player1->isAlive()) ? $this->player1 : $this->player2;
            return $winner; 
        }

        function preTurnProcessing(Player $currentPlayer): array
        {
            $effectResults = $currentPlayer->getCharacter()->processStatusEffects();

            if(count($effectResults) > 0) {
                foreach($effectResults as $effect) {
                    if($effect !== null && method_exists($effect, "getDamage")) {
                        $this->renderer->showActionMessage(
                            "{$currentPlayer->getName()} recebeu {$effect->getDamage()} dano por {$effect->getType()}"
                        );
                    }
                }
            }

            return $effectResults;
        }

        function runTurn(Player $currentPlayer, Player $targetPlayer) 
        {
            $currentCharacter = $currentPlayer->getCharacter();
            $targetCharacter = $targetPlayer->getCharacter();
            $isSpecialReady = $currentCharacter->isSpecialReady();

            $player1Data = $this->getPlayerDataForRender($this->player1);
            $player2Data = $this->getPlayerDataForRender($this->player2);

            $this->renderer->renderStatusBoard($player1Data, $player2Data);
            $this->renderer->showTurnMessage($currentPlayer->getName());

            $successfullAction = false;

            while(!$successfullAction) 
            {
                $this->renderer->showBattleOptions($isSpecialReady);
                $option = $this->input->readInteger();
                
                switch($option) 
                {
                    case 1 :
                        $damage = $currentCharacter->attack($targetCharacter);
                        $successfullAction = true;

                        $this->renderer->showActionMessage(
                            "{$currentPlayer->getName()} causou $damage dano em {$targetPlayer->getName()}"
                        );
                        break;

                    case 2 : 
                        $currentCharacter->defend();
                        $successfullAction = true;

                        $this->renderer->showActionMessage(
                            "{$currentPlayer->getName()} mudou para o modo defesa."
                        );
                        break;

                    case 3:
                        try {
                            $damage = $currentCharacter->useSpecial($targetCharacter);
                            $successfullAction = true;

                            $this->renderer->showActionMessage(
                                "{$currentPlayer->getName()} usou o especial e causou $damage dano em {$targetPlayer->getName()}."
                            );
                        } catch (InvalidInputException $e) {
                            ExceptionHandler::handle($e);

                            $this->renderer->wait(1500);
                        }
                        break;
                };
            }

            $currentCharacter->chargeSpecial();
        }

        private function getPlayerDataForRender(Player $player): array
        {
            $character = $player->getCharacter();

            return [
                "name"                => $player->getName(),
                "type"                => $character->getType(),
                "currentHp"           => $character->getCurrentHp(),
                "maxHp"               => $character->getMaxHp(),
                "currentAttack"       => $character->getCurrentAttack(),
                "currentDefense"      => $character->getCurrentDefense(),
                "specialPoints"       => $character->getSpecialChargePoints(),
                "statusAbbreviations" => $character->getAllStatusEffectAbbreviations()
            ];
        }

        public function hasBattleEnded() : bool
        {
            return !$this->player1->isAlive() || !$this->player2->isAlive();
        }
    }