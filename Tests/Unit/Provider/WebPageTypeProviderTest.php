<?php

namespace Brotkrueml\Schema\Tests\Unit\Provider;

use Brotkrueml\Schema\Provider\TypesProvider;
use Brotkrueml\Schema\Provider\WebPageTypeProvider;
use PHPUnit\Framework\TestCase;

class WebPageTypeProviderTest extends TestCase
{
    protected $availableWebPageTypesForTesting = [
        'FooPage',
        'BarPage',
        'SomePage',
        'AnotherPage',
    ];

    protected function setUp(): void
    {
        $typesProviderStub = $this->createStub(TypesProvider::class);
        $typesProviderStub
            ->method('getWebPageTypes')
            ->willReturn($this->availableWebPageTypesForTesting);

        WebPageTypeProvider::setTypesProvider($typesProviderStub);
    }
    public function dataProvider(): iterable
    {
        foreach ($this->availableWebPageTypesForTesting as $type) {
            yield \sprintf('Type "%s"', $type) => [$type];
        }
    }

    /**
     * @test
     * @dataProvider dataProvider
     *
     * @param string $type
     */
    public function getTypesForTcaSelectReturnsAllAvailableWebPageTypes(string $type): void
    {
        $actual = WebPageTypeProvider::getTypesForTcaSelect();

        self::assertContains([$type, $type], $actual);
    }

    /**
     * @test
     */
    public function getTypesForTcaSelectHasEmptyOption(): void
    {
        $actual = WebPageTypeProvider::getTypesForTcaSelect();

        self::assertContains(['', ''], $actual);
    }
}
