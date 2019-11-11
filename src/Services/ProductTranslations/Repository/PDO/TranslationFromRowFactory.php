<?php
declare(strict_types=1);

namespace Services\ProductTranslations\Repository\PDO;

use Services\ProductTranslations\Entity\Language;
use Services\ProductTranslations\Entity\Revision;
use Services\ProductTranslations\Entity\Source;
use Services\ProductTranslations\Entity\TextType;
use Services\ProductTranslations\Entity\Translation;
use Services\ProductTranslations\EntityFactory\LanguageFactory;
use Services\ProductTranslations\EntityFactory\RevisionFactory;
use Services\ProductTranslations\EntityFactory\SourceFactory;
use Services\ProductTranslations\EntityFactory\TextTypeFactory;
use Services\ProductTranslations\EntityFactory\TranslationFactory;

class TranslationFromRowFactory
{
    /** @var TranslationFactory */
    private $translationFactory;

    /** @var SourceFactory */
    private $sourceFactory;

    /** @var TextTypeFactory */
    private $textTypeFactory;

    /** @var LanguageFactory */
    private $languageFactory;

    /** @var RevisionFactory */
    private $revisionFactory;

    public function __construct(
        TranslationFactory $translationFactory,
        SourceFactory $sourceFactory,
        TextTypeFactory $textTypeFactory,
        LanguageFactory $languageFactory,
        RevisionFactory $revisionFactory
    ) {
        $this->translationFactory = $translationFactory;
        $this->sourceFactory = $sourceFactory;
        $this->textTypeFactory = $textTypeFactory;
        $this->languageFactory = $languageFactory;
        $this->revisionFactory = $revisionFactory;
    }

    public function create(array $row): Translation
    {
        return $this->translationFactory->create(
            $row['translation_id'] === null ? null : (int)$row['translation_id'],
            $row['product_id'] === null ? null : (int)$row['product_id'],
            $this->createLanguage($row),
            $this->createTextType($row),
            $this->createRevision($row),
            $this->createSource($row)
        );
    }

    private function createLanguage(array $row): Language
    {
        return $this->languageFactory->create(
            (int)$row['language_id'],
            (string)$row['language_abbreviation']
        );
    }

    private function createTextType(array $row): TextType
    {
        return $this->textTypeFactory->create(
            (int)$row['type_id'],
            (string)$row['type'],
            (string)$row['type_description']
        );
    }

    private function createSource(array $row): ?Source
    {
        return $row['source_id'] === null ? null : $this->sourceFactory->create(
            (int)$row['source_id'],
            (string)$row['source'],
            (string)$row['source_description']
        );
    }

    private function createRevision(array $row): ?Revision
    {
        return $row['current_revision_id'] === null ? null : $this->revisionFactory->create(
            (int)$row['current_revision_id'],
            (int)$row['current_revision_number'],
            (string)$row['current_translation']
        );
    }
}
