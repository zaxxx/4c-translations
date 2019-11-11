<?php
declare(strict_types=1);

namespace Services\ProductTranslations\EntityFactory;

use Services\ProductTranslations\Entity\Revision;

class RevisionFactory
{
    public function create(int $id, int $revision, string $translation): Revision
    {
        return new Revision($id, $revision, $translation);
    }
}
