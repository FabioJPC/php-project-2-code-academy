<?php   
    namespace SpecialEffects;
    
    class DefenseEffect extends SpecialEffect{
        
        protected string $abbreviation = "DEF";
        private int $duration = 1;
        private float $defenseModifier = 1.35;

        public function __construct() 
        {
            parent::__construct($this->duration, $this->abbreviation);
        }

        public function getDefenseModifier() : float 
        {
            return $this->defenseModifier;
        }

        public function getAbbreviation() : string 
        {
            return $this->abbreviation;
        }
    }