<?php

declare(strict_types=1);

use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Endpoints\ZoneSettings;

class ZoneSettingsTest extends TestCase
{
    private $tests = [
        'ServerSideExclude' => ['expects' => 'on', 'update' => 'on'],
        'IPGeolocation' => ['expects' => 'on', 'update' => 'on'],
        'Mirage' => ['expects' => 'off', 'update' => 'on'],
        'Polish' => ['expects' => 'lossless', 'update' => 'lossy'],
        'WebP' => ['expects' => 'off', 'update' => 'on'],
        'Brotli' => ['expects' => 'off', 'update' => 'on'],
        'ResponseBuffering' => ['expects' => 'off', 'update' => 'on'],
        'HTTP2' => ['expects' => 'off', 'update' => 'on'],
        'HTTP3' => ['expects' => 'off', 'update' => 'on'],
        '0RTT' => ['expects' => 'off', 'update' => 'on'],
        'PseudoIPv4' => ['expects' => 'off', 'update' => 'on'],
        'WebSocket' => ['expects' => 'off', 'update' => 'on']
    ];
    
    public function testGetSettings()
    {
        foreach ($this->tests as $method => $value) {
            $response = $this->getPsr7JsonResponseForFixture('Endpoints/get' . $method . 'Setting.json');

            $mock = $this->getMockBuilder(Adapter::class)->disableOriginalConstructor()->getMock();
            $mock->method('get')->willReturn($response);

            $mock->expects($this->once())->method('get');

            $zones = new ZoneSettings($mock);

            $this->assertSame($value['expects'], $zones->{'get' . $method . 'Setting'}('023e105f4ecef8ad9ca31a8372d0c353'));
        }
    }

    public function testUpdateSettings()
    {
        foreach ($this->tests as $method => $value) {
            $response = $this->getPsr7JsonResponseForFixture('Endpoints/update' . $method . 'Setting.json');

            $mock = $this->getMockBuilder(Adapter::class)->disableOriginalConstructor()->getMock();
            $mock->method('patch')->willReturn($response);

            $mock->expects($this->once())->method('patch');

            $zones = new ZoneSettings($mock);
            $this->assertTrue($zones->{'update' . $method . 'Setting'}('023e105f4ecef8ad9ca31a8372d0c353', $value['update']));
        }
    }
}
