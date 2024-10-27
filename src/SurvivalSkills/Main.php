<?php

namespace SurvivalSkills;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use Vecnavium\FormsUI\Form; // Pastikan ini diimpor jika Anda menggunakan Form API

class Main extends PluginBase {
    /** @var SkillManager */
    private $skillManager;

    public function onEnable(): void {
        $this->skillManager = new SkillManager($this);
        $this->getLogger()->info("SurvivalSkills plugin enabled!");
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage("This command can only be used in-game.");
            return true;
        }

        if ($command->getName() === "skill") {
            $this->openSkillUI($sender);
            return true;
        }
        return false;
    }

    public function openSkillUI(Player $player): void {
        // Ganti ini dengan logika UI Anda
        $this->skillManager->displaySkills($player);
    }
}
