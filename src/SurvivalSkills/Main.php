<?php

namespace SurvivalSkills;

use pocketmine\plugin\PluginBase;
use pocketmine\event\Listener;
use pocketmine\event\player\PlayerJoinEvent;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;
use pocketmine\Player;
use Vecnavium\FormsUI\SimpleForm;

class Main extends PluginBase implements Listener {
    
    private $skillManager;

    public function onEnable(): void {
        $this->getServer()->getPluginManager()->registerEvents($this, $this);
        $this->skillManager = new SkillManager($this);
        $this->getLogger()->info("SurvivalSkills plugin enabled!");
    }

    public function onJoin(PlayerJoinEvent $event): void {
        $player = $event->getPlayer();
        // Logika saat pemain bergabung
    }

    public function onCommand(CommandSender $sender, Command $command, string $label, array $args): bool {
        if (!$sender instanceof Player) {
            $sender->sendMessage("This command can only be used in-game.");
            return false;
        }

        if ($command->getName() === "skill") {
            $this->openSkillUI($sender);
            return true;
        }

        return false;
    }

    public function openSkillUI(Player $player): void {
        $form = new SimpleForm(function (Player $player, int $data = null) {
            if ($data === null) return;

            switch ($data) {
                case 0:
                    // Logika untuk Skill 1
                    break;
                case 1:
                    // Logika untuk Skill 2
                    break;
                // Tambahkan lebih banyak opsi sesuai kebutuhan
            }
        });

        $form->setTitle("Skill Overview");
        $form->setContent("Here are your skills:");
        $form->addButton("Skill 1");
        $form->addButton("Skill 2");
        $form->sendToPlayer($player); // Pastikan menggunakan metode yang benar untuk mengirim form
    }
}
