<?php 
session_start();
if(isset($_SESSION['valid'])) {
  header('Location: ./ftp');
}
if(isset($_POST['submit'])) {
  $ftp_server = $_POST['server'];
  $ftp_conn = ftp_connect($ftp_server) or die("Could not connect to $ftp_server");
  ftp_set_option($ftp_conn, FTP_TIMEOUT_SEC, 5);
  $login = ftp_login($ftp_conn, $_POST['uname'], $_POST['pwd']);
  $_SESSION['valid'] = 1;
  $_SESSION['username'] = $_POST['uname'];
  $_SESSION['password'] = $_POST['pwd'];
  $_SESSION['server'] = $_POST['server'];
  ftp_close($ftp_conn);
  header('Location: ./ftp');
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>FTP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@materializecss/materialize@1.1.0-alpha/dist/css/materialize.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  </head>
  <body>
    <form class="container" method="POST">
      <h1>FTP login</h1>
      <div class="input-field">
        <label>Server name or IP</label>
        <input name="server" type="text" autocomplete="off" autofocus>
      </div>
      <div class="input-field">
        <label>Username</label>
        <input name="uname" type="text" autocomplete="off">
      </div>
      <div class="input-field">
        <label>Password</label>
        <input name="pwd" type="password" autocomplete="off">
      </div>
      <button name="submit" class="btn blue-grey darken-3 waves-effect waves-light">Submit</button>
    </form>
    <script src="https://cdn.jsdelivr.net/npm/@materializecss/materialize@1.1.0-alpha/dist/js/materialize.min.js"></script>
  </body>
</html>    