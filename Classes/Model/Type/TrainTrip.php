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

/**
 * A trip on a commercial train line.
 */
final class TrainTrip extends AbstractType
{
    protected $properties = [
        'additionalType' => null,
        'alternateName' => null,
        'arrivalPlatform' => null,
        'arrivalStation' => null,
        'arrivalTime' => null,
        'departurePlatform' => null,
        'departureStation' => null,
        'departureTime' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'identifier' => null,
        'image' => null,
        'mainEntityOfPage' => null,
        'name' => null,
        'offers' => null,
        'potentialAction' => null,
        'provider' => null,
        'sameAs' => null,
        'subjectOf' => null,
        'trainName' => null,
        'trainNumber' => null,
        'url' => null,
    ];
}
