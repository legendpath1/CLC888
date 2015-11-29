<?php
require 'conn.php';

echo "Now we test kj script: </br>";

$bool = evaluateCode('16', '151129262', '1,2,3,4,5');

echo "evalueateCode = ".$bool;
?>
