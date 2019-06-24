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
 * The act of notifying an event organizer as to whether you expect to attend the event.
 */
class RsvpAction extends AbstractType
{
    use TypeTrait\RsvpActionTrait;
    use TypeTrait\InformActionTrait;
    use TypeTrait\CommunicateActionTrait;
    use TypeTrait\ActionTrait;
    use TypeTrait\ThingTrait;
}
