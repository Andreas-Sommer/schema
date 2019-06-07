<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\Type;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

/**
 * A monetary value or range. This type can be used to describe an amount of money such as $50 USD, or a range as in describing a bank account being suitable for a balance between £1,000 and £1,000,000 GBP, or the value of a salary, etc. It is recommended to use PriceSpecification Types to describe the price of an Offer, Invoice, etc.
 *
 * schema.org version 3.6
 */
class MonetaryAmount extends StructuredValue
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('currency', 'maxValue', 'minValue', 'validFrom', 'validThrough', 'value');
    }
}
