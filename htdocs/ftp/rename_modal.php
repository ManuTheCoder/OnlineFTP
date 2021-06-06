<div class="modal-content" style="background:white;color:black">
  <h4>
    Rename file
  </h4>
  <form id="rname" method="POST" action="rename.php">
    <div class="input-field">
      <label>New file name</label>
      <input type="text" autocomplete="off" name="name" autofocus value="<?php echo $_GET['file'];?>">
    </div>
    <input type="text" autocomplete="off" name="dir" value="<?php echo $_GET['file'];?>">
  </form>
</div>
<div class="modal-footer" style="background:white;color:black">
  <a href="#" class="btn btn-flat waves-effect" onclick="$('#rname').submit()">Rename</a>
  <a href="#" class="btn btn-flat waves-effect modal-close">Cancel</a>
</div>
<script>
  $("#rname").submit(function(e) {
    e.preventDefault(); 
    var form = $(this);
    var url = form.attr('action');
    $.ajax({
      type: "POST",
      url: url,
      data: form.serialize(),  
      success: function(data)
      {
        ajax_load('files.php?dir=<?php echo urlencode(dirname($_GET['file']));?>');
        $('.modal').modal('close')
      }
    });
  });
</script>