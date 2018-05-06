<?php
namespace free\Tests;

use free\Processing\Operation;
use free\Processing\PersistentFop;

class FopTest extends \PHPUnit_Framework_TestCase
{
    public function testExifPub()
    {
        $fop = new Operation('testres.freedn.com');
        list($exif, $error) = $fop->execute('gogopher.jpg', 'exif');
        $this->assertNull($error);
        $this->assertNotNull($exif);
    }

    public function testExifPrivate()
    {
        global $testAuth;
        $fop = new Operation('private-res.freedn.com', $testAuth);
        list($exif, $error) = $fop->execute('noexif.jpg', 'exif');
        $this->assertNotNull($error);
        $this->assertNull($exif);
    }

    public function testbuildUrl()
    {
        $fops = 'imageView2/2/h/200';
        $fop = new Operation('testres.freedn.com');
        $url = $fop->buildUrl('gogopher.jpg', $fops);
        $this->assertEquals($url, 'http://testres.freedn.com/gogopher.jpg?imageView2/2/h/200');

        $fops = array('imageView2/2/h/200', 'imageInfo');
        $url = $fop->buildUrl('gogopher.jpg', $fops);
        $this->assertEquals($url, 'http://testres.freedn.com/gogopher.jpg?imageView2/2/h/200|imageInfo');
    }
}
