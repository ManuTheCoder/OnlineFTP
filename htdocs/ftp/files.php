<?php
session_start();
?>
<ul class="collection" id="files">
  <?php
  echo '<a href="#" onclick="ajax_load(\'./files.php?dir='.basename(urlencode($_GET['dir']."/".basename($files))).'\')">'. $_GET['dir']. "</a>";
  $path = $_GET['dir'];
  $conn_id = ftp_connect($_SESSION['server']);
  $login_result = ftp_login($conn_id, $_SESSION['username'], $_SESSION['password']);
  $contents = ftp_nlist($conn_id, $path);
  foreach($contents as $files) {
    $path = $files;
    $image = pathinfo($path, PATHINFO_EXTENSION);
    switch($image) {
      case 'html': $filetype = $image; $valid_file_name = 1; $image = 'https://cdn.pixabay.com/photo/2017/08/05/11/16/logo-2582748_1280.png';  break;
      case 'css': $filetype = $image; $valid_file_name = 1; $image = 'https://cdn.pixabay.com/photo/2017/08/05/11/16/logo-2582747_1280.png';  break;
      case 'js':  $filetype = $image; $valid_file_name = 1; $image = 'https://upload.wikimedia.org/wikipedia/commons/6/6a/JavaScript-logo.png';  break;
      case 'png': $filetype = $image; $image = 'https://winaero.com/blog/wp-content/uploads/2019/11/Photos-new-icon.png';  break;
      case 'jpg': $filetype = $image; $image = 'https://winaero.com/blog/wp-content/uploads/2019/11/Photos-new-icon.png';  break;
      case 'txt': $filetype = $image; $valid_file_name = 1; $image = 'https://freeiconshop.com/wp-content/uploads/edd/txt-flat.png'; break;
      case 'c':   $filetype = $image; $valid_file_name = 1; $image = 'https://cdn.iconscout.com/icon/free/png-512/c-programming-569564.png'; break;
      case 'cpp': $filetype = $image; $valid_file_name = 1; $image = 'https://user-images.githubusercontent.com/42747200/46140125-da084900-c26d-11e8-8ea7-c45ae6306309.png'; break;
      case 'py':  $filetype = $image; $valid_file_name = 1; $image = 'https://cdn3.iconfinder.com/data/icons/logos-and-brands-adobe/512/267_Python-512.png'; break;
      case 'sql':  $filetype = $image; $valid_file_name = 1; $image = 'https://www.logolynx.com/images/logolynx/c0/c0f84d9509d6690a70ce4c596f740c62.png'; break;
      case 'pdf': $filetype = $image; $valid_file_name = 1; $image = 'https://i.pinimg.com/originals/28/d1/61/28d1616c72589f9b4a633bb7dccfcfc3.png'; break;
      case 'php': $filetype = $image; $valid_file_name = 1; $image = 'https://www.pngfind.com/pngs/m/146-1466902_php-logo-png-transparent-php-logo-png-png.png'; break;
      case 'htaccess':    $filetype = $image; $valid_file_name = 1; $image = 'https://7-views.com/wp-content/uploads/2018/10/images_icons_products_products_apache_logo_v2-2.png'; break;
      default:    $filetype = $image; $valid_file_name = 0;  $image = 'https://www.iconbunny.com/icons/media/catalog/product/3/7/3783.9-file-icon-iconbunny.jpg'; break;
    }
    if($files == '..') {
      $file_name = urlencode(dirname($_GET['dir']));
    }
    else {
      $file_name = urlencode($_GET['dir']."/".basename($files));
    }
    echo '
    <li class="collection-item avatar">
        <img src="'.$image.'" class="circle">
        <div '.($valid_file_name !== 1 ? 'onclick="ajax_load(\'./files.php?dir='.basename($file_name).'\')" class="waves-effect"' : '').' style="width:100%;padding: 0 10px;border-radius: 5px">
            <h6><b>'. basename($files). '</b></h6>'.$_GET['dir'].'/'.basename($files).'
        </div>
        '.($valid_file_name == 1 ? '
        <div>
           <button class="btn btn-flat waves-effect btn-floating" onclick=\'edit_file('.json_encode($_GET['dir']."/".basename($files)).', '.json_encode($filetype).')\'><i class="material-icons">edit</i></button>
           <button class="btn btn-flat waves-effect btn-floating" onclick=\'delete_file('.json_encode($_GET['dir']."/".basename($files)).', this.parentElement.parentElement)\'><i class="material-icons">delete</i></button>
           <button class="btn btn-flat waves-effect btn-floating" onclick=\'rename_file('.json_encode($_GET['dir']."/".basename($files)).')\'><i class="material-icons">drive_file_rename_outline</i></button>
           <button class="btn btn-flat waves-effect btn-floating" onclick=\'windowOpen('.json_encode($_GET['dir']."/".basename($files)).')\'><i class="material-icons">open_in_new</i></button>
        </div> ' : 
           '
        <div>
           <button class="btn btn-flat waves-effect btn-floating" onclick=\'delete_file('.json_encode($_GET['dir']."/".basename($files)).', this.parentElement.parentElement, 2)\'><i class="material-icons">delete</i></button>
        </div>
        ').'
    </li>'
      ."\n";
  }
  ?>
</ul>        
<div class="fixed-action-btn">
  <a class="btn-floating btn-large blue-grey darken-3 modal-trigger" href="#add_file" onclick="$('#add_file').load('create.php?dir=<?php echo urlencode($_GET['dir']); ?>')">
    <i class="material-icons">add</i>
  </a>
</div>