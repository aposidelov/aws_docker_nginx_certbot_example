<?php

function get_db_connection() {
  $host = 'mysql';
  $user = 'drupal';
  $pass = 'drupal';
  $database = 'db1';

  return new MySQLi($host, $user, $pass, $database);
}
