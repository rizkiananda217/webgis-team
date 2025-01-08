<?php
require_once 'connect.php';

$id = $_GET['id'];

$sql = "delete from permanent_marker where long = '$id '";



 $result = pg_query($dbconn, $sql);
if(!$result){
  echo pg_last_error($dbconn);
} else {
  header("location:index.php");
}




// Close the connection
pg_close($dbconn);

 ?>
