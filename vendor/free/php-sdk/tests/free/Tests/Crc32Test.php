<?php
namespace free\Tests;

use free;

class Crc32Test extends \PHPUnit_Framework_TestCase
{
    public function testData()
    {
        $a = '你好';
        $b = \free\crc32_data($a);
        $this->assertEquals('1352841281', $b);
    }

    public function testFile()
    {
        $b = \free\crc32_file(__file__);
        $c = \free\crc32_file(__file__);
        $this->assertEquals($c, $b);
    }
}
