<?php
declare(strict_types=1);

namespace Tests\Unit\Services\ProductTranslations\Repository\PDO;

use PHPUnit\Framework\TestCase;
use Services\ProductTranslations\Entity\Language;
use Services\ProductTranslations\Entity\Revision;
use Services\ProductTranslations\Entity\Source;
use Services\ProductTranslations\Entity\TextType;
use Services\ProductTranslations\Entity\Translation;
use Services\ProductTranslations\EntityFactory\LanguageFactory;
use Services\ProductTranslations\EntityFactory\RevisionFactory;
use Services\ProductTranslations\EntityFactory\SourceFactory;
use Services\ProductTranslations\EntityFactory\TextTypeFactory;
use Services\ProductTranslations\EntityFactory\TranslationFactory;
use Services\ProductTranslations\Repository\PDO\TranslationFromRowFactory;

class TranslationFromRowFactoryTest extends TestCase
{
    public function testCreateMissingTranslation(): void
    {
        $input = [
            'translation_id' => null,
            'language_id' => '1',
            'language_abbreviation' => 'cz',
            'type_id' => '1',
            'type' => 'title',
            'type_description' => 'Nadpis',
            'product_id' => '1',
            'current_revision_id' => null,
            'current_revision_number' => null,
            'current_translation' => null,
            'source_id' => null,
            'source' => null,
            'source_description' => null,
        ];

        $expectedOutput = new Translation(
            null,
            1,
            new Language(1, 'cz'),
            new TextType(1, 'title', 'Nadpis'),
            null,
            null
        );

        $this->doTestCreateTranslation($input, $expectedOutput);
    }

    public function testCreateActualTranslation(): void
    {
        $input = [
            'translation_id' => '234',
            'language_id' => '1',
            'language_abbreviation' => 'cz',
            'type_id' => '1',
            'type' => 'title',
            'type_description' => 'Nadpis',
            'product_id' => '1',
            'current_revision_id' => '152',
            'current_revision_number' => '8',
            'current_translation' => 'Přeložený text',
            'source_id' => '1',
            'source' => 'manual',
            'source_description' => 'Ruční překlad',
        ];

        $expectedOutput = new Translation(
            234,
            1,
            new Language(1, 'cz'),
            new TextType(1, 'title', 'Nadpis'),
            new Revision(152, 8, 'Přeložený text'),
            new Source(1, 'manual', 'Ruční překlad')
        );

        $this->doTestCreateTranslation($input, $expectedOutput);
    }

    private function doTestCreateTranslation(array $input, Translation $expectedOutput): void
    {
        $factory = new TranslationFromRowFactory(
            new TranslationFactory(),
            new SourceFactory(),
            new TextTypeFactory(),
            new LanguageFactory(),
            new RevisionFactory()
        );
        $output = $factory->create($input);

        self::assertEquals($expectedOutput, $output);
    }
}
