<?php
//the mdb2 library is loaded 
 require_once'MDB2.php';
 
 // connection to the database is made
 $dsn = array(
	'phptype' => 'oci8',
	'hostspec' => 'localhost:1522/orcl',
	'username' => 'c##khush',
	'password' => 'khushu15',
 );
 
  $db = MDB2::connect($dsn); 
 // error message if connection does not take place
 if (PEAR::isError($db)) {
	 die('could not create connection to database. "'.$db->getMessage().'"');
 }

?>
