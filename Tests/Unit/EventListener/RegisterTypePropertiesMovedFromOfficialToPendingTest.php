<?php
declare(strict_types=1);

namespace Brotkrueml\Schema\Tests\Unit\EventListener;

use Brotkrueml\Schema\Event\RegisterAdditionalTypePropertiesEvent;
use Brotkrueml\Schema\EventListener\RegisterTypePropertiesMovedFromOfficialToPending;
use Brotkrueml\Schema\Model\Type;
use PHPUnit\Framework\TestCase;

class RegisterTypePropertiesMovedFromOfficialToPendingTest extends TestCase
{
    /**
     * @var RegisterTypePropertiesMovedFromOfficialToPending
     */
    private $subject;

    protected function setUp(): void
    {
        $this->subject = new RegisterTypePropertiesMovedFromOfficialToPending();
    }

    /**
     * @test
     */
    public function additionalPropertiesForPersonTypeAreRegistered(): void
    {
        $event = new RegisterAdditionalTypePropertiesEvent(Type\Person::class);
        ($this->subject)($event);

        self::assertContains('gender', $event->getAdditionalProperties());
        self::assertContains('jobTitle', $event->getAdditionalProperties());
    }

    /**
     * @test
     * @dataProvider dataProviderForIneligibleRegion
     */
    public function additionalPropertyIneligibleRegionIsRegisteredCorrectly(string $type): void
    {
        $event = new RegisterAdditionalTypePropertiesEvent($type);
        ($this->subject)($event);

        self::assertContains('ineligibleRegion', $event->getAdditionalProperties());
    }

    public function dataProviderForIneligibleRegion(): array
    {
        return [
            [Type\ActionAccessSpecification::class],
            [Type\AggregateOffer::class],
            [Type\DeliveryChargeSpecification::class],
            [Type\Demand::class],
            [Type\Offer::class],
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderForSport
     */
    public function additionalPropertySportIsRegisteredCorrectly(string $type): void
    {
        $event = new RegisterAdditionalTypePropertiesEvent($type);
        ($this->subject)($event);

        self::assertContains('sport', $event->getAdditionalProperties());
    }

    public function dataProviderForSport(): array
    {
        return [
            [Type\SportsEvent::class],
            [Type\SportsOrganization::class],
            [Type\SportsTeam::class],
        ];
    }

    /**
     * @test
     * @dataProvider dataProviderForSubtitleLanguage
     */
    public function additionalPropertySubtitleLanguageIsRegisteredCorrectly(string $type): void
    {
        $event = new RegisterAdditionalTypePropertiesEvent($type);
        ($this->subject)($event);

        self::assertContains('subtitleLanguage', $event->getAdditionalProperties());
    }

    public function dataProviderForSubtitleLanguage(): array
    {
        return [
            [Type\BroadcastEvent::class],
            [Type\Movie::class],
            [Type\ScreeningEvent::class],
            [Type\TVEpisode::class],
        ];
    }
}
