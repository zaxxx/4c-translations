<?php
declare(strict_types=1);

namespace Services\ProductTranslations\Entity;

class Translation
{
    /** @var int|null */
    private $id;

    /** @var int */
    private $productId;

    /** @var Language */
    private $language;

    /** @var TextType */
    private $textType;

    /** @var Revision|null */
    private $currentRevision;

    /** @var Source|null */
    private $source;

    public function __construct(
        ?int $id,
        int $productId,
        Language $language,
        TextType $textType,
        ?Revision $currentRevision,
        ?Source $source
    ) {
        $this->id = $id;
        $this->productId = $productId;
        $this->language = $language;
        $this->textType = $textType;
        $this->currentRevision = $currentRevision;
        $this->source = $source;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductId(): int
    {
        return $this->productId;
    }

    public function getLanguage(): Language
    {
        return $this->language;
    }

    public function getTextType(): TextType
    {
        return $this->textType;
    }

    public function getCurrentRevision(): ?Revision
    {
        return $this->currentRevision;
    }

    public function getSource(): ?Source
    {
        return $this->source;
    }
}
