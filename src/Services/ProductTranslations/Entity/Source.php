<?php
declare(strict_types=1);

namespace Services\ProductTranslations\Entity;

class Source
{
    /** @var int */
    private $id;

    /** @var string */
    private $source;

    /** @var string */
    private $description;

    public function __construct(int $id, string $source, string $description)
    {
        $this->id = $id;
        $this->source = $source;
        $this->description = $description;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getSource(): string
    {
        return $this->source;
    }

    public function getDescription(): string
    {
        return $this->description;
    }
}
