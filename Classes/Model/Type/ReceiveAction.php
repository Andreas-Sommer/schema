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
use Brotkrueml\Schema\Model\TypeTrait;

/**
 * The act of physically/electronically taking delivery of an object thathas been transferred from an origin to a destination. Reciprocal of SendAction.
 */
final class ReceiveAction extends AbstractType
{
    use TypeTrait\ActionTrait;
    use TypeTrait\ReceiveActionTrait;
    use TypeTrait\ThingTrait;
    use TypeTrait\TransferActionTrait;
}
