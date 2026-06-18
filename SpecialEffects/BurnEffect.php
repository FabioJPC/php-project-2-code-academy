<?php   
    namespace SpecialEffects;

    use Characters\Character;
    use Utils\Colors;

    class BurnEffect extends SpecialEffect{

        protected string $abbreviation = "BRN";
        private int $duration = 3;
        private int $damagePerTurn = 5;

        public function __construct() 
        {
            parent::__construct($this->duration, $this->abbreviation);
        }

        public function getDamageAmount() : int 
        {
            return $this->damagePerTurn;
        }

        public function apply(Character $target) : void 
        {
            $target->applyStatusEffect(clone $this);
        }

        public function onTurn(Character $target) : ?EffectDamageEvent 
        {
            $target->receivePureDamage($this->damagePerTurn);
            return new EffectDamageEvent(
                Colors::RED . "queimadura" . Colors::RESET,
                $this->damagePerTurn
            );
        }

        public function getAbbreviation() : string 
        {
            return $this->abbreviation;
        }

    }