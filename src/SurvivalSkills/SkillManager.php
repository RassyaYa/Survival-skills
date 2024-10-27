<?php

namespace SurvivalSkills;

use pocketmine\player\Player;

class SkillManager {
    private $plugin;
    private $skills = [];

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
        $this->initSkills();
    }

    private function initSkills(): void {
        $this->skills = [
            "skill1" => ["level" => 1, "description" => "Basic Skill"],
            "skill2" => ["level" => 1, "description" => "Advanced Skill"],
        ];
    }

    public function getSkillList(): array {
        return $this->skills;
    }

    public function getSkillInfo(string $skill): array {
        return $this->skills[$skill] ?? [];
    }

    public function levelUpSkill(string $skill): void {
        if (isset($this->skills[$skill])) {
            $this->skills[$skill]["level"]++;
            $this->plugin->getLogger()->info("Skill '{$skill}' leveled up to level " . $this->skills[$skill]["level"]);
        }
    }

    public function displaySkills(Player $player): void {
        $skillList = $this->getSkillList();
        $skillInfo = "Your Skills:\n";

        foreach ($skillList as $skill => $info) {
            $skillInfo .= "{$skill}: Level {$info['level']} - {$info['description']}\n";
        }

        $player->sendMessage($skillInfo);
    }
}
