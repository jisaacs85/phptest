<?php

require_once('Connect.php');

use PHPUnit\Framework\TestCase;

class RemoteConnectTest extends TestCase
{
  public function setUp(): void { }
  public function tearDown(): void { }

  public function testConnectionIsValid()
  {
    // test to ensure that the object from an fsockopen is valid
    $connObj = new RemoteConnect();
    $serverName = 'www.yahoo.com';
    $this->assertTrue($connObj->connectToServer($serverName) !== false);
  }
}
?>
