<?php
declare(strict_types=1);

namespace Services\ProductTranslations\Entity;

class TextType
{
    /** @var int */
    private $id;

    /** @var string */
    private $type;

    /** @var string */
    private $description;

    public function __construct(int $id, string $type, string $description)
    {
        $this->id = $id;
        $this->type = $type;
        $this->description = $description;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
