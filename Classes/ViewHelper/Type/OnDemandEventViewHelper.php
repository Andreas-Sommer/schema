<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\ViewHelper\Type;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

/**
 * A publication event e.g. catch-up TV or radio podcast, during which a program is available on-demand.
 *
 * schema.org version 3.6
 */
class OnDemandEventViewHelper extends PublicationEventViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();
    }
}
