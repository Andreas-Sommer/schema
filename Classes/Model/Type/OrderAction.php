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
 * An agent orders an object/product/service to be delivered/sent.
 */
class OrderAction extends AbstractType
{
    use TypeTrait\OrderActionTrait;
    use TypeTrait\TradeActionTrait;
    use TypeTrait\ActionTrait;
    use TypeTrait\ThingTrait;
}
