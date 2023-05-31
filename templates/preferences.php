<?php include_once("header.php"); ?>

<div class="row">

  <div class="col-3">  </div>
  <div class="col-6">  
    <form>
       
      <div>Site Theme</div>

      <br />
      <?php foreach($preferences["site_theme"] as $theme): ?>
      <div class="form-check">
        <input 
          class="form-check-input" 
          type="radio" 
          name="site-theme" 
          id="site-theme<?php echo $theme["id"]; ?>" 
          value="<?php echo $theme["id"]; ?>"
          <?php if (isset($theme["selected"])) {echo "checked";} ?>
        >
        <label class="form-check-label" for="site-theme<?php echo $theme["id"]; ?>">
          <?php echo $theme["name"]; ?>
        </label>
      </div>
      <?php endforeach; ?>
 
      <br /><br />
      <button onclick="FaaS.updateUserPreferences()" type="button" class="btn btn-primary">Submit</button>
    </form>
  </div>
  <div class="col-3">  </div>

</div>
<?php include_once("footer.php"); ?>