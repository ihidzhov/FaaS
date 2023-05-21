
<div class="row">
  <div class="col-sm-6">
    <div class="padding-12">
      <label class="form-check-label" for="flexSwitchCheckChecked">
        <span class="badge rounded-pill bg-info no-radius">Trigger</span>
      </label>
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
</div> 

<div class="clear"></div>

<div class="padding-12">
  <div id="trigger-http" class="trigger-radio <?php if ($id && is_array($fn) && isset($fn["trigger_type"]) && $fn["trigger_type"] == $triggers['http']) { echo "show";} ?>" >
  <?php if ($id) : ?>  
    URL: <a target="_blank" href="<?php echo $host . "lambda.php?name=" . $fn["hash"]; ?>"><?php echo $host; ?>lambda.php?name=<?php echo $fn["hash"]; ?></a>
  <?php endif; ?>
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
