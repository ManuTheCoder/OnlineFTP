<?php 
session_start();
if(!isset($_SESSION['valid'])) {
  header('Location: ../');
}
if($_GET['dirt'] !== 1) {
  $ftp_server = $_SESSION['server'];
  $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
  $login = ftp_login($ftp_conn, $_SESSION['username'], $_SESSION['password']);

  $file = $_GET['dir']."/";
  
  if (ftp_delete($ftp_conn, $file))
  {
    echo "";
  }
  else
  {
    echo "Could not delete $file";
  }

  // close connection
  ftp_close($ftp_conn);
}
else {
  $ftp_server = $_SESSION['server'];
  $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
  $login = ftp_login($ftp_conn, $_SESSION['username'], $_SESSION['password']);
  $dir = $_GET['dir'];

  // try to delete $dir
  if (ftp_rmdir($ftp_conn, $dir)) {
    echo "";
  }
  else{
    echo "Problem deleting $dir";
  }

  // close connection
  ftp_close($ftp_conn);
}
?>    