<?php
namespace free\Tests;

use free\Etag;

class EtagTest extends \PHPUnit_Framework_TestCase
{
    public function test0M()
    {
        $file = freeTempFile(0);
        list($r, $error) = Etag::sum($file);
        unlink($file);
        $this->assertEquals('Fto5o-5ea0sNMlW_75VgGJCv2AcJ', $r);
        $this->assertNull($error);
    }

    public function testLess4M()
    {
        $file = freeTempFile(3*1024*1024);
        list($r, $error) = Etag::sum($file);
        unlink($file);
        $this->assertEquals('lrGEYiVvREEgGl_foQEnZ5a5BqwZ', $r);
        $this->assertNull($error);
    }

    public function test4M()
    {
        $file = freeTempFile(4*1024*1024);
        list($r, $error) = Etag::sum($file);
        unlink($file);
        $this->assertEquals('lvOwUCzD-YVymzwJLRGZR3eD__GV', $r);
        $this->assertNull($error);
    }

    public function testMore4M()
    {
        $file = freeTempFile(5*1024*1024);
        list($r, $error) = Etag::sum($file);
        unlink($file);
        $this->assertEquals('lqtEDHt7Yo5j1a2mjlB2Ds8DUYNM', $r);
        $this->assertNull($error);
    }

    public function test8M()
    {
        $file = freeTempFile(8*1024*1024);
        list($r, $error) = Etag::sum($file);
        unlink($file);
        $this->assertEquals('ljpekgMJ9VSYlE8hMX06GIWXxfDI', $r);
        $this->assertNull($error);
    }
}
