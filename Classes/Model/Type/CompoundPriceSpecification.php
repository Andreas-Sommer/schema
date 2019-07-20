<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\Type;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */
use Brotkrueml\Schema\Core\Model\AbstractType;
use Brotkrueml\Schema\Model\TypeTrait;

/**
 * A compound price specification is one that bundles multiple prices that all apply in combination for different dimensions of consumption. Use the name property of the attached unit price specification for indicating the dimension of a price component (e.g. &quot;electricity&quot; or &quot;final cleaning&quot;).
 */
final class CompoundPriceSpecification extends AbstractType
{
    use TypeTrait\CompoundPriceSpecificationTrait;
    use TypeTrait\PriceSpecificationTrait;
    use TypeTrait\ThingTrait;
}
