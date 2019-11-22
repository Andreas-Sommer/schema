<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Tests\Unit\Manager;

use Brotkrueml\Schema\Manager\SchemaManager;
use Brotkrueml\Schema\Model\Type\BreadcrumbList;
use Brotkrueml\Schema\Model\Type\CollectionPage;
use Brotkrueml\Schema\Model\Type\Thing;
use Brotkrueml\Schema\Model\Type\WebPage;
use PHPUnit\Framework\TestCase;

class SchemaManagerTest extends Testcase
{
    /**
     * @var SchemaManager
     */
    protected $subject;

    protected function setUp(): void
    {
        $this->subject = new SchemaManager();
    }

    /**
     * @test
     */
    public function renderJsonLdWithNoTypeAddedReturnsEmptyString(): void
    {
        $actual = $this->subject->renderJsonLd();

        self::assertSame('', $actual);
    }

    /**
     * @test
     */
    public function renderJsonLdWithOneTypeAddedReturnsCorrectJson(): void
    {
        $actual = $this->subject
            ->addType((new Thing())->setProperty('name', 'Some test thing'))
            ->renderJsonLd();

        $expected = '<script type="application/ld+json">{"@context":"http://schema.org","@type":"Thing","name":"Some test thing"}</script>';

        self::assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function renderJsonLdWithTwoTypesAddedReturnsCorrectJsonArray(): void
    {
        $actual = $this->subject
            ->addType((new Thing())->setProperty('name', 'Some test thing'))
            ->addType((new Thing())->setId('someId')->setProperty('name', 'Some other thing'))
            ->renderJsonLd();

        $expected = '<script type="application/ld+json">{"@context":"http://schema.org","@graph":[{"@type":"Thing","name":"Some test thing"},{"@type":"Thing","@id":"someId","name":"Some other thing"}]}</script>';

        self::assertSame($expected, $actual);
    }

    /**
     * @test
     */
    public function hasWebPageReturnsFalseWhenNoWebPageIsSet(): void
    {
        $actual = $this->subject->hasWebPage();

        self::assertFalse($actual);
    }

    /**
     * @test
     */
    public function hasWebPageReturnsTrueWhenWebPageIsSet(): void
    {
        $webPage = new WebPage();
        $this->subject->addType($webPage);

        $actual = $this->subject->hasWebPage();

        self::assertTrue($actual);
    }

    /**
     * @test
     */
    public function addedWebPageIsAvailableAndRendersCorrectly(): void
    {
        $webPage = (new WebPage())->setProperty('name', 'Some web page');
        $this->subject->addType($webPage);

        $actual = $this->subject->renderJsonLd();

        self::assertSame('<script type="application/ld+json">{"@context":"http://schema.org","@type":"WebPage","name":"Some web page"}</script>', $actual);
    }

    /**
     * @test
     */
    public function onlyOneWebPageIsUsedWhenAddingMoreThanOne(): void
    {
        $webPage = (new WebPage())->setProperty('name', 'Some web page');
        $this->subject->addType($webPage);

        $collectionPage = (new CollectionPage())->setProperty('name', 'Some collection page');
        $this->subject->addType($collectionPage);

        $actual = $this->subject->renderJsonLd();

        self::assertSame('<script type="application/ld+json">{"@context":"http://schema.org","@type":"CollectionPage","name":"Some collection page"}</script>', $actual);
    }

    /**
     * @test
     */
    public function addBreadcrumbListRendersCorrectly(): void
    {
        $breadcrumbList1 = (new BreadcrumbList())->setProperty('name', 'some breadcrumb list');
        $this->subject->addType($breadcrumbList1);

        $actual1 = $this->subject->renderJsonLd();

        self::assertSame('<script type="application/ld+json">{"@context":"http://schema.org","@type":"BreadcrumbList","name":"some breadcrumb list"}</script>', $actual1);

        $breadcrumbList2 = (new BreadcrumbList())->setProperty('name', 'another breadcrumb list');
        $this->subject->addType($breadcrumbList2);

        $actual2 = $this->subject->renderJsonLd();

        self::assertSame('<script type="application/ld+json">{"@context":"http://schema.org","@graph":[{"@type":"BreadcrumbList","name":"some breadcrumb list"},{"@type":"BreadcrumbList","name":"another breadcrumb list"}]}</script>', $actual2);
    }

    /**
     * @test
     */
    public function addBreadcrumbListIndependentFromWebPageIncludesBreadcrumbIntoWebPageMarkup(): void
    {
        $webPage = (new WebPage())->setProperty('name', 'Some web page');
        $this->subject->addType($webPage);

        $breadcrumbList1 = (new BreadcrumbList())->setProperty('name', 'some breadcrumb list');
        $this->subject->addType($breadcrumbList1);

        $breadcrumbList2 = (new BreadcrumbList())->setProperty('name', 'another breadcrumb list');
        $this->subject->addType($breadcrumbList2);

        $actual = $this->subject->renderJsonLd();

        self::assertSame('<script type="application/ld+json">{"@context":"http://schema.org","@type":"WebPage","breadcrumb":[{"@type":"BreadcrumbList","name":"some breadcrumb list"},{"@type":"BreadcrumbList","name":"another breadcrumb list"}],"name":"Some web page"}</script>', $actual);
    }

    /**
     * @test
     */
    public function breadcrumbFromWebPageIsMergedWithIndependentlySetBreadcrumb(): void
    {
        $webPage = new WebPage();
        $webPage->setProperty(
            'breadcrumb',
            (new BreadcrumbList())->setProperty('name', 'Breadcrumb in WebPage')
        );
        $this->subject->addType($webPage);

        $breadcrumbList = (new BreadcrumbList())->setProperty('name', 'Independent breadcrumb');
        $this->subject->addType($breadcrumbList);

        $actual = $this->subject->renderJsonLd();

        self::assertSame('<script type="application/ld+json">{"@context":"http://schema.org","@type":"WebPage","breadcrumb":[{"@type":"BreadcrumbList","name":"Breadcrumb in WebPage"},{"@type":"BreadcrumbList","name":"Independent breadcrumb"}]}</script>', $actual);
    }

    /**
     * @test
     */
    public function multipleBreadcrumbsFromWebPageAreMergedWithIndependentlySetBreadcrumb(): void
    {
        $webPage = new WebPage();
        $webPage->addProperty(
            'breadcrumb',
            (new BreadcrumbList())->setProperty('name', 'One breadcrumb in WebPage')
        );
        $webPage->addProperty(
            'breadcrumb',
            (new BreadcrumbList())->setProperty('name', 'Another breadcrumb in WebPage')
        );
        $this->subject->addType($webPage);

        $breadcrumbList = (new BreadcrumbList())->setProperty('name', 'Independent breadcrumb');
        $this->subject->addType($breadcrumbList);

        $actual = $this->subject->renderJsonLd();

        self::assertSame('<script type="application/ld+json">{"@context":"http://schema.org","@type":"WebPage","breadcrumb":[{"@type":"BreadcrumbList","name":"One breadcrumb in WebPage"},{"@type":"BreadcrumbList","name":"Another breadcrumb in WebPage"},{"@type":"BreadcrumbList","name":"Independent breadcrumb"}]}</script>', $actual);
    }

    /**
     * @test
     */
    public function breadcrumbsFromWebPageWhichAreNotOfTypeBreadcrumbListAreIgnored(): void
    {
        $webPage = new WebPage();
        $webPage->addProperty(
            'breadcrumb',
            (new BreadcrumbList())->setProperty('name', 'BreadcrumbList breadcrumb in WebPage')
        );
        $webPage->addProperty(
            'breadcrumb',
            (new Thing())->setProperty('name', 'Thingy breadcrumb in WebPage')
        );
        $this->subject->addType($webPage);

        $breadcrumbList = (new BreadcrumbList())->setProperty('name', 'Independent breadcrumb');
        $this->subject->addType($breadcrumbList);

        $actual = $this->subject->renderJsonLd();

        self::assertSame('<script type="application/ld+json">{"@context":"http://schema.org","@type":"WebPage","breadcrumb":[{"@type":"BreadcrumbList","name":"BreadcrumbList breadcrumb in WebPage"},{"@type":"BreadcrumbList","name":"Independent breadcrumb"}]}</script>', $actual);
    }

    /**
     * @test
     */
    public function setMainEntityOfWebPageReturnsInstanceOfSchemaManager(): void
    {
        $actual = $this->subject->setMainEntityOfWebPage(new Thing());

        self::assertInstanceOf(SchemaManager::class, $actual);
    }

    /**
     * @test
     */
    public function setMainEntityOfWebPageWithWebPageAvailable(): void
    {
        $webPage = new WebPage();
        $this->subject->addType($webPage);

        $mainEntity = (new Thing())->setProperty('name', 'A thing, set as main entity');
        $this->subject->setMainEntityOfWebPage($mainEntity);

        $actual = $this->subject->renderJsonLd();

        self::assertSame('<script type="application/ld+json">{"@context":"http://schema.org","@type":"WebPage","mainEntity":{"@type":"Thing","name":"A thing, set as main entity"}}</script>', $actual);
    }

    /**
     * @test
     */
    public function setMainEntityOfWebPageWithoutWebPageAvailable(): void
    {
        $mainEntity = (new Thing())->setProperty('name', 'A thing, set as main entity');
        $this->subject->setMainEntityOfWebPage($mainEntity);

        $actual = $this->subject->renderJsonLd();

        self::assertSame('<script type="application/ld+json">{"@context":"http://schema.org","@type":"Thing","name":"A thing, set as main entity"}</script>', $actual);
    }

    /**
     * @test
     */
    public function setMainEntityOfWebPageTwiceWithWebPageAvailable(): void
    {
        $webPage = new WebPage();
        $this->subject->addType($webPage);

        $mainEntity1 = (new Thing())->setProperty('name', 'A thing, set as main entity #1');
        $this->subject->setMainEntityOfWebPage($mainEntity1);

        $mainEntity2 = (new Thing())->setProperty('name', 'A thing, set as main entity #2');
        $this->subject->setMainEntityOfWebPage($mainEntity2);

        $actual = $this->subject->renderJsonLd();

        self::assertSame('<script type="application/ld+json">{"@context":"http://schema.org","@graph":[{"@type":"WebPage","mainEntity":{"@type":"Thing","name":"A thing, set as main entity #2"}},{"@type":"Thing","name":"A thing, set as main entity #1"}]}</script>', $actual);
    }

    /**
     * @test
     */
    public function setWebPageAndMainEntityOfWebPageAfterThatPreservesFirstType(): void
    {
        $webPage = (new WebPage())
            ->setProperty(
                'mainEntity',
                (new Thing())
                    ->setProperty('name', 'A thing, set as main entity directly in WebPage')
            );
        $this->subject->addType($webPage);

        $newMainEntity = (new Thing())->setProperty('name', 'A thing, set as new main entity');
        $this->subject->setMainEntityOfWebPage($newMainEntity);

        $actual = $this->subject->renderJsonLd();

        self::assertSame('<script type="application/ld+json">{"@context":"http://schema.org","@graph":[{"@type":"WebPage","mainEntity":{"@type":"Thing","name":"A thing, set as new main entity"}},{"@type":"Thing","name":"A thing, set as main entity directly in WebPage"}]}</script>', $actual);
    }
}
