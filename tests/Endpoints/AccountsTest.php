<?php
/**
 * User: kanasite
 * Date: 01/28/2019
 * Time: 10:00
 */

namespace Cloudflare\Tests\Endpoints;

use Cloudflare\Tests\TestCase;
use Cloudflare\API\Adapter\Adapter;
use Cloudflare\API\Endpoints\Accounts;

class AccountsTest extends TestCase
{
    public function testListZones()
    {
        $response = $this->getPsr7JsonResponseForFixture('Endpoints/listAccounts.json');

        $mock = $this->getMockBuilder(Adapter::class)->disableOriginalConstructor()->getMock();
        $mock->method('get')->willReturn($response);

        $mock->expects($this->once())
            ->method('get')
            ->with(
                $this->equalTo('accounts'),
                $this->equalTo([
                    'page' => 1,
                    'per_page' => 20,
                    'direction' => 'desc',
                ])
            );

        $accounts = new Accounts($mock);
        $result = $accounts->listAccounts(1, 20, 'desc');

        $this->assertObjectHasAttribute('result', $result);
        $this->assertObjectHasAttribute('result_info', $result);

        $this->assertEquals('023e105f4ecef8ad9ca31a8372d0c353', $result->result[0]->id);
        $this->assertEquals(1, $result->result_info->page);
        $this->assertEquals('023e105f4ecef8ad9ca31a8372d0c353', $accounts->getBody()->result[0]->id);
    }
}
