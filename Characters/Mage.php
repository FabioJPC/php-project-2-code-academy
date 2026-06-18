<?php
    namespace Characters;

    use SpecialEffects\BurnEffect;
    use Exceptions\InvalidInputException;

    class Mage extends Character
    {
        private int $pureDamage = 50;

        public function __construct(){
            parent::__construct(
                "Billy", 
                "Mago", 
                "Muito ataque e efeitos, mas pouca defesa e vida.", 
                130,
                24,
                6
            );
        }

        public function useSpecial(Character $target): ?int 
        {
            if($this->specialChargePoints >= self::SPECIAL_ATK_COST) {
                $target->receivePureDamage($this->pureDamage);
                $target->applyStatusEffect(new BurnEffect());
                $this->specialChargePoints = 0;

                return $this->pureDamage;
            }
            else {
                throw new InvalidInputException("Pontos de especial insuficientes!");
            }
        }

        public function chargeSpecial(): void {
            if($this->specialChargePoints < self::SPECIAL_ATK_COST) {
                $this->specialChargePoints = min(($this->specialChargePoints + 34), self::SPECIAL_ATK_COST);
            }
        }
    }