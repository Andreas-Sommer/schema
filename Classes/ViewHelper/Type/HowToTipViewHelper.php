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
 * An explanation in the instructions for how to achieve a result. It provides supplementary information about a technique, supply, author\'s preference, etc. It can explain what could be done, or what should not be done, but doesn\'t specify what should be done (see HowToDirection).
 *
 * schema.org version 3.6
 */
class HowToTipViewHelper extends CreativeWorkViewHelper
{
    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('item', 'mixed', 'An entity represented by an entry in a list or data feed (e.g. an \'artist\' in a list of \'artists\')’.');
        $this->registerArgument('nextItem', 'mixed', 'A link to the ListItem that follows the current one.');
        $this->registerArgument('previousItem', 'mixed', 'A link to the ListItem that preceeds the current one.');
    }
}
