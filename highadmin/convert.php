<?php
require_once 'conn.php';

for ($i = 391; $i <= 1247; $i++) {
   $sql="update ssc_bankcard dest, (select bankbranch, CONVERT(CONVERT(CONVERT(bankbranch USING latin1) USING binary) USING utf8) as c1 from ssc_bankcard where id=".$i.") src set dest.bankbranch = src.c1 where dest.id=".$i."";
   echo $sql;
   mysql_query($sql) or die("Error".mysql_error());
}
?>
