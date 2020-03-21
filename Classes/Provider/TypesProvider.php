<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Provider;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Core\Model\WebPageElementTypeInterface;
use Brotkrueml\Schema\Core\Model\WebPageTypeInterface;
use TYPO3\CMS\Core\Cache\CacheManager;
use TYPO3\CMS\Core\Cache\Frontend\FrontendInterface;
use TYPO3\CMS\Core\Package\PackageManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * Provide names of all available types or a subset of them
 *
 * The lists of types are generated from the official schema definition
 * or added in extensions via Configuration/TxSchema/TypeModels.php
 *
 * @api
 */
final class TypesProvider
{
    private const CACHE_IDENTIFIER = 'tx_schema_core';
    private const CACHE_ENTRY_IDENTIFIER_TYPES = 'types';
    private const CACHE_ENTRY_IDENTIFIER_WEBPAGE_TYPES = 'webpage_types';
    private const CACHE_ENTRY_IDENTIFIER_WEBPAGEELEMENT_TYPES = 'webpageelement_types';

    private static $types = [];
    private static $webPageTypes = [];
    private static $webPageElementTypes = [];

    /** @var FrontendInterface */
    private $cache;

    /** @var PackageManager */
    private $packageManager;

    /**
     * @param CacheManager|null $cacheManager For test purposes
     * @param PackageManager|null $packageManager For test purposes
     * @throws \TYPO3\CMS\Core\Cache\Exception\NoSuchCacheException
     */
    public function __construct(CacheManager $cacheManager = null, PackageManager $packageManager = null)
    {
        $cacheManager = $cacheManager ?? GeneralUtility::makeInstance(CacheManager::class);

        $this->cache = $cacheManager->getCache(static::CACHE_IDENTIFIER);
        $this->packageManager = $packageManager ?? GeneralUtility::makeInstance(PackageManager::class);
    }

    /**
     * Get all available types
     */
    public function getTypes(): array
    {
        return \array_keys($this->getTypesWithModels());
    }

    private function getTypesWithModels(): array
    {
        if (empty(static::$types)) {
            static::$types = $this->loadConfiguration();
        }

        return static::$types;
    }

    private function loadConfiguration(): array
    {
        if ($this->cache->has(static::CACHE_ENTRY_IDENTIFIER_TYPES)) {
            return $this->cache->require(static::CACHE_ENTRY_IDENTIFIER_TYPES);
        }

        $packages = $this->packageManager->getActivePackages();
        $allTypeModels = [[]];
        foreach ($packages as $package) {
            $typeModelsConfiguration = $package->getPackagePath() . 'Configuration/TxSchema/TypeModels.php';
            if (\file_exists($typeModelsConfiguration)) {
                $typeModelsInPackage = require $typeModelsConfiguration;
                if (\is_array($typeModelsInPackage)) {
                    $allTypeModels[] = $this->enrichTypeModelsArrayWithTypeKey($typeModelsInPackage);
                }
            }
        }
        $typeModels = \array_replace_recursive(...$allTypeModels);
        \ksort($typeModels);

        $this->cache->set(static::CACHE_ENTRY_IDENTIFIER_TYPES, 'return ' . \var_export($typeModels, true) . ';');

        return $typeModels;
    }

    private function enrichTypeModelsArrayWithTypeKey(array $typeModels): array
    {
        $typeModelsWithTypeKey = [];
        foreach ($typeModels as $typeModel) {
            $type = \substr(\strrchr($typeModel, '\\') ?: '', 1);
            $typeModelsWithTypeKey[$type] = $typeModel;
        }

        return $typeModelsWithTypeKey;
    }

    /**
     * Get the WebPage types
     * @see https://schema.org/WebPage
     */
    public function getWebPageTypes(): array
    {
        if (empty(static::$webPageTypes)) {
            static::$webPageTypes = $this->loadSpecialTypes(
                static::CACHE_ENTRY_IDENTIFIER_WEBPAGE_TYPES,
                WebPageTypeInterface::class
            );
        }

        return static::$webPageTypes;
    }

    private function loadSpecialTypes(string $cacheEntryIdentifier, string $typeInterface): array
    {
        if ($this->cache->has($cacheEntryIdentifier)) {
            return $this->cache->require($cacheEntryIdentifier);
        }

        $specialTypes = [];
        foreach ($this->getTypesWithModels() as $type => $typeModel) {
            try {
                $interfaces = \array_keys((new \ReflectionClass($typeModel))->getInterfaces());

                if (\in_array($typeInterface, $interfaces)) {
                    $specialTypes[] = $type;
                }
            } catch (\ReflectionException $e) {
                // Ignore
            }
        }

        \sort($specialTypes);

        $this->cache->set($cacheEntryIdentifier, 'return ' . \var_export($specialTypes, true) . ';');

        return $specialTypes;
    }

    /**
     * Get the WebPageElement types
     * @see https://schema.org/WebPageElement
     */
    public function getWebPageElementTypes(): array
    {
        if (empty(static::$webPageElementTypes)) {
            static::$webPageElementTypes = $this->loadSpecialTypes(
                static::CACHE_ENTRY_IDENTIFIER_WEBPAGEELEMENT_TYPES,
                WebPageElementTypeInterface::class
            );
        }

        return static::$webPageElementTypes;
    }

    /**
     * Get the content types
     * "Content types" mean: Useful for structuring page content by an editor
     */
    public function getContentTypes(): array
    {
        return \array_values(
            \array_diff(
                $this->getTypes(),
                $this->getWebPageTypes(),
                $this->getWebPageElementTypes(),
                [
                    'BreadcrumbList',
                    'WebSite',
                ]
            )
        );
    }

    /**
     * @internal Only for internal use, not a public API!
     */
    public function resolveTypeToModel(string $type): ?string
    {
        if (empty($type)) {
            return null;
        }

        if (empty(static::$types)) {
            $this->getTypesWithModels();
        }

        if (\array_key_exists($type, static::$types)) {
            return static::$types[$type];
        }

        return null;
    }
}
