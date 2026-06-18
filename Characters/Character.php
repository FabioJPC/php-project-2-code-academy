<?php
    namespace Characters;

    use SpecialEffects\DefenseEffect;
    use Interfaces\HasSpecialAttack;
    use SpecialEffects\SpecialEffect;

    abstract class Character implements HasSpecialAttack
    {
        protected string $name;
        protected string $type;
        protected string $description;
        protected int $maxHp;
        protected int $currentHp;
        protected int $baseAttack;
        protected int $baseDefense;
        protected int $specialChargePoints;
        protected array $statusEffects;
        protected const SPECIAL_ATK_COST = 100;

        public function __construct(
            string $name,
            string $type, 
            string $description,
            int $maxHp,
            int $baseAttack,
            int $baseDefense
        ){
            $this->name = $name;
            $this->type = $type;
            $this->description = $description;
            $this->maxHp = $maxHp;
            $this->currentHp = $maxHp;
            $this->baseAttack = $baseAttack;
            $this->baseDefense = $baseDefense;
            $this->specialChargePoints = 0;
            $this->statusEffects = [];
        }

        public function getMaxHp(): int 
        {
            return $this->maxHp;
        }

        public function getCurrentHp(): int 
        {
            return $this->currentHp;
        }

        public function getType(): string
        {
            return $this->type;
        }

        public function getName(): string 
        {
            return $this->name;
        }

        public function getAllStatusEffectAbbreviations(): string 
        {
            $allStatus = implode(
                " | ", 
                array_map(
                    fn($effect)=> $effect->getAbbreviation(), 
                    $this->statusEffects
                )
            );

            return $allStatus;
        }

        public function getCurrentAttack(): float 
        {
            $multiplier = 1.0;
            foreach ($this->statusEffects as $effect) {
                $multiplier *= $effect->getAttackModifier();
            }

            return max(($this->baseAttack * $multiplier), 0);
        }

        public function getCurrentDefense(): float 
        {
            $multiplier = 1.0;
            foreach ($this->statusEffects as $effect) {
                $multiplier *= $effect->getDefenseModifier();
            }

            return max(($this->baseDefense * $multiplier), 0);
        }

        public function getSpecialChargePoints(): int 
        {
            return $this->specialChargePoints;
        }

        public function healItself(int $amount) : void 
        {
            $totalAfterHeal = $this->currentHp + $amount;
            $this->currentHp = min($totalAfterHeal, $this->maxHp);
        }

        public function presentation(): string
        {
            $text = sprintf("%-8s %-12s %-70s HP: %-6d ATK: %-6d DEF: %-6d ",
                $this->name, $this->type, $this->description, $this->maxHp, $this->baseAttack, $this->baseDefense
            );

            return $text;
        }

        public function applyStatusEffect(SpecialEffect $effect): void 
        {
            foreach ($this->statusEffects as $activeEffect) {
                if (get_class($activeEffect) === get_class($effect)) {
                    return;
                }
            }
            $this->statusEffects[] = $effect;
        }

        public function processStatusEffects(): array 
        {
            $effectLog = [];
            foreach ($this->statusEffects as $key => $effect) {
                $effectLog[] = $effect->onTurn($this);

                $effect->triggerTick();

                if ($effect->isExpired()) {
                    unset($this->statusEffects[$key]);
                }
            }

            $this->statusEffects = array_values($this->statusEffects);

            return $effectLog;
        }

        public function receivePureDamage(int $amount): void 
        { 
            $this->currentHp = max(($this->currentHp - $amount), 0);
        }

        public function receiveDamage(int $amount): float 
        {
            $defense = (int) round($this->getCurrentDefense());
            $defense = max($defense, 0);

            $totalDamage = max($amount - $defense, 0);

            $this->currentHp = max($this->currentHp - $totalDamage, 0);

            return $totalDamage;
        }

        public function attack(Character $target): int 
        {
            $totalDamage = (int) round($this->getCurrentAttack());
            $totalDamage = max($totalDamage, 0);

            $actualDamage = $target->receiveDamage($totalDamage);

            return $actualDamage;
        }

        public function defend() 
        {
            $this->statusEffects[] = new DefenseEffect();
        }

        public function isAlive(): bool 
        {
            return ($this->currentHp > 0);
        }

        public function isSpecialReady() 
        {
            return $this->specialChargePoints >= self::SPECIAL_ATK_COST;
        }
    }