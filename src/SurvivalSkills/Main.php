<?php

declare(strict_types=1);

namespace SurvivalSkills;

use pocketmine\plugin\PluginBase;
use pocketmine\player\Player;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\utils\Config;
use pocketmine\form\SimpleForm; // Pastikan kelas ini tersedia di versi Anda

class Main extends PluginBase implements Listener {

    private Config $playerData;

    protected function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->playerData = new Config($this->getDataFolder() . "playerData.yml", Config::YAML);
    }

    protected function onDisable(): void {
        $this->playerData->save();
    }

    public function onJoin(PlayerJoinEvent $event): void {
        $player = $event->getPlayer();
        $name = $player->getName();

        // Initialize player data if it doesn't exist
        if (!$this->playerData->exists($name)) {
            $this->playerData->set($name, [
                "survival" => 0,
                "hunting" => 0,
                "farming" => 0,
                "mining" => 0,
                "cooking" => 0
            ]);
            $this->playerData->save();
        }
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        if ($command->getName() === "skill") {
            if ($sender instanceof Player) {
                if ($sender->hasPermission("survivalskills.use")) {
                    $this->openSkillUI($sender);
                    return true;
                } else {
                    $sender->sendMessage("You do not have permission to use this command.");
                    return true;
                }
            }
        }
        return false;
    }

    public function openSkillUI(Player $player): void {
        $form = new SimpleForm(function (Player $player, int $data = null) {
            // Handle player's response, e.g., close the form
        });

        $form->setTitle("Skill Overview");
        $content = "Your Skills:\n";
        $name = $player->getName();
        $skills = $this->playerData->get($name);
        
        foreach ($skills as $skill => $level) {
            $content .= ucfirst($skill) . ": " . $level . "\n";
        }

        $form->setContent($content);
        $form->addButton("Close");

        $player->sendForm($form);
    }
}
