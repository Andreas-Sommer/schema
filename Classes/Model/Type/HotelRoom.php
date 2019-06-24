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
 * A hotel room is a single room in a hotel.
 */
class HotelRoom extends AbstractType
{
    use TypeTrait\AccommodationTrait;
    use TypeTrait\HotelRoomTrait;
    use TypeTrait\PlaceTrait;
    use TypeTrait\ThingTrait;
}
