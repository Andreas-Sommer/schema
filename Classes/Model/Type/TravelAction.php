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
 * The act of traveling from an fromLocation to a destination by a specified mode of transport, optionally with participants.
 */
class TravelAction extends AbstractType
{
    use TypeTrait\TravelActionTrait;
    use TypeTrait\MoveActionTrait;
    use TypeTrait\ActionTrait;
    use TypeTrait\ThingTrait;
}
