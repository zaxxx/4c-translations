<?php
declare(strict_types=1);

namespace Tests\Unit\Services\ProductTranslations\Repository;

use PHPUnit\Framework\TestCase;
use Services\ProductTranslations\Repository\TranslationsQuery;
use Services\ProductTranslations\Repository\TranslationsRepository;

class TranslationsRepositoryTest extends TestCase
{
    public function testFindTranslationsWithDefaultQuery(): void
    {
        $query = new TranslationsQuery();
        $query->setLimit(100);
        $query->setOffset(0);

        $expectedSql = $this->getBaseQuery() . ' LIMIT 0,100;';

        $this->doTestFindTranslations($query, $expectedSql);
    }

    public function testFindTranslationsFilterByLanguage(): void
    {
        $query = new TranslationsQuery();
        $query->setLanguages(['cz', 'sk']);
        $query->setLimit(100);
        $query->setOffset(0);

        $expectedSql = $this->getBaseQuery() . <<<SQL
WHERE
    l.abbreviation IN (:lang0,:lang1)
LIMIT 0,100;
SQL;

        $expectedParams = [
            ':lang0' => 'cz',
            ':lang1' => 'sk',
        ];

        $this->doTestFindTranslations($query, $expectedSql, $expectedParams);
    }

    public function testFindTranslationsFilterByTypes(): void
    {
        $query = new TranslationsQuery();
        $query->setTypes(['title', 'perex']);
        $query->setLimit(100);
        $query->setOffset(0);

        $expectedSql = $this->getBaseQuery() . <<<SQL
WHERE
    t.type IN (:type0,:type1)
LIMIT 0,100;
SQL;

        $expectedParams = [
            ':type0' => 'title',
            ':type1' => 'perex',
        ];

        $this->doTestFindTranslations($query, $expectedSql, $expectedParams);
    }

    public function testFindTranslationsFilterByProducts(): void
    {
        $query = new TranslationsQuery();
        $query->setProducts([1, '2']);
        $query->setLimit(100);
        $query->setOffset(0);

        $expectedSql = $this->getBaseQuery() . <<<SQL
WHERE
    p.id IN (:product0,:product1)
LIMIT 0,100;
SQL;

        $expectedParams = [
            ':product0' => 1,
            ':product1' => 2,
        ];

        $this->doTestFindTranslations($query, $expectedSql, $expectedParams);
    }

    public function testFindTranslationsFilterByStatusTranslated(): void
    {
        $query = new TranslationsQuery();
        $query->setStatus(TranslationsQuery::STATUS_TRANSLATED);
        $query->setLimit(100);
        $query->setOffset(0);

        $expectedSql = $this->getBaseQuery() . <<<SQL
WHERE
    pt.current_revision_id IS NOT NULL
LIMIT 0,100;
SQL;

        $this->doTestFindTranslations($query, $expectedSql);
    }

    public function testFindTranslationsFilterByStatusNotTranslated(): void
    {
        $query = new TranslationsQuery();
        $query->setStatus(TranslationsQuery::STATUS_NOT_TRANSLATED);
        $query->setLimit(100);
        $query->setOffset(0);

        $expectedSql = $this->getBaseQuery() . <<<SQL
WHERE
    pt.current_revision_id IS NULL
LIMIT 0,100;
SQL;

        $this->doTestFindTranslations($query, $expectedSql);
    }

    public function testFindTranslationsFilterBySource(): void
    {
        $query = new TranslationsQuery();
        $query->setSources(['manual']);
        $query->setLimit(100);
        $query->setOffset(0);

        $expectedSql = $this->getBaseQuery() . <<<SQL
WHERE
    pts.source IN (:source0)
LIMIT 0,100;
SQL;

        $expectedParams = [
            ':source0' => 'manual',
        ];

        $this->doTestFindTranslations($query, $expectedSql, $expectedParams);
    }

    public function testFindTranslationsWithComplexQuery(): void
    {
        $query = new TranslationsQuery();
        $query->setLanguages(['ro', 'hu']);
        $query->setTypes(['title', 'perex']);
        $query->setProducts([1, 2, 3]);
        $query->setStatus(TranslationsQuery::STATUS_TRANSLATED);
        $query->setSources(['manual']);
        $query->setLimit(500);
        $query->setOffset(250);

        $expectedSql = $this->getBaseQuery() . <<<SQL
WHERE
    pt.current_revision_id IS NOT NULL
    AND l.abbreviation IN (:lang0,:lang1)
    AND t.type IN (:type0,:type1)
    AND p.id IN (:product0,:product1,:product2)
    AND pts.source IN (:source0)
LIMIT 250,500;
SQL;

        $expectedParams = [
            ':lang0' => 'ro',
            ':lang1' => 'hu',
            ':type0' => 'title',
            ':type1' => 'perex',
            ':product0' => 1,
            ':product1' => 2,
            ':product2' => 3,
            ':source0' => 'manual',
        ];

        $this->doTestFindTranslations($query, $expectedSql, $expectedParams);
    }

    private function doTestFindTranslations(TranslationsQuery $query, string $expectedSql, array $expectedParams = []): void
    {
        $pdo = $this->createMock(\PDO::class);
        $pdo->expects(self::once())
            ->method('prepare')
            ->willReturnCallback(function (string $sql) use ($expectedSql, $expectedParams) {
                self::assertEquals($this->normalizeQuery($expectedSql), $this->normalizeQuery($sql));

                $statement = $this->createMock(\PDOStatement::class);

                $statement->expects(self::once())
                    ->method('execute')
                    ->willReturnCallback(function (array $params = []) use ($expectedParams) {
                        self::assertEquals($expectedParams, $params);
                    });

                $statement->expects(self::once())
                    ->method('fetchAll')
                    ->willReturn([]);

                return $statement;
            });

        $repository = new TranslationsRepository($pdo);
        $repository->findTranslations($query);
    }

    private function getBaseQuery(): string
    {
        return <<<SQL
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

SQL;
    }

    private function normalizeQuery(string $sql): string
    {
        return preg_replace('/\s+/', ' ', $sql);
    }
}
