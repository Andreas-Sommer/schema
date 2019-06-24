<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\Type;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Core\Model\AbstractType;
use Brotkrueml\Schema\Model\TypeTrait;

/**
 * The act of consuming dynamic/moving visual content.
 */
class WatchAction extends AbstractType
{
    use TypeTrait\ConsumeActionTrait;
    use TypeTrait\ActionTrait;
    use TypeTrait\ThingTrait;
}
