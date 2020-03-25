<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\JsonLd;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Core\Model\TypeInterface;
use Brotkrueml\Schema\Model\DataType\Boolean;

/**
 * @internal
 */
final class Renderer implements RendererInterface
{
    private const TAG_TEMPLATE = '<script type="application/ld+json">%s</script>';
    private const CONTEXT = 'http://schema.org';

    private $types = [];
    private $result;

    public function addType(TypeInterface ...$type): void
    {
        $this->types = \array_merge($this->types, $type);
    }

    public function clearTypes(): void
    {
        $this->types = [];
    }

    public function render(): string
    {
        $renderedTypes = [];
        foreach ($this->types as $type) {
            $renderedTypes[] = $this->prepare($type);
        }

        if (empty($renderedTypes)) {
            return '';
        }

        if (\count($renderedTypes) === 1) {
            $result = $renderedTypes[0];
        } else {
            $result = ['@graph' => $renderedTypes];
        }

        $result = \array_merge(['@context' => static::CONTEXT], $result);

        return \sprintf(
            static::TAG_TEMPLATE,
            \json_encode($result, \JSON_UNESCAPED_SLASHES | \JSON_UNESCAPED_UNICODE)
        );
    }

    private function prepare(TypeInterface $type): array
    {
        $this->result = [];

        $this->addTypeToResult($type);
        $this->addIdToResult($type);
        $this->addPropertiesToResult($type);

        return $this->result;
    }

    private function addTypeToResult(TypeInterface $type): void
    {
        $this->result['@type'] = $type->getType();
    }

    private function addIdToResult(TypeInterface $type): void
    {
        $id = $type->getId();
        if ($id) {
            $this->result['@id'] = $id;
        }
    }

    private function addPropertiesToResult(TypeInterface $type): void
    {
        foreach ($type->getPropertyNames() as $propertyName) {
            $propertyValue = $type->getProperty($propertyName);

            if ($propertyValue === null || $propertyValue === '') {
                continue;
            }

            if (\is_array($propertyValue)) {
                $this->result[$propertyName] = [];
                foreach ($propertyValue as $singlePropertyValue) {
                    $this->result[$propertyName][] = $this->getPropertyValueForResult($singlePropertyValue);
                }
                continue;
            }

            $this->result[$propertyName] = $this->getPropertyValueForResult($propertyValue);
        }
    }

    /**
     * @param TypeInterface|bool|string $value
     * @return array|string
     */
    private function getPropertyValueForResult($value)
    {
        if ($value instanceof TypeInterface) {
            return (new self())->prepare($value);
        }

        if (\is_bool($value)) {
            return Boolean::convertToTerm($value);
        }

        if (\is_numeric($value)) {
            return (string)$value;
        }

        return $value;
    }
}
