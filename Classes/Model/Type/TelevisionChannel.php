<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\Type;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Core\Model\AbstractType;
use Brotkrueml\Schema\Model\TypeTrait;

/**
 * A unique instance of a television BroadcastService on a CableOrSatelliteService lineup.
 */
final class TelevisionChannel extends AbstractType
{
    use TypeTrait\BroadcastChannelTrait;
    use TypeTrait\ThingTrait;
}
