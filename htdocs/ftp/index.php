<?php
session_start();
if(!isset($_SESSION['valid'])) {
  header('Location: ../');
}
?>
<!DOCTYPE html>
<html>
  <head>
    <title>FTP</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@materializecss/materialize@1.0.0/dist/css/materialize.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.13.4/codemirror.css'>
    <link rel="stylesheet" href="https://codemirror.net/theme/material.css">
    <link rel="shortcut icon" href="https://img.icons8.com/cotton/452/yellow-file--v1.png">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.13.4/theme/material.css">
    <link rel="stylesheet" href="edit.css">
    <style>
      nav a:hover {background: rgba(0, 0, 0, 0.03) !important}
      [data-theme="dark"] input {
        color: white
      }
      .CodeMirror-simplescroll-horizontal div, .CodeMirror-simplescroll-vertical div { position: absolute; background: #ccc; -moz-box-sizing: border-box; box-sizing: border-box; border: 1px solid #bbb; border-radius: 2px; } .CodeMirror-simplescroll-horizontal, .CodeMirror-simplescroll-vertical { position: absolute; z-index: 6; background: #eee; } .CodeMirror-simplescroll-horizontal { bottom: 0; left: 0; height: 8px; } .CodeMirror-simplescroll-horizontal div { bottom: 0; height: 100%; } .CodeMirror-simplescroll-vertical { right: 0; top: 0; width: 8px; } .CodeMirror-simplescroll-vertical div { right: 0; width: 100%; } .CodeMirror-overlayscroll .CodeMirror-scrollbar-filler, .CodeMirror-overlayscroll .CodeMirror-gutter-filler { display: none; } .CodeMirror-overlayscroll-horizontal div, .CodeMirror-overlayscroll-vertical div { position: absolute; background: #bcd; border-radius: 3px; } .CodeMirror-overlayscroll-horizontal, .CodeMirror-overlayscroll-vertical { position: absolute; z-index: 6; } .CodeMirror-overlayscroll-horizontal { bottom: 0; left: 0; height: 6px; } .CodeMirror-overlayscroll-horizontal div { bottom: 0; height: 100%; } .CodeMirror-overlayscroll-vertical { right: 0; top: 0; width: 6px; } .CodeMirror-overlayscroll-vertical div { right: 0; width: 100%; }
    </style>
    <script>
      $(document).ready(function(){
        $("#search").on("keyup", function() {
          var value = $(this).val().toLowerCase();
          $("#files li").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
          });
        });
      });
    </script>
  </head>
  <body style="width:100%;height:100%" onload="document.getElementById('progress').style.display = 'none'">
    <nav>
      <div class="nav-wrapper">
        <ul><li><a href="#">Online FTP</a></li></ul>
        <ul id="nav-mobile" class="right hide-on-med-and-down">
          <li><a href="#" onclick="dark()">Dark mode</a></li>
          <li><a href="#" style="line-height: 1.3 !important;padding: 13px 10px" onclick="$('#settings').modal('open')"><b style="display:block"><?php echo $_SESSION['username']?></b><span style="color:gray;line-height: 10px !important"><?php echo $_SESSION['server']?></span></a></li>
        </ul>
      </div>
    </nav>
    <div class="progress" id="progress">
      <div class="indeterminate"></div>
    </div>
    <div style="display:block;width:100%;margin-top: 10px">
      <div class="container">
        <div style="width: 50%;float:right">
          <div class="input-field">
            <label>Search...</label>
            <input id="search" type="text" autofocus>
          </div>
        </div>
      </div>
    </div>
    <br><br>
    <br><br>
    <div id="ajaxLoader">
    </div>
    <div id="settings" class="modal bottom-sheet modal-fixed-footer" style="height: 50% !important; min-height: 50% !important;color:inherit;width: 50% !important;background: white">
      <div class="modal-content">
        <h4>
          Settings
        </h4>
        <div class="collection">
          <a href="logout.php" class="collection-item waves-effect">Logout</a>
        </div>          
      </div>
      <div class="modal-footer" style="background: white">
        <a class="btn btn-flat modal-close">Close</a>
      </div>
    </div>
    <div class="container" id="container">
      <ul class="collection" id="files">   
        <?php
  $path = "/";
            $conn_id = ftp_connect($_SESSION['server']);
            $login_result = ftp_login($conn_id, $_SESSION['username'], $_SESSION['password']);
            $contents = ftp_nlist($conn_id, $path);
            foreach($contents as $files) {
              $path = $files;
              $image = pathinfo($path, PATHINFO_EXTENSION);
              switch($image) {
                case 'html': $image = 'https://cdn.pixabay.com/photo/2017/08/05/11/16/logo-2582748_1280.png';  break;
                case 'htm': $image = 'https://cdn.pixabay.com/photo/2017/08/05/11/16/logo-2582748_1280.png';  break;
                case 'css': $image = 'https://cdn.pixabay.com/photo/2017/08/05/11/16/logo-2582747_1280.png';  break;
                case 'js': $image = 'https://upload.wikimedia.org/wikipedia/commons/6/6a/JavaScript-logo.png';  break;
                case 'png': $image = 'https://winaero.com/blog/wp-content/uploads/2019/11/Photos-new-icon.png';  break;
                case 'jpg': $image = 'https://winaero.com/blog/wp-content/uploads/2019/11/Photos-new-icon.png';  break;
                case 'txt': $image = 'https://freeiconshop.com/wp-content/uploads/edd/txt-flat.png'; break;
                case 'c': $image = 'https://cdn.iconscout.com/icon/free/png-512/c-programming-569564.png'; break;
                case 'cpp': $image = 'https://user-images.githubusercontent.com/42747200/46140125-da084900-c26d-11e8-8ea7-c45ae6306309.png'; break;
                case 'py': $image = 'https://cdn3.iconfinder.com/data/icons/logos-and-brands-adobe/512/267_Python-512.png'; break;
                case 'pdf': $image = 'https://i.pinimg.com/originals/28/d1/61/28d1616c72589f9b4a633bb7dccfcfc3.png'; break;
                case 'htaccess': $image = 'https://7-views.com/wp-content/uploads/2018/10/images_icons_products_products_apache_logo_v2-2.png'; break;
                case 'php': $image = 'https://www.pngfind.com/pngs/m/146-1466902_php-logo-png-transparent-php-logo-png-png.png'; break;
                default: $image = 'https://www.iconbunny.com/icons/media/catalog/product/3/7/3783.9-file-icon-iconbunny.jpg'; break;
              }
              if($files == '..') {
                $files = dirname(urldecode($path));
              }
              echo '<li href="#" class="collection-item waves-effect avatar" onclick="ajax_load(\'./files.php?dir='.urlencode($path).'\')"><img src="'.$image.'" class="circle"><h6>'. $files. '</h6></li>'."\n";
            }
        ?>
      </ul>
    </div>
    <div id="edit" class="modal bottom-sheet modal-fixed-footer">
      <div id="modal-content">
        <h6>Loading...</h6>
      </div>
    </div>
    <div id="delete" class="modal" style="background:white;color:black">
      <div id="modal-content" style="padding:20px">
        <h4>Delete?</h4>
        <p>
          This action is irreversible!
        </p>
      </div>
      <div class="modal-footer"style="background: white">
		<a href="#" class="waves-effect btn modal-close btn-flat">Close</a>
		<a href="#" class="waves-effect btn btn-flat" id="delete_md">Delete</a>
      </div>
    </div>
    <div id="add_file" class="modal">
      Loading...
    </div>
    <div id="rename" class="modal">
      Loading...
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.hotkeys/0.2.0/jquery.hotkeys.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@materializecss/materialize@1.0.0/dist/js/materialize.min.js"></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.13.4/codemirror.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.13.4/mode/xml/xml.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.13.4/mode/clike/clike.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.13.4/mode/php/php.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.13.4/mode/css/css.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.13.4/mode/javascript/javascript.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.13.4/mode/htmlmixed/htmlmixed.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.13.4/mode/sql/sql.js'></script>
    <script src='https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.13.4/mode/markdown/markdown.js'></script>
    <script src="https://codemirror.net/addon/scroll/simplescrollbars.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.13.4/addon/edit/closetag.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.13.4/addon/edit/closebrackets.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.48.4/addon/search/jump-to-line.js"></script>
    <script src="https://unpkg.com/jshint@2.9.6/dist/jshint.js"></script>
    <script src="https://codemirror.net/addon/scroll/simplescrollbars.js"></script>
    <script src="https://unpkg.com/jsonlint@1.6.3/web/jsonlint.js"></script>
    <script src="https://codemirror.net/addon/search/matchesonscrollbar.js"></script>
    <script src="https://unpkg.com/csslint@1.0.5/dist/csslint.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.48.4/addon/lint/lint.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.48.4/addon/lint/javascript-lint.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.48.4/addon/lint/css-lint.js"></script>
    <script src="https://codemirror.net/addon/comment/comment.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.48.4/addon/lint/json-lint.js"></script>
    <!--Search-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.13.4/addon/search/search.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.13.4/addon/search/searchcursor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.13.4/addon/dialog/dialog.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/codemirror/5.13.4/addon/search/jump-to-line.js"></script>
    <script>
      function dark() {
        if(document.documentElement.getAttribute('data-theme') == "light") {
          document.documentElement.setAttribute('data-theme', "dark");
          localStorage.setItem('theme', 'dark');
        }
        else {
          document.documentElement.setAttribute('data-theme', "light");
          localStorage.setItem('theme', 'light');
        }
      }
      if(localStorage.getItem('theme') == 'dark') { 
        document.documentElement.setAttribute('data-theme', 'dark')
      }
      else {
        dark();
      }
      function ajax_load(data) {
        document.getElementById('progress').style.display = 'block';
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
          if (this.readyState == 4 && this.status == 200) {
            document.getElementById("container").innerHTML = xhttp.responseText;
            document.getElementById('progress').style.display = "none";
          }
        };
        xhttp.open("GET", data, true);
        xhttp.send();
      }
      $('.modal').modal({
        dismissible: false,
        endingTop: '50%',
        onCloseEnd: function() {window.onbeforeunload = null}
      });
      function edit_file(file, filetype) {
        $('#edit').modal('open');
        $('#edit').load('edit.php?id='+ encodeURI(file) + "&filetype=" + filetype);
        document.getElementById('edit').innerHTML = '';
        htmlEditor.CodeMirror.toTextArea(); 
      }
      function delete_file(file, el, dir=1) {
        $('#delete').modal('open');
        document.getElementById('delete_md').onclick = function() {$('#ajaxLoader').load('delete.php?dir='+encodeURI(file) +"&dirt="+dir);el.style.display = "none"}
      }
      function rename_file(file) {
        $('#rename').modal('open');
        $('#rename').load('rename_modal.php?file='+ encodeURI(file));
      }
      function windowOpen(file) {
        window.open('view.php?dir='+ encodeURI(file));
      }
    </script>
  </body>
</html>