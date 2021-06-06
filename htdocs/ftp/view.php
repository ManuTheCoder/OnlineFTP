<?php
session_start();
?>
<!DOCTYPE html>
<html>
  <head>
    <link href="https://fonts.googleapis.com/css2?family=Source+Code+Pro&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/prettify/r298/prettify.min.css">
    <style>#loader{ position: fixed; top: 0; left: 0; width: 100%; height: 100%;z-index: 99999999999;backdrop-filter: blur(10px)} * {font-family: 'Source Code Pro', monospace;font-size: 15px} .prettyprint {border: 0 !important}.prettyprint { background: #fff; font-family: inherit !important; border: 0!important } .pln { color: #4d4d4c !important; } ol.linenums { margin-top: 0; margin-bottom: 0; color: #8e908c } li.L0, li.L1, li.L2, li.L3, li.L4, li.L5, li.L6, li.L7, li.L8, li.L9 { padding-left: 1em; background-color: #fff; list-style-type: decimal } @media screen { .str { color: #718c00 !important; } .kwd { color: #8959a8 !important; } .com { color: #8e908c !important; } .typ { color: #4271ae !important; } .lit { color: #f5871f !important; } .pun { color: #4d4d4c !important; } .opn { color: #4d4d4c !important; } .clo { color: #4d4d4c !important; } .tag { color: #c82829 !important; } .atn { color: #f5871f !important; } .atv { color: #3e999f !important; } .dec { color: #f5871f !important; } .var { color: #c82829 !important; } .fun { color: #4271ae !important; } }</style>
  </head>
  <body onload="setTimeout(function(){document.getElementById('loader').style.display = 'none'}, 1000);">
    <div id="loader"></div>
    <pre id="code" class="prettyprint"><?php echo htmlspecialchars(file_get_contents('ftp://'.urlencode($_SESSION['username']). ":".urlencode($_SESSION['password'])."@".urlencode($_SESSION['server'])."/".$_GET['dir'])); ?></pre>
    <script src="https://cdn.rawgit.com/google/code-prettify/master/loader/run_prettify.js"></script>
  </body>
</html>