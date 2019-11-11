<?php
declare(strict_types=1);

namespace Services\ProductTranslations\EntityFactory;

use Services\ProductTranslations\Entity\Language;
use Services\ProductTranslations\Entity\Revision;
use Services\ProductTranslations\Entity\Source;
use Services\ProductTranslations\Entity\TextType;
use Services\ProductTranslations\Entity\Translation;

class TranslationFactory
{
    public function create(
        ?int $id,
        int $productId,
        Language $language,
        TextType $textType,
        ?Revision $currentRevision,
        ?Source $source
    ): Translation {
        return new Translation($id, $productId, $language, $textType, $currentRevision, $source);
    }
}
