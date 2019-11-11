<?php
declare(strict_types=1);

namespace Services\ProductTranslations\Repository;

use Services\ProductTranslations\Entity\Translation;

interface TranslationsRepository
{
    /**
     * @param TranslationsQuery $query
     * @return \Generator|Translation[]
     */
    public function findTranslations(TranslationsQuery $query): \Generator;
}
