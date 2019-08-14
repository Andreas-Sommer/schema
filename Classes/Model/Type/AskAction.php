<?php
declare(strict_types = 1);

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
 * The act of posing a question / favor to someone.
 */
final class AskAction extends AbstractType
{
    use TypeTrait\ActionTrait;
    use TypeTrait\AskActionTrait;
    use TypeTrait\CommunicateActionTrait;
    use TypeTrait\ThingTrait;
}
