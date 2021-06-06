<?php
session_start();
$file = $_POST['dir'];
$remote_file = $_POST['dir'];
// file_put_contents('ftp://'.urlencode($_SESSION['username']). ":".urlencode($_SESSION['password'])."@".urlencode($_SESSION['server'])."/".$file, 'test');
?>

<?php
/* set the FTP hostname */
$user = $_SESSION['username'];
$pass = $_SESSION['password'];
$host = $_SESSION['server'];
$file = $_POST['dir'];
$hostname = "ftp://".$user . ":" . $pass . "@" . $host . "/" . $file;
/* the file content */
$content = $_POST['file'];
$options = array('ftp' => array('overwrite' => true));
$stream = stream_context_create($options);
file_put_contents($hostname, $content, 0, $stream);
echo 'Success';
?>