<div class="modal-content">
  <h4 style="color: white">Create file</h4>
  <form id="create" method="POST" action="add.php">
    <div class='input-field'>
      <label>File Name</label>
      <input type="text" name="file_name" style="color: white" autocomplete="off">
    </div>
    <input type="hidden" name="dir" value="<?php echo $_GET['dir']; ?>">
    <label>
      <input type="checkbox" name="folder">
      <span>Folder?</span>
    </label>
  </form>
</div>
<div class="modal-footer">
  <a class='modal-close btn btn-flat' href="#">Close</a>
</div>
<script>
  // this is the id of the form
  $("#create").submit(function(e) {
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
          ajax_load('files.php?dir=<?php echo urlencode($_GET['dir']);?>');
          $('.modal').modal('close')
        }
        else {
          M.toast({html: data})
        }
      }
    });
  });
</script>