<?php
declare(strict_types=1);

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

namespace Brotkrueml\Schema\ViewHelpers\Type;

use Brotkrueml\Schema\Core\ViewHelpers\AbstractTypeViewHelper;

/**
 * The act of physically/electronically taking delivery of an object thathas been transferred from an origin to a destination. Reciprocal of SendAction.
 */
final class ReceiveActionViewHelper extends AbstractTypeViewHelper
{
    protected static $typeModel = \Brotkrueml\Schema\Model\Type\ReceiveAction::class;
}
