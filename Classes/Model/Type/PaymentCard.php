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
 * A payment method using a credit, debit, store or other card to associate the payment with an account.
 */
final class PaymentCard extends AbstractType
{
    protected static $propertyNames = [
        'additionalType',
        'aggregateRating',
        'alternateName',
        'annualPercentageRate',
        'areaServed',
        'audience',
        'availableChannel',
        'award',
        'brand',
        'broker',
        'category',
        'description',
        'disambiguatingDescription',
        'feesAndCommissionsSpecification',
        'hasOfferCatalog',
        'hoursAvailable',
        'identifier',
        'image',
        'interestRate',
        'isRelatedTo',
        'isSimilarTo',
        'logo',
        'mainEntityOfPage',
        'name',
        'offers',
        'potentialAction',
        'provider',
        'providerMobility',
        'review',
        'sameAs',
        'serviceOutput',
        'serviceType',
        'slogan',
        'subjectOf',
        'url',
    ];
}
