<?php
    namespace SpecialEffects;

    class EffectDamageEvent
    {
        private string $type;
        private int $damage;

        public function __construct($type, $damage)
        {
            $this->type = $type;
            $this->damage = $damage;
        }

        public function getType() : string 
        {
            return $this->type;
        }

        public function getDamage() : int 
        {
            return $this->damage;
        }

    }
