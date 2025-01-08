<?php
require_once 'connect.php';

$long = $_POST['long'];
$lang = $_POST['lang'];
$judul = $_POST['judul'];

$sql = "insert into public.permanent_marker (lat,judul,long)  values('$lang','$judul','$long')";

$result = pg_query($dbconn, $sql);

if(!$result){
  echo pg_last_error($dbconn);
} else {
  header("location:index.php");
}

// Close the connection
pg_close($dbconn);

 ?>
