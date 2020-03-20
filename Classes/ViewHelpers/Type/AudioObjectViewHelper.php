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
 * An audio file.
 */
final class AudioObjectViewHelper extends AbstractTypeViewHelper
{
    protected static $typeModel = \Brotkrueml\Schema\Model\Type\AudioObject::class;
}
