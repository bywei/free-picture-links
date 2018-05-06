<?php
namespace free\Tests;

use free;

class Base64Test extends \PHPUnit_Framework_TestCase
{
    public function testUrlSafe()
    {
        $a = '你好';
        $b = \free\base64_urlSafeEncode($a);
        $this->assertEquals($a, \free\base64_urlSafeDecode($b));
    }
}
