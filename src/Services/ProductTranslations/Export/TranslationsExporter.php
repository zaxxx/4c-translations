<?php
declare(strict_types=1);

namespace Services\ProductTranslations\Export;

use Services\ProductTranslations\Repository\TranslationsQuery;
use Services\ProductTranslations\Repository\TranslationsRepository;

class TranslationsExporter
{
    /** @var TranslationsRepository */
    private $repository;

    /** @var ExportAdapter */
    private $adapter;

    public function __construct(TranslationsRepository $repository, ExportAdapter $adapter)
    {
        $this->repository = $repository;
        $this->adapter = $adapter;
    }

    public function export(TranslationsQuery $query): void
    {
        foreach ($this->repository->findTranslations($query) as $translation) {
            $this->adapter->writeTranslation($translation);
        }
        $this->adapter->flush();
    }
}
