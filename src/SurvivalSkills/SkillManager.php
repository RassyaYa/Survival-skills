<?php

namespace SurvivalSkills;

use pocketmine\Player;

class SkillManager {
    private $plugin;
    private $skills = [];

    public function __construct(Main $plugin) {
        $this->plugin = $plugin;
        // Inisialisasi keterampilan default atau muat dari database
        $this->initSkills();
    }

    private function initSkills(): void {
        // Contoh inisialisasi keterampilan
        $this->skills = [
            "skill1" => ["level" => 1, "description" => "Basic Skill"],
            "skill2" => ["level" => 1, "description" => "Advanced Skill"],
            // Tambahkan lebih banyak keterampilan sesuai kebutuhan
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
