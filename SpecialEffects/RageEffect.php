<?php   
    namespace SpecialEffects;

    class RageEffect extends SpecialEffect{
        
        protected string $abbreviation = "RAG";
        private int $duration = 3;
        private float $attackModifier = 1.30;
        private float $defenseModifier = 1.0;

        public function __construct() 
        {
            parent::__construct($this->duration, $this->abbreviation);
        }

        public function getAttackModifier(): float 
        {
            return $this->attackModifier;
        }

        public function getDefenseModifier(): float 
        {
            return $this->defenseModifier;
        }

        public function getAbbreviation() : string 
        {
            return $this->abbreviation;
        }
    }