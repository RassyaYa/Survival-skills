<?php

namespace SurvivalSkills;

use pocketmine\plugin\PluginBase;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use Vecnavium\FormsUI\SimpleForm; // Mengimpor SimpleForm dari FormsUI

class Main extends PluginBase {

    private $skillManager;

    public function onEnable(): void {
        $this->getLogger()->info("SurvivalSkills plugin enabled!");
        $this->skillManager = new SkillManager(); // Inisialisasi SkillManager
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        if ($command->getName() === "skill") {
            if ($sender instanceof Player) {
                // Memeriksa permission sebelum membuka UI
                if ($sender->hasPermission("survivalskills.use")) {
                    $this->openSkillUI($sender);
                } else {
                    $sender->sendMessage("You do not have permission to use this command.");
                }
                return true;
            } else {
                $sender->sendMessage("This command can only be used in-game.");
                return false;
            }
        }
        return false;
    }

    public function openSkillUI(Player $player): void {
        $form = new SimpleForm(function (Player $player, int $data) {
            if ($data === -1) {
                $player->sendMessage("You closed the skill overview.");
            }
        });

        $form->setTitle("Skill Overview");
        $form->setContent("Here you can see your skills.");
        $form->addButton("Close");

        $player->sendForm($form);
    }
}
