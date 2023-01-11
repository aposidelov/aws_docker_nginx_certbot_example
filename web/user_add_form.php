<?php

header("Cache-Control: no-store, no-cache, must-revalidate");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

if (isset($_POST['name']) && isset($_POST['pass'])) {

  include_once "db_connection.php";

  $username = $_POST['name'];
  $password = $_POST['pass'];

  //$query = get_db_connection()->query("INSERT INTO user (username, password) VALUES ('$username', '$password')");
  $conn = get_db_connection();
  if ($conn->query("INSERT INTO user (username, password) VALUES ('$username', '$password')") === TRUE) {
    //echo "New record created successfully";
  } else {
    //echo "Error:<br>" . $conn->error;
  }
  $conn->close();

  // ONLY HEADERS
  // curl -I -X GET http://localhost
  // SETUP HEADER
  // curl http://localhost -H "My-Cache-Purge:1"

  $output=null;
  $retval=null;
  #exec('curl -I -X GET http://nginx_proxy', $output, $retval);
  exec('curl http://nginx_proxy -H "My-Cache-Purge:1"', $output, $retval);
  //exec('curl -I -X GET http://nginx_proxy', $output, $retval);
  echo "Returned with status $retval and output:\n";
  //print_r($output);

  //var_dump('purge16');
  //die();

  //print '<div style="background-color:darkseagreen; padding: 10px; margin: 10px; font-size: 19px; color:white;">The user has been saved</div>';
  //header("Location: /index.php");
  die();
}

include_once "page-top.php";

?>

<form action="user_add_form.php" method="post">
  <p>Username: <input type="text" name="name" /></p>
  <p>Password: <input type="text" name="pass" /></p>
  <p><input type="submit" /></p>
</form>

<?php include_once "page-bottom.php"; ?>
