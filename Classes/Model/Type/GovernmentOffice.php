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
 * A government office&amp;#x2014;for example, an IRS or DMV office.
 */
final class GovernmentOffice extends AbstractType
{
    use TypeTrait\LocalBusinessTrait;
    use TypeTrait\OrganizationTrait;
    use TypeTrait\PlaceTrait;
    use TypeTrait\ThingTrait;
}
