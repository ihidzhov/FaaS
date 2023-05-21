<?php include_once("header.php"); ?>
<style>
  #editor {
    width: 100%;
    height: 420px;
}
</style>

<div class="wrapper">
  <h3>Function</h3>
  
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

<script src="./assets/ace-builds-1.5-2.0/src/ace.js" type="text/javascript" charset="utf-8"></script>
<script>
    var editor = ace.edit("editor");
</script>
<script src="./assets/ace-builds-1.5-2.0/src/theme-chrome.js" type="text/javascript" charset="utf-8"></script>
<script>
  editor.setTheme("ace/theme/chrome");
</script>
<script src="./assets/ace-builds-1.5-2.0/src/mode-php.js" type="text/javascript" charset="utf-8"></script>
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
