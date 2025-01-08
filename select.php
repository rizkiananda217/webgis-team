<?php
require_once 'connect.php';


$result = pg_query($dbconn, "SELECT * FROM permanent_marker");
if (!$result) {
    echo "An error occurred.\n";
    exit;
}

$arr = pg_fetch_all($result);

print json_encode($arr);
?>
