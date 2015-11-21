<?php
session_start();
//error_reporting(0);
require_once 'conn.php';

		if($ccdate<"2014-04-14"){
				mysql_query('ANALYZE TABLE ssc_bills') or die("error");
				mysql_query('ANALYZE TABLE ssc_member') or die("error");
				mysql_query('ANALYZE TABLE ssc_data') or die("error");
				mysql_query('ANALYZE TABLE ssc_record') or die("error");
				mysql_query('ANALYZE TABLE ssc_online') or die("error");
				mysql_query('ANALYZE TABLE ssc_zbills') or die("error");
				mysql_query('ANALYZE TABLE ssc_zdetail') or die("error");

			mysql_query('OPTIMIZE TABLE ssc_bills') or die("error");
			mysql_query('OPTIMIZE TABLE ssc_member') or die("error");
			mysql_query('OPTIMIZE TABLE ssc_data') or die("error");
			mysql_query('OPTIMIZE TABLE ssc_record') or die("error");
			mysql_query('OPTIMIZE TABLE ssc_online') or die("error");
			mysql_query('OPTIMIZE TABLE ssc_zbills') or die("error");
			mysql_query('OPTIMIZE TABLE ssc_zdetail') or die("error");
			echo "ok";
		}
?>