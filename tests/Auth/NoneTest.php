<?php
/**
 * Created by PhpStorm.
 * User: junade
 * Date: 04/09/2017
 * Time: 20:08
 */
namespace Cloudflare\Tests\Auth;

use Cloudflare\Tests\TestCase;
use Cloudflare\API\Auth\None;

class NoneTest extends TestCase
{
    public function testGetHeaders()
    {
        $auth    = new None();
        $headers = $auth->getHeaders();

        $this->assertEquals([], $headers);
    }
}
