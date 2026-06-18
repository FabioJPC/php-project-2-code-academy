<?php
    namespace Characters;

    use SpecialEffects\RageEffect;
    use Exceptions\InvalidInputException;

    class Orc extends Character{

        private int $specialDamage = 80;

        public function __construct() {
            parent::__construct(
                "Grog", 
                "Orc",
                "Muita vida e defesa, ataque mais baixo, especial muito forte.",
                210,
                18,
                10
            );
        }

        public function useSpecial(Character $target): ?int 
        {
            if($this->specialChargePoints >= self::SPECIAL_ATK_COST) {
                $damageDealt = $target->receiveDamage($this->specialDamage);
                $this->applyStatusEffect(new RageEffect());

                $this->specialChargePoints = 0;
                
                return $damageDealt;
            }
            else {
                throw new InvalidInputException("Pontos de especial insuficientes!");
            }
        }

        public function chargeSpecial(): void 
        {
            if($this->specialChargePoints < self::SPECIAL_ATK_COST) {
                $this->specialChargePoints = min(($this->specialChargePoints + 25), self::SPECIAL_ATK_COST);
            }
        }
    }