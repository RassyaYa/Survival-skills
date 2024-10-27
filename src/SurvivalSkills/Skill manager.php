<?php

declare(strict_types=1);

namespace SurvivalSkills;

use pocketmine\utils\Config;

class SkillManager {

    private Config $playerData;

    public function __construct(Config $playerData) {
        $this->playerData = $playerData;
    }

    public function getSkillLevel(string $playerName, string $skill): int {
        $skills = $this->playerData->get($playerName, []);
        return $skills[$skill] ?? 0;
    }

    public function gainSkillXP(string $playerName, string $skill, int $xp): void {
        $skills = $this->playerData->get($playerName, []);
        $level = $skills[$skill] ?? 0;

        // Perhitungan XP yang dibutuhkan untuk naik level
        $levelThreshold = 100 + ($level * 20);
        if ($xp >= $levelThreshold) {
            $skills[$skill] = $level + 1; // Naik level
            $this->playerData->set($playerName, $skills);
            $this->playerData->save();
        }
    }
}
