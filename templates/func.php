<?php include_once("header.php"); ?>
<style>
  #editor {
    width: 100%;
    height: 420px;
}
</style>

<div class="wrapper">
  <h4>Function -  <?php if ($id) : ?> Edit <?php else: ?> Create <?php endif; ?></h4>
  <br />
  <?php include_once("parts/func_trigger.php"); ?>

  <br />

  <div class="row">
    <div class="col-sm-6">
      <div class="input-group input-group-sm mb-3">
        <span class="input-group-text" id="inputGroup-sizing-sm">Function name</span>
        <input 
          type="text" 
          class="form-control" 
          aria-label="Sizing example input" 
          aria-describedby="inputGroup-sizing-sm"
          name="function-name" 
          id="function-name" 
          <?php if ($id && isset($fn["name"])) : ?>
          value="<?php echo $fn["name"]; ?>"
          readonly
          <?php endif; ?>
        >
      </div>
    </div>

    <div class="col-sm-6 text-right">
      <?php if ($id) : ?>
      <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" >Delete</button>
      <?php endif; ?>
      <button type="button" class="btn btn-outline-primary" onclick="FaaS.save(this);">Save</button>
    </div>

  </div>
 
  <div class="padding-12">
    <label class="form-check-label" for="flexSwitchCheckChecked">Editor - function snippet</label>
  </div>

  <div id="editor"></div>
  
</div>

<!-- Modal Delete Function -->
<?php include_once("parts/func_delete_modal.php"); ?>

<script>
  var functionID = null;
  <?php if ((int)$id > 0) {
    echo "functionID = " . $id;
  } ?>

</script>

<script 
  src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.19.0/ace.min.js" 
  charset="utf-8"
></script>

<script>
    var editor = ace.edit("editor");
</script>
 
<script 
  src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.19.0/theme-<?php echo $editorTheme; ?>.min.js" 
  charset="utf-8"
></script>

<script>
  editor.setTheme("ace/theme/<?php echo $editorTheme; ?>");
</script>
<script 
  src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.9.6/mode-php.min.js" 
  charset="utf-8"
></script>
<script>
  var PHPMode = ace.require("ace/mode/php").Mode;
  editor.session.setMode(new PHPMode());
</script>
<script>
  window.addEventListener("DOMContentLoaded", (event) => {
    if (functionID) {
      FaaS.getCodeSnippet(functionID);
    }
  });
</script>
<?php include_once("footer.php"); ?>
