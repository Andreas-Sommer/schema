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
 * A set of characteristics belonging to businesses, e.g. who compose an item\&#039;s target audience.
 */
final class BusinessAudience extends AbstractType
{
    protected $properties = [
        'additionalType' => null,
        'alternateName' => null,
        'audienceType' => null,
        'description' => null,
        'disambiguatingDescription' => null,
        'geographicArea' => null,
        'identifier' => null,
        'image' => null,
        'mainEntityOfPage' => null,
        'name' => null,
        'numberOfEmployees' => null,
        'potentialAction' => null,
        'sameAs' => null,
        'subjectOf' => null,
        'url' => null,
        'yearlyRevenue' => null,
        'yearsInOperation' => null,
    ];
}
