<?php
    namespace Characters;

    use Exceptions\InvalidInputException;

    class Paladin extends Character{

        private int $specialHeal = 20;
        private int $pureDamage = 20;

        public function __construct() {
            parent::__construct(
                "Bobby", 
                "Paladino", 
                "Equilibrado. Possuí alguns efeitos e um especial mediano.", 
                150,
                20,
                12
            );
        }

        public function useSpecial(Character $target): ?int
        {

            if($this->specialChargePoints >= self::SPECIAL_ATK_COST) {
                $target->receivePureDamage($this->pureDamage);
                $this->healItself($this->specialHeal);
                $this->specialChargePoints = 0;

                return $this->pureDamage;
            }
            else {
                throw new InvalidInputException("Pontos de especial insuficientes!");
            }
            
        }
        public function chargeSpecial(): void {
            if($this->specialChargePoints < self::SPECIAL_ATK_COST) {
                $this->specialChargePoints = min(($this->specialChargePoints + 29), self::SPECIAL_ATK_COST);
            }
        }
    }