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
 * The act of notifying someone that a future event/action is going to happen as expected.
 *
 * schema.org version 3.6
 */
class ConfirmAction extends InformAction
{
    public function __construct()
    {
        parent::__construct();
    }
}
