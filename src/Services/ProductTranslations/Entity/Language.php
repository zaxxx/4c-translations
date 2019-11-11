<?php
declare(strict_types=1);

namespace Services\ProductTranslations\Entity;

class Language
{
    /** @var int */
    private $id;

    /** @var string */
    private $abbreviation;

    public function __construct(int $id, string $abbreviation)
    {
        $this->id = $id;
        $this->abbreviation = $abbreviation;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getAbbreviation(): string
    {
        return $this->abbreviation;
    }
}
