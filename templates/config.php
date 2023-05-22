<?php include_once("header.php"); ?>
<style>
  #editor {
    width: 100%;
    height: 420px;
}
</style>

<div class="wrapper">
  <h3>Config</h3>

  <div class="row">
    <div class="col-sm-12 text-right">
      <button type="button" class="btn btn-outline-primary" onclick="FaaS.updateConfig(this);">Save</button>
    </div>
  </div>
 
  <div class="padding-12">
    <label class="form-check-label" for="flexSwitchCheckChecked">Config - JSON format</label>
  </div>

<div id="editor">{
  "db":{
    "host": "localhost",
    "port": 3306,
    "user": "user",
    "password": "password"
  }
  
}
</div>
   
<script>
 
  /*
  cobalt
  eclipse
monokai
solarized_dark
  
  */
</script>

<script src="./assets/ace-builds-1.5-2.0/src/ace.js" type="text/javascript" charset="utf-8"></script>
<script>
    var editor = ace.edit("editor");
</script>
<script src="./assets/ace-builds-1.5-2.0/src/theme-xcode.js" type="text/javascript" charset="utf-8"></script>
<script>
  editor.setTheme("ace/theme/xcode");
</script>
<script src="./assets/ace-builds-1.5-2.0/src/mode-json.js" type="text/javascript" charset="utf-8"></script>
<script>
  var JSONMode = ace.require("ace/mode/json").Mode;
  editor.session.setMode(new JSONMode());
</script>
<script>
  window.addEventListener("DOMContentLoaded", (event) => {
    FaaS.getConfigCodeSnippet();
  });
</script>
<?php include_once("footer.php"); ?>
