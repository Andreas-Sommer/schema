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
 * A PublicationEvent corresponds indifferently to the event of publication for a CreativeWork of any type e.g. a broadcast event, an on-demand event, a book/journal publication via a variety of delivery media.
 */
final class PublicationEvent extends AbstractType
{
    protected $properties = [
        'about' => null,
        'actor' => null,
        'additionalType' => null,
        'aggregateRating' => null,
        'alternateName' => null,
        'attendee' => null,
        'audience' => null,
        'composer' => null,
        'contributor' => null,
        'description' => null,
        'director' => null,
        'disambiguatingDescription' => null,
        'doorTime' => null,
        'duration' => null,
        'endDate' => null,
        'eventStatus' => null,
        'funder' => null,
        'identifier' => null,
        'image' => null,
        'inLanguage' => null,
        'isAccessibleForFree' => null,
        'location' => null,
        'mainEntityOfPage' => null,
        'maximumAttendeeCapacity' => null,
        'name' => null,
        'offers' => null,
        'organizer' => null,
        'performer' => null,
        'potentialAction' => null,
        'previousStartDate' => null,
        'publishedOn' => null,
        'recordedIn' => null,
        'remainingAttendeeCapacity' => null,
        'review' => null,
        'sameAs' => null,
        'sponsor' => null,
        'startDate' => null,
        'subEvent' => null,
        'subjectOf' => null,
        'superEvent' => null,
        'translator' => null,
        'typicalAgeRange' => null,
        'url' => null,
        'workFeatured' => null,
        'workPerformed' => null,
    ];
}
