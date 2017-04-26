<?php
$TIME = "00:00"
$DATE = "2017-4-27"
$tmpFile = "/tmp/autohalt.tmp";
$AutoHalt = "sync; sync; sync; halt -p";

if(file_exists($tmpFile)){
    unlink($tmpFile);
}

$fs = fopen($tmpFile, "w");
fwrite($fs, $AutoHalt);
fclose($fs);

if(file_exists($tmpFile)){
    $result = shell_exec("at $TIME $DATE < $tmpFile");
    echo $result;
    unlink($tmpFile);
}
