<?php 
session_start(); 
$dir = $_GET['id'];
$filetype = $_GET['filetype'];
if($filetype == 'html') {
  $filetype = "htmlmixed";
}
if($filetype == 'php') {
  $filetype = "application/x-httpd-php";
}
if($filetype == 'js') {
  $filetype = "javascript";
}
?>
<style>
/* The lint marker gutter */
.CodeMirror-lint-markers {
  width: 20px;
}

.CodeMirror-lint-tooltip {
  background-color: #fff;
  color: black;
  border-radius: 3px;
  font-family: monospace;
  font-size: 15px;
  overflow: hidden;
  padding: 10px;
  position: fixed;
  color: white;
  white-space: pre;
  max-width: auto;
  width: auto;
  opacity: 0;
  background: #212121;
  transition: opacity .2s;
}
.CodeMirror-lint-mark-warning {
  background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAQAAAADCAYAAAC09K7GAAAAAXNSR0IArs4c6QAAAAZiS0dEAP8A/wD/oL2nkwAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9sJFhQXEbhTg7YAAAAZdEVYdENvbW1lbnQAQ3JlYXRlZCB3aXRoIEdJTVBXgQ4XAAAAMklEQVQI12NkgIIvJ3QXMjAwdDN+OaEbysDA4MPAwNDNwMCwiOHLCd1zX07o6kBVGQEAKBANtobskNMAAAAASUVORK5CYII=");
}

.CodeMirror-lint-mark-error {
  background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAQAAAADCAYAAAC09K7GAAAAAXNSR0IArs4c6QAAAAZiS0dEAP8A/wD/oL2nkwAAAAlwSFlzAAALEwAACxMBAJqcGAAAAAd0SU1FB9sJDw4cOCW1/KIAAAAZdEVYdENvbW1lbnQAQ3JlYXRlZCB3aXRoIEdJTVBXgQ4XAAAAHElEQVQI12NggIL/DAz/GdA5/xkY/qPKMDAwAADLZwf5rvm+LQAAAABJRU5ErkJggg==");
}
.CodeMirror-search-match {
  background: gold;
  border-top: 1px solid orange;
  border-bottom: 1px solid orange;
  -moz-box-sizing: border-box;
  box-sizing: border-box;
  opacity: .5;
}
.CodeMirror-lint-marker {
  background-position: center center;
  background-repeat: no-repeat;
  cursor: pointer;
  display: inline-block;
  height: 16px;
  width: 16px;
  vertical-align: middle;
  width: 100%;
  background: white;
  position: relative;
}
.CodeMirror-lint-message {
  padding-left: 18px;
  background-position: top left;
  background-repeat: no-repeat;
}

.CodeMirror-lint-marker-warning {
  width: 10px;
  z-index:99999999999999999999999999999999999999;
  margin-left: 10px;
  height: 10px;
  margin-top: 5px;
  background: #fbc02d;
  border-radius: 99999px;
  cursor: pointer;
  transition: all .2s;
}
.CodeMirror-lint-tooltip
{
z-index: 9999;
width: auto;
}
.CodeMirror-lint-marker-error:hover {
    transform: scale(2) !important
}
.CodeMirror-lint-marker-warning:hover {
    transform: scale(2) !important
}
.CodeMirror-lint-marker {
    border: 10px solid transparent !important
}
.CodeMirror-lint-marker-error{
  width: 10px;
  z-index:99999999999999999999999999999999999999;
  margin-left: 10px;
  transition: all .2s;
  height: 10px;
  margin-top: 5px;
  background: #d32f2f;
  border-radius: 99999px;
  cursor: pointer;
}
.CodeMirror-lint-marker-multiple {
  background-repeat: no-repeat;
  background-position: right bottom;
  width: 100%; 
  border-radius: 9999px;
  height: 100%;
}
.CodeMirror-lint-marker-multiple::after {
}
</style>
<form method="POST" action="save.php" id="form">
  <div class="modal-content" style="padding: 0;padding-left: 315px;">
    <div class="sidebar">
      <a class="btn-floating btn-flat waves-effect waves-light btn-large" onclick="$('#save').click()">
        <i class="material-icons large">save</i>
      </a>
      <a class="btn-floating btn-flat waves-effect waves-light btn-large" onclick='dark();'>
        <i class="material-icons large">dark_mode</i>
      </a>
      <a class="btn-floating btn-flat waves-effect waves-light btn-large" onclick="$('#add_file').modal('open');$('#add_file').load('create.php?dir=<?php echo urlencode($_GET['dir']); ?>')">
        <i class="material-icons large">add</i>
      </a>
      <a class="btn-floating btn-flat waves-effect waves-light btn-large" href="https://www.youtube.com/watch?v=f02mOEt11OQ" target="_blank">
        <i class="material-icons large">music_note</i>
      </a>
      <a class="btn-floating btn-flat waves-effect waves-light btn-large" href="#">
        <i class="material-icons large">history</i>
      </a>
       <a class="btn-floating btn-flat waves-effect waves-light btn-large" href="#themes" onclick="document.getElementById('themes').style.display = 'block'">
        <i class="material-icons large">palette</i>
      </a>
      <a class="btn-floating btn-flat waves-effect waves-light btn-large modal-close">
        <i class="material-icons large">close</i>
      </a>
    </div>
    <div id="themes" style="display: none; position: fixed;top: 200px;left: 70px;background: white;z-index:99999999999999999999999999;padding: 20px 10px;border-radius: 5px;width: 400px;box-shadow: 0 2px 4px -1px rgba(0, 0, 0, 0.2), 0 4px 5px 0 rgba(0, 0, 0, 0.14), 0 1px 10px 0 rgba(0, 0, 0, 0.12);">
    <h5>Theme</h5>
       <select onchange='selectTheme()' id='select'><option selected disabled>Select theme...</option><option>material</option><option>tm</option><option>all-hallow-eve</option><option>amy</option><option>argonaut</option><option>arona</option><option>bbedit</option><option>bespin</option><option>birds-of-paradise</option><option>black-pearl-ii</option><option>black-pearl</option><option>blackboard-black</option><option>blackboard</option><option>bongzilla</option><option>chanfle</option><option>chrome-devtools</option><option>classic-modified</option><option>clouds-midnight</option><option>clouds</option><option>cobalt</option><option>coda</option><option>cssedit</option><option>cube2media</option><option>darkpastel</option><option>dawn</option><option>django-(smoothy)</option><option>django</option><option>eiffel</option><option>emacs-strict</option><option>espresso-libre</option><option>espresso-soda</option><option>espresso-tutti</option><option>espresso</option><option>fade-to-grey</option><option>fake</option><option>fantasyscript</option><option>fluidvision</option><option>freckle</option><option>friendship-bracelet</option><option>github</option><option>glitterbomb</option><option>happy-happy-joy-joy-2</option><option>idle</option><option>idlefingers</option><option>iplastic</option><option>ir_black</option><option>ir_white</option><option>johnny</option><option>juicy</option><option>krtheme</option><option>kuroir</option><option>lazy</option><option>lowlight</option><option>mac-classic</option><option>made-of-code</option><option>magicwb-(amiga)</option><option>merbivore-soft</option><option>merbivore</option><option>monoindustrial</option><option>monokai-bright</option><option>monokai-fannonedition</option><option>monokai-sublime</option><option>monokai</option><option>mreq</option><option>nightlion</option><option>notebook</option><option>oceanic-muted</option><option>oceanic</option><option>pastels-on-dark</option><option>pastie</option><option>plasticcodewrap</option><option>prospettiva</option><option>putty</option><option>rails-envy</option><option>railscasts</option><option>rdark</option><option>rhuk</option><option>ryan-light</option><option>sidewalkchalk</option><option>slush-&-poppies</option><option>smoothy</option><option>solarized-(dark)</option><option>solarized-(light)</option><option>spacecadet</option><option>spectacular</option><option>summer-sun</option><option>summerfruit</option><option>sunburst</option><option>swyphs-ii</option><option>tango</option><option>text-ex-machina</option><option>tomorrow-night-blue</option><option>tomorrow-night-bright</option><option>tomorrow-night-eighties</option><option>tomorrow-night</option><option>tomorrow</option><option>toulousse-lautrec</option><option>toy-chest</option><option>tubster</option><option>twilight</option><option>venom</option><option>vibrant-fin</option><option>vibrant-ink</option><option>vibrant-tango</option><option>zenburnesque</option></select>
        <button class="btn red darken-3" onclick="this.parentElement.style.display = 'none';return false;">Close</button>
    </div>
    <div class="files">
    <input type="text" placeholder="Search files in current directory..." style="color:white;padding: 0 10px;border: 0 !important;box-shadow: none !important;background: rgba(255, 255, 255, .1)" id="search_file">
    <div id="search_list">
    <?php
    $ftp_conn = ftp_connect($_SESSION['server']) or die("Could not connect to $ftp_server");
    $login = ftp_login($ftp_conn, $_SESSION['username'], $_SESSION['password']);
    $file_list = ftp_nlist($ftp_conn, dirname($dir));
    foreach($file_list as $file) {
        $path = $file;
        $image = pathinfo($path, PATHINFO_EXTENSION);
        switch($image) {
        case 'html': $filetype1 = $image; $valid_file_name = 1; $image = 'https://cdn.pixabay.com/photo/2017/08/05/11/16/logo-2582748_1280.png';  break;
        case 'css': $filetype1 = $image; $valid_file_name = 1; $image = 'https://cdn.pixabay.com/photo/2017/08/05/11/16/logo-2582747_1280.png';  break;
        case 'js':  $filetype1 = $image; $valid_file_name = 1; $image = 'https://upload.wikimedia.org/wikipedia/commons/6/6a/JavaScript-logo.png';  break;
        case 'png': $filetype1 = $image; $image = 'https://winaero.com/blog/wp-content/uploads/2019/11/Photos-new-icon.png';  break;
        case 'jpg': $filetype1 = $image; $image = 'https://winaero.com/blog/wp-content/uploads/2019/11/Photos-new-icon.png';  break;
        case 'txt': $filetype1 = $image; $valid_file_name = 1; $image = 'https://freeiconshop.com/wp-content/uploads/edd/txt-flat.png'; break;
        case 'c':   $filetype1 = $image; $valid_file_name = 1; $image = 'https://cdn.iconscout.com/icon/free/png-512/c-programming-569564.png'; break;
        case 'cpp': $filetype1 = $image; $valid_file_name = 1; $image = 'https://user-images.githubusercontent.com/42747200/46140125-da084900-c26d-11e8-8ea7-c45ae6306309.png'; break;
        case 'sql': $filetype1 = $image; $valid_file_name = 1; $image = 'https://www.logolynx.com/images/logolynx/c0/c0f84d9509d6690a70ce4c596f740c62.png'; break;
        case 'py':  $filetype1 = $image; $valid_file_name = 1; $image = 'https://cdn3.iconfinder.com/data/icons/logos-and-brands-adobe/512/267_Python-512.png'; break;
        case 'pdf': $filetype1 = $image; $valid_file_name = 1; $image = 'https://i.pinimg.com/originals/28/d1/61/28d1616c72589f9b4a633bb7dccfcfc3.png'; break;
        case 'php': $filetype1 = $image; $valid_file_name = 1; $image = 'https://brandslogos.com/wp-content/uploads/thumbs/php-logo-vector.svg'; break;
        case 'htaccess':    $filetype1 = $image; $valid_file_name = 1; $image = 'https://7-views.com/wp-content/uploads/2018/10/images_icons_products_products_apache_logo_v2-2.png'; break;
        default:    $filetype1 = $image; $valid_file_name = 0;  $image = 'https://www.iconbunny.com/icons/media/catalog/product/3/7/3783.9-file-icon-iconbunny.jpg'; break;
        }
        if($valid_file_name == 1) {
            echo '<div class="file"><a href="#" class="waves-effect waves-light" onclick=\'if(confirm("Open another file? Changes you made might not be saved. ") == true) {edit_file('.json_encode(dirname($dir)."/".basename($file)).', '.json_encode($filetype1).')}\'><img src="'.$image.'" width="24px" height="24px"> &nbsp;'. basename($file).'</a></div>
        
        ';
        }
    }
    ftp_close($ftp_conn);
    ?>
    </div>
    </div>
    <textarea id="code" name="file"><?php echo htmlspecialchars(file_get_contents('ftp://'.urlencode($_SESSION['username']). ":".urlencode($_SESSION['password'])."@".urlencode($_SESSION['server'])."/".$dir)); ?></textarea>
    <input type="hidden" name="dir" value="<?php echo $dir; ?>">
  </div>
  <div class="modal-footer" style="background:#2A2D32 !important;position:fixed;z-index:9999999">
    <span style="color: white;float: left;line-height: 45px"><?php echo $dir; ?></span><a onclick='if(confirm("Reload file? Changes you made might not be saved. ") == true) {edit_file("<?php echo $dir; ?>", <?php echo json_encode($_GET['filetype']);?>)}' href="#" style="transition: transform .2s;color: white;line-height: 57px;float:left;margin: 0 10px" id="refresh" class="refresh"><i class="material-icons">refresh</i></a>
    <a href="#" class="btn btn-flat waves-light modal-close waves-effect" onclick="document.getElementById('edit').innerHTML = '';">Close</a>
    <button id="save" href="#" class="btn waves-light btn-flat waves-effect"><i class="material-icons left">save</i> Save</button>
  </div>
</form>
<script>
  //   window.onkeydown = function(e) {
  //     if (e.ctrlKey && e.which == 83) {
  //       event.preventDefault();
  //       $('#save').click()
  //     } 
  //   };
  function selectTheme() {
      htmlEditor.setOption('theme', document.getElementById('select').value);
      localStorage.setItem('override-theme', document.getElementById('select').value);
  }
  function theme() {
      if(localStorage.getItem('override-theme')) {
          return localStorage.getItem('override-theme');
      }
      else {
        if(document.documentElement.getAttribute('data-theme') == "dark") {
            return 'material';
        }
        else {
            return "tm";
        }
      }
  }
  var htmlEditor = CodeMirror.fromTextArea(document.getElementById("code"), {
    lineNumbers: true,
    mode: '<?php echo $filetype; ?>',
    theme: theme(),
    styleActiveLine: true,
    lineNumbers: true,
    matchBrackets: true,
    autoCloseBrackets: true,
    autoCloseTags: true,
    gutters: ["CodeMirror-lint-markers"],
    lint: true,
    showMatchesOnScrollbar: true,
    scrollbarStyle: "overlay",
    extraKeys: {"Alt-F": "findPersistent"}
  });
  // this is the id of the form
  $("#form").submit(function(e) {
    document.getElementById('progress').style.display = 'block';
    e.preventDefault();
    var form = $(this);
    var url = form.attr('action');
    $.ajax({
      type: "POST",
      url: url,
      data: form.serialize(),
      success: function(data)
      {
        if(data == 'Success') {
          M.toast({html: "Successfully saved file"});
          document.getElementById('progress').style.display = 'none';
        }
        else {
          M.toast({html: data});
          document.getElementById('progress').style.display = 'none';
        }
        document.getElementById('progress').style.display = 'none';
      }
    });
  });
</script>
<script>
$(document).ready(function(){
  $("#search_file").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#search_list div").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
window.onbeforeunload = function() { return "Reload page?"; }
$(window).bind('keydown', 'ctrl+r', function(e) {
    e.preventDefault();
    document.getElementById('refresh').click();
});

  $(document).ready(function(){
    $('.dropdown-trigger').dropdown({
      // specify options here
    });
  });
    $('select').formSelect();
</script>