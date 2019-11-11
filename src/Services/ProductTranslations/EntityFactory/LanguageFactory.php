<?php
declare(strict_types=1);

namespace Services\ProductTranslations\EntityFactory;

use Services\ProductTranslations\Entity\Language;

class LanguageFactory
{
    /** @var Language[] */
    private $cache = [];

    public function create(int $id, string $abbreviation): Language
    {
        if (array_key_exists($id, $this->cache)) {
            return $this->cache[$id];
        }

        return $this->cache[$id] = new Language($id, $abbreviation);
    }
}
