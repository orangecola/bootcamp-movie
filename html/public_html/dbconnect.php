<?php

  $DB_host = getenv('HOSTNAME');
  $DB_user = getenv('USERNAME');
  $DB_pass = getenv('PASSWORD');
  $DB_name = getenv('DB_NAME');
  
  $MySQLiconn = new MySQLi($DB_host,$DB_user,$DB_pass,$DB_name);
    
     if($MySQLiconn->connect_errno)
     {
         die("ERROR : -> ".$MySQLiconn->connect_error);
     }

?>