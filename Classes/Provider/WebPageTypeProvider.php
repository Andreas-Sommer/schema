<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Provider;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

/**
 * @internal
 */
final class WebPageTypeProvider
{
    /** @var TypesProvider */
    private static $typesProvider;

    public static function getTypesForTcaSelect(): array
    {
        $types = static::getTypesProvider()->getWebPageTypes();

        \array_walk($types, function (&$type) {
            $type = [$type, $type];
        });

        return \array_merge([['', '']], $types);
    }

    private static function getTypesProvider(): TypesProvider
    {
        if (empty(static::$typesProvider)) {
            static::$typesProvider = new TypesProvider();
        }

        return static::$typesProvider;
    }

    /**
     * For testing purposes only!
     *
     * @param TypesProvider $typesProvider
     */
    public static function setTypesProvider(TypesProvider $typesProvider): void
    {
        static::$typesProvider = $typesProvider;
    }
}
