<?php
declare(strict_types=1);

namespace Services\ProductTranslations\EntityFactory;

use Services\ProductTranslations\Entity\Source;

class SourceFactory
{
    /** @var Source[] */
    private $cache = [];

    public function create(int $id, string $source, string $description): Source
    {
        if (array_key_exists($id, $this->cache)) {
            return $this->cache[$id];
        }

        return $this->cache[$id] = new Source($id, $source, $description);
    }
}
