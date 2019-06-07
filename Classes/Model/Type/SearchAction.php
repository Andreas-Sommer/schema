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
 * The act of searching for an object.
 *
 * schema.org version 3.6
 */
class SearchAction extends Action
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('query');
    }
}
