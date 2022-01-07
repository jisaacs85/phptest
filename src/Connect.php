<?php
class RemoteConnect
{
  public function connectToServer($serverName=null)
  {
    if($serverName==null){
      throw new Exception("No server name provided!");
    }
    $fp = fsockopen($serverName,80);
    return ($fp) ? true : false;
  }

  public function returnSampleObject()
  {
    return $this;
  }
}
?>
