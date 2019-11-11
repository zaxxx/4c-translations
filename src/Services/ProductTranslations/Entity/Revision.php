<?php
declare(strict_types=1);

namespace Services\ProductTranslations\Entity;

class Revision
{
    /** @var int */
    private $id;

    /** @var int */
    private $revision;

    /** @var string */
    private $translation;

    public function __construct(int $id, int $revision, string $translation)
    {
        $this->id = $id;
        $this->revision = $revision;
        $this->translation = $translation;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getRevision(): int
    {
        return $this->revision;
    }

    public function getTranslation(): string
    {
        return $this->translation;
    }
}
