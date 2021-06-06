<?php
session_start();
$ftp_server = $_SESSION['server'];
$ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
$login = ftp_login($ftp_conn, $_SESSION['username'], $_SESSION['password']);

$old_file = $_POST['dir'];
$new_file = $_POST['name'];

// try to rename $old_file to $new_file
if (ftp_rename($ftp_conn, $old_file, $new_file))
  {
  echo "Renamed $old_file to $new_file";
  }
else
  {
  echo "Problem renaming $old_file to $new_file";
  }

// close connection
ftp_close($ftp_conn);
?>