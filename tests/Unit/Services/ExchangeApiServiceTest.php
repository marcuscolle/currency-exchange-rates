<?php

namespace Tests\Unit\Services;

use Tests\TestCase;
use App\Services\Api\ExchangeApi;

class ExchangeApiServiceTest extends TestCase
{
    /** @test */
    public function it_returns_latest_data()
    {
        $service = new ExchangeApi();

        $result = $service->getLatestData();

        $this->assertIsArray($result);
    }
}

