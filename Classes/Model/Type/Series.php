<?php
declare(strict_types=1);

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
 * A Series in schema.org is a group of related items, typically but not necessarily of the same kind. See also CreativeWorkSeries, EventSeries.
 */
final class Series extends AbstractType
{
    use TypeTrait\ThingTrait;
}
