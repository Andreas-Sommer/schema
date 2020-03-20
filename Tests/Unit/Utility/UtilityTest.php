<?php

namespace Brotkrueml\Schema\Tests\Unit\Utility;

use Brotkrueml\Schema\Model\Type\Thing;
use Brotkrueml\Schema\Utility\Utility;
use PHPUnit\Framework\TestCase;

class UtilityTest extends TestCase
{
    /**
     * @test
     */
    public function getNamespacedClassNameForType(): void
    {
        $actual = Utility::getNamespacedClassNameForType('Thing');

        self::assertSame(Thing::class, $actual);
    }

    /**
     * @test
     */
    public function getNamespacedClassNameForTypeReturnsNullIftypeDoesNotExist(): void
    {
        $actual = Utility::getNamespacedClassNameForType('DoesNotExist');

        self::assertNull($actual);
    }

    /**
     * @test
     */
    public function setNamespaceForTypesReturnsOriginalNamespace(): void
    {
        $originalNamespace = Utility::setNamespaceForTypes('\\Some\\Namespace');

        self::assertSame('Brotkrueml\\Schema\\Model\\Type', $originalNamespace);

        Utility::setNamespaceForTypes($originalNamespace);
    }
}
