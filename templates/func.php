<?php include_once("header.php"); ?>
<style>
  #editor {
    width: 100%;
    height: 420px;
}
</style>

<div class="wrapper">
  <h3>Function</h3>
 
  <div>
    <div class="padding-12">
      <label class="form-check-label" for="flexSwitchCheckChecked">Triggers</label>
    </div>
    <div class="form-check form-check-inline">
      <input 
        class="form-check-input" 
        type="radio" 
        name="trigger" 
        id="inlineRadio1" 
        value="<?php echo $triggers['http'];?>"
        <?php if (!$id) : ?>
          checked
        <?php elseif($fn["trigger_type"] == $triggers['http']) : ?>
          checked
        <?php endif; ?>
        onchange="FaaS.triggers.onChange(<?php echo $triggers['http']; ?>)"
      >
      <label class="form-check-label" for="inlineRadio1">HTTP(S)</label>
    </div>
    <div class="form-check form-check-inline">
      <input 
        class="form-check-input" 
        type="radio" 
        name="trigger" 
        id="inlineRadio2" 
        value="<?php echo $triggers['time'];?>"
        <?php if (isset($fn["trigger_type"]) && $fn["trigger_type"] == $triggers['time']) : ?>
          checked
        <?php endif; ?>
        onchange="FaaS.triggers.onChange(<?php echo $triggers['time']; ?>)"
      >
      <label class="form-check-label" for="inlineRadio2">Time</label>
    </div>
  </div>
  <div class="clear"></div>
  <div class="padding-12">
    <div id="trigger-http" class="trigger-radio <?php if ($id && isset($fn["trigger_type"]) && $fn["trigger_type"] == $triggers['http']) { echo "show";} ?>" >
      URL: <a target="_blank" href="<?php echo $host . "lambda.php?name=" . $fn["hash"]; ?>"><?php echo $host; ?>lambda.php?name=<?php echo $fn["hash"]; ?></a>
    </div>
    <div id="trigger-time" class="trigger-radio <?php if ($id && isset($fn["trigger_type"]) && $fn["trigger_type"] == $triggers['time']) { echo "show";} ?>" >
      <div class="input-group input-group-sm mb-3">
        <span class="input-group-text" id="inputGroup-sizing-sm">Crontab</span>
        <input 
          type="text" 
          class="form-control" 
          aria-label="Sizing example input" 
          aria-describedby="inputGroup-sizing-sm"
          id="trigger-details" 
          placeholder="* * * * *"
          <?php if ($id && isset($fn["trigger_details"])) { ?>
          value="<?php echo $fn["trigger_details"]; ?>"
          <?php } ?>
        >
      </div>
    </div>
  </div>
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
          <?php if ($id && isset($fn["name"])) { ?>
          value="<?php echo $fn["name"]; ?>"
          readonly
          <?php } ?>
        >
      </div>
    </div>
    <div class="col-sm-6 text-right">
    <button type="button" class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#deleteModal" >Delete</button>
      <button type="button" class="btn btn-outline-primary" onclick="FaaS.save(this);">Save</button>
    </div>
  </div>
 
  <!-- <div class="btn-group" role="group" aria-label="Basic outlined example">
    <?php if ($id && isset($fn["name"])) { ?>
     <button type="button" class="btn btn-outline-primary"><?php echo $fn["name"]; ?></button>
     <button type="button" class="btn btn-outline-primary">composer.json</button>
    <?php } ?>
  </div> -->
  <div class="padding-12">
    <label class="form-check-label" for="flexSwitchCheckChecked">Editor - function snippet</label>
  </div>
  <div id="editor"></div>
</div>

 

<!-- Modal Delete Function -->
<div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModal" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Delete Function</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        Do you want to delete this Function?
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button type="button" class="btn btn-outline-danger" onclick="FaaS.delete(this);">Delete</button>
      </div>
    </div>
  </div>
</div>

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
    // get the function content
      FaaS.getCodeSnippet(functionID);
    }
  });
</script>
<?php include_once("footer.php"); ?>
