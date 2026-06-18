<?php
    namespace SpecialEffects;
    
    use Utils\Colors;
    use Characters\Character;


    abstract class SpecialEffect {

        protected string $abbreviation;
        protected int $turnsRemaining;

        public function __construct($duration, $abbreviation) 
        {
            $this->turnsRemaining = $duration;
            $this->abbreviation = $abbreviation;
        } 

        public function triggerTick(): void 
        {
            $this->turnsRemaining--;
        }

        public function getAttackModifier(): float 
        {
            return 1.0;
        }

        public function getDefenseModifier(): float 
        {
            return 1.0;
        }

        public function onTurn(Character $character): ?EffectDamageEvent 
        {
            return null;
        }

        public function isExpired(): bool 
        {
            return $this->turnsRemaining <= 0;
        }

        abstract public function getAbbreviation(): string;
    }