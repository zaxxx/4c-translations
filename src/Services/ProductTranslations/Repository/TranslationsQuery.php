<?php
declare(strict_types=1);

namespace Services\ProductTranslations\Repository;

class TranslationsQuery
{
    public const SORT_METHOD_DEFAULT = 0;

    public const STATUS_ALL = 0;
    public const STATUS_TRANSLATED = 1;
    public const STATUS_NOT_TRANSLATED = 2;

    private const DEFAULT_LIMIT = 30;

    /** @var string[] */
    private $languages = [];

    /** @var string[] */
    private $types = [];

    /** @var int[] */
    private $products = [];

    /** @var int */
    private $status = self::STATUS_ALL;

    /** @var string[] */
    private $sources = [];

    /** @var int */
    private $sortMethod = self::SORT_METHOD_DEFAULT;

    /** @var int */
    private $limit = self::DEFAULT_LIMIT;

    /** @var int */
    private $offset = 0;

    /**
     * @return string[]
     */
    public function getLanguages(): array
    {
        return $this->languages;
    }

    /**
     * @param string[] $languages
     */
    public function setLanguages(array $languages): void
    {
        $this->languages = $languages;
    }

    /**
     * @return string[]
     */
    public function getTypes(): array
    {
        return $this->types;
    }

    /**
     * @param string[] $types
     */
    public function setTypes(array $types): void
    {
        $this->types = $types;
    }

    /**
     * @return int[]
     */
    public function getProducts(): array
    {
        return $this->products;
    }

    /**
     * @param int[] $products
     */
    public function setProducts(array $products): void
    {
        $this->products = array_map('intval', $products);
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function setStatus(int $status): void
    {
        $this->status = $status;
    }

    /**
     * @return string[]
     */
    public function getSources(): array
    {
        return $this->sources;
    }

    /**
     * @param string[] $sources
     */
    public function setSources(array $sources): void
    {
        $this->sources = $sources;
    }

    public function getSortMethod(): int
    {
        return $this->sortMethod;
    }

    public function setSortMethod(int $sortMethod): void
    {
        $this->sortMethod = $sortMethod;
    }

    public function getLimit(): int
    {
        return $this->limit;
    }

    public function setLimit(int $limit): void
    {
        $this->limit = $limit;
    }

    public function getOffset(): int
    {
        return $this->offset;
    }

    public function setOffset(int $offset): void
    {
        $this->offset = $offset;
    }
}
