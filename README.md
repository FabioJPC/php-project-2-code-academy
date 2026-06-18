# CODE ACADEMY PHP PROJECT N°2
A turn-based battle game built with PHP, running inside a Docker environment.

---

## Installation instructions:

### Clone de repository
```bash
git clone https://github.com/FabioJPC/php-project-2-code-academy.git
cd php-project-2-code-academy
```

### Build and run the container
```bash 
docker compose up -d --build
```
### Run the Game
```bash
docker exec -it game php index.php
```

## About the game

### The game contains 3 characters
  - Mage: High attack, low hp. Its special inflict pure damage to the target and add BURN effect
  - Orc: High HP, lower attack. Its special do a massive blow to the enemy and add RAGE effect to itself
  - Paladin: Balanced stats. Its special inflicts pure damage to the enemy and heal itself

### The game contains 3 effects
  - BURN: Cause 5 pure damage for 3 turns
  - RAGE: Increase attack by 30% for 3 turns
  - DEFENSE: Switching to defense mode increases defense by 35% for 1 turn

## Game loop
  - After initialization, Player 1 name will be asked, as well as which character it wants 
  - The same questions will be asked for Player 2
  - The game begins, following the commom turn based game flow;