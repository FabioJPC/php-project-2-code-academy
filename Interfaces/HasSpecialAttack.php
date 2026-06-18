<?php
    namespace Interfaces;
    use Characters\Character;

    interface HasSpecialAttack{
        public function useSpecial(Character $target) : ?int;
        public function chargeSpecial() : void;
    }