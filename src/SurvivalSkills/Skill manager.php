<?php

declare(strict_types=1);

namespace SurvivalSkills;

use pocketmine\utils\Config;
use pocketmine\player\Player;

class SkillManager {

    private Config $playerData;

    public function __construct(Config $playerData) {
        $this->playerData = $playerData;
    }

    public function increaseSkill(Player $player, string $skill): void {
        $name = $player->getName();
        if ($this->playerData->exists($name)) {
            $currentLevel = $this->playerData->get($name)[$skill];
            $this->playerData->set($name, array_merge($this->playerData->get($name), [$skill => $currentLevel + 1]));
            $this->playerData->save();
        }
    }
}
