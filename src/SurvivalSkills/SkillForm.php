<?php

declare(strict_types=1);

namespace SurvivalSkills;

use pocketmine\form\Form;
use pocketmine\player\Player;

class SkillForm implements Form {
    private string $title;
    private string $content;
    private array $buttons;

    public function __construct(string $title, string $content, array $buttons) {
        $this->title = $title;
        $this->content = $content;
        $this->buttons = $buttons;
    }

    public function handleResponse(Player $player, $data): void {
        // Placeholder untuk aksi setelah menutup form
    }

    public function jsonSerialize(): array {
        return [
            "type" => "form",
            "title" => $this->title,
            "content" => $this->content,
            "buttons" => $this->buttons
        ];
    }
}
