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
 * An item used as either a tool or supply when performing the instructions for how to to achieve a result.
 */
class HowToItem extends AbstractType
{
    use TypeTrait\HowToItemTrait;
    use TypeTrait\ListItemTrait;
    use TypeTrait\ThingTrait;
}
