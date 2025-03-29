<?php

declare(strict_types=1);

namespace App\Tests\Service;

use App\Exception\CannotRegisterUnderage;
use App\Service\AgeVerifier;
use DateTimeImmutable;
use PHPUnit\Framework\TestCase;

/**
 * Class AgeVerifierTest.
 *
 * @author bernard-ng <bernard@devscast.tech>
 */
final class AgeVerifierTest extends TestCase
{
    private AgeVerifier $verifier;

    protected function setUp(): void
    {
        $this->verifier = new AgeVerifier();
    }

    public function testAssertNotUnderageThrowsExceptionForUnderage(): void
    {
        $birthdate = new DateTimeImmutable('-17 years');

        $this->expectException(CannotRegisterUnderage::class);
        $this->verifier->assertNotUnderage($birthdate);
    }

    public function testAssertNotUnderageDoesNotThrowForAdult(): void
    {
        $birthdate = new DateTimeImmutable('-19 years');

        $this->expectNotToPerformAssertions();
        $this->verifier->assertNotUnderage($birthdate);
    }

    public function testAssertNotUnderageBorderlineCase(): void
    {
        $birthdate = new DateTimeImmutable('-18 years');

        $this->expectNotToPerformAssertions();
        $this->verifier->assertNotUnderage($birthdate);
    }
}
