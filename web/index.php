<?php

/*
header("Cache-Control: no-store, no-cache, must-revalidate");

echo 'hello3';
if (isset($_COOKIE["_ga"])) {
  unset($_COOKIE["_ga"]);
}
var_dump($_COOKIE);
exit;
*/

include_once "db_connection.php";

include_once "page-top.php";

$users = [];
$output = '<table border="1"><thead><td>Id</td><td>Name</td><td>Password</td></thead><tbody>';
$conn = get_db_connection();
if ($result = get_db_connection()->query('SELECT * FROM user')) {
  while ($data = $result->fetch_assoc()) {
    $users[] = $data;
    $output .= "<tr><td>".$data['userId']."</td><td>".$data['username']."</td><td>".$data['password']."</td></tr>";
  }
}
$output .= '</tbody></table>';
echo $output;
$conn->close();

include_once "page-bottom.php";
