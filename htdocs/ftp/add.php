<?php
session_start();
if($_POST['folder'] !== 'on') {
  $user = $_SESSION['username'];
  $pass = $_SESSION['password'];
  $host = $_SESSION['server'];
  $file = $_POST['dir']."/".$_POST['file_name'];
  $hostname = "ftp://". $user . ":" . $pass . "@" . $host . "/" . $file;
  $content = "";
  $options = array('ftp' => array('overwrite' => true));
  $stream = stream_context_create($options);
  file_put_contents($hostname, $content, 0, $stream);
}
else {
  $ftp_server = $_SESSION['server'];
  $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
  $login = ftp_login($ftp_conn, $_SESSION['username'], $_SESSION['password']);
  $dir = $_POST['dir']."/".$_POST['file_name'];
  if (ftp_mkdir($ftp_conn, $dir))
  {
    echo "";
  }
  else
  {
    echo "Error while creating $dir";
  }
  ftp_close($ftp_conn);
}
?>
Success