<?php
declare(strict_types=1);

namespace Services\ProductTranslations\Repository\PDO;

use Services\ProductTranslations\Entity\Translation;
use Services\ProductTranslations\Repository\TranslationsQuery;
use Services\ProductTranslations\Repository\TranslationsRepository;

class PDOTranslationsRepository implements TranslationsRepository
{
    /** @var \PDO */
    private $pdo;

    /** @var TranslationFromRowFactory */
    private $translationFactory;

    public function __construct(\PDO $pdo, TranslationFromRowFactory $translationFactory)
    {
        $this->pdo = $pdo;
        $this->translationFactory = $translationFactory;
    }

    /**
     * @param TranslationsQuery $query
     * @return \Generator|Translation[]
     */
    public function findTranslations(TranslationsQuery $query): \Generator
    {
        $sql = <<<SQL
SELECT
    pt.id                       AS translation_id,
    l.id                        AS language_id,
    l.abbreviation              AS language_abbreviation,
    t.id                        AS type_id,
    t.type                      AS type,
    t.description               AS type_description,
    p.id                        AS product_id,
    pt.current_revision_id      AS current_revision_id,
    ptr.revision                AS current_revision_number,
    ptr.translation             AS current_translation,
    pts.id                      AS source_id,
    pts.source                  AS source,
    pts.description             AS source_description
FROM language l
CROSS JOIN product_text_type t
CROSS JOIN product p
LEFT JOIN product_translation pt
    ON pt.language_id = l.id
    AND t.id = pt.product_text_type_id
    AND p.id = pt.product_id
LEFT JOIN product_translation_revision ptr
    ON ptr.id = pt.current_revision_id
LEFT JOIN product_translation_source pts
    ON pts.id = ptr.translation_source_id
%s
ORDER BY {$this->getOrderBy($query->getSortMethod())}
LIMIT {$query->getOffset()},{$query->getLimit()};
SQL;

        $where = [];
        $params = [];

        $this->addWhereStatus($query->getStatus(), $where);
        $this->addWhereIn('lang', 'l.abbreviation', $where, $params, $query->getLanguages());
        $this->addWhereIn('type', 't.type', $where, $params, $query->getTypes());
        $this->addWhereIn('product', 'p.id', $where, $params, $query->getProducts());
        $this->addWhereIn('source', 'pts.source', $where, $params, $query->getSources());

        if (count($where) > 0) {
            $sql = sprintf($sql, 'WHERE ' . implode(' AND ', $where));
        } else {
            $sql = sprintf($sql, '');
        }

        $statement = $this->pdo->prepare($sql);
        $statement->execute($params);

        while ($row = $statement->fetch()) {
            yield $this->translationFactory->create($row);
        }
    }

    private function addWhereIn(string $placeholder, string $column, array &$where, array &$params, array $values): void
    {
        if (count($values) === 0) {
            return;
        }

        $currentParams = [];
        foreach (array_values($values) as $i => $value) {
            $currentParams[":{$placeholder}{$i}"] = $value;
        }

        $where[] = $column . ' IN (' . implode(',', array_keys($currentParams)) . ')';
        $params += $currentParams;
    }

    private function getOrderBy(int $sortMethod): string
    {
        // todo implement more sort methods
        return 'p.id DESC, t.id DESC, l.id DESC';
    }

    private function addWhereStatus(int $status, &$where): void
    {
        if ($status === TranslationsQuery::STATUS_NOT_TRANSLATED) {
            $where[] = 'pt.current_revision_id IS NULL';
        } elseif ($status === TranslationsQuery::STATUS_TRANSLATED) {
            $where[] = 'pt.current_revision_id IS NOT NULL';
        }
    }
}
