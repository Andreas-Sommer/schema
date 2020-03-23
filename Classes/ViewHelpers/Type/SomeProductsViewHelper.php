<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\ViewHelpers\Type;

/*
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

use Brotkrueml\Schema\Core\ViewHelpers\AbstractTypeViewHelper;

/**
 * A placeholder for multiple similar products of the same kind.
 */
final class SomeProductsViewHelper extends AbstractTypeViewHelper
{
    protected static $typeModel = \Brotkrueml\Schema\Model\Type\SomeProducts::class;
}
