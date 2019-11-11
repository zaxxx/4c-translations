<?php
declare(strict_types=1);

namespace Services\ProductTranslations\Export;

use Services\ProductTranslations\Entity\Translation;

interface ExportAdapter
{
    public function writeTranslation(Translation $translation): void;

    public function flush(): void;
}
