<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Tests\Fixtures\Model\Type;

use Brotkrueml\Schema\Core\Model\AbstractType;
use Brotkrueml\Schema\Core\Model\WebPageTypeInterface;

final class WebPage extends AbstractType implements WebPageTypeInterface
{
    protected $properties = [
        'expires' => null,
    ];
}
