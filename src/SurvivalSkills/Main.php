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

class Main extends PluginBase implements Listener {

    private Config $playerData;

    protected function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);

        // Load or create player data file
        $this->playerData = new Config($this->getDataFolder() . "playerData.yml", Config::YAML);
    }

    protected function onDisable(): void {
        $this->playerData->save();
    }

    public function onJoin(PlayerJoinEvent $event): void {
        $player = $event->getPlayer();
        $name = $player->getName();

        // Inisialisasi data pemain baru jika belum ada
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
                $this->openSkillGUI($sender);
                return true;
            }
        }
        return false;
    }

    public function openSkillGUI(Player $player): void {
        $skillManager = new SkillManager($this->playerData);
        $name = $player->getName();

        // Membuat array tombol untuk skill
        $buttons = [];
        $skills = ["survival", "hunting", "farming", "mining", "cooking"];
        
        foreach ($skills as $skill) {
            $level = $skillManager->getSkillLevel($name, $skill);
            $buttons[] = ["text" => ucfirst($skill) . " - Level " . $level];
        }

        // Membuat dan mengirim SkillForm ke pemain
        $form = new SkillForm("Skill Kamu", "Berikut adalah level skill kamu:", $buttons);
        $player->sendForm($form);
    }
}