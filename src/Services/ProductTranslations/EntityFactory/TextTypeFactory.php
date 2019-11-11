<?php
declare(strict_types=1);

namespace Services\ProductTranslations\EntityFactory;

use Services\ProductTranslations\Entity\TextType;

class TextTypeFactory
{
    /** @var TextType[] */
    private $cache = [];

    public function create(int $id, string $type, string $description): TextType
    {
        if (array_key_exists($id, $this->cache)) {
            return $this->cache[$id];
        }

        return $this->cache[$id] = new TextType($id, $type, $description);
    }
}
