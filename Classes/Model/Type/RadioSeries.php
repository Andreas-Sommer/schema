<?php
declare(strict_types = 1);

namespace Brotkrueml\Schema\Model\Type;

/**
 * This file is part of the "schema" extension for TYPO3 CMS.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 */

/**
 * CreativeWorkSeries dedicated to radio broadcast and associated online delivery.
 *
 * schema.org version 3.6
 */
class RadioSeries extends CreativeWorkSeries
{
    public function __construct()
    {
        parent::__construct();

        $this->addProperties('actor', 'containsSeason', 'director', 'episode', 'musicBy', 'numberOfEpisodes', 'numberOfSeasons', 'productionCompany', 'trailer');
    }
}
