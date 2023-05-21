<?php include_once("header.php"); ?>

<h3>Dashboard</h3>

<br />


<div class="row"> 

  <div class="card" style="width: 18rem; margin-right: 12px;"> 
    <div class="card-body">
      <h4 class="card-title text-center"><?php echo $count; ?></h4>
      <p class="card-text text-center">Number of all functions</p>
      <div class="text-center">
        <a href="index.php?action=funcs" class="btn btn-primary">Go to functions</a>
      </div>
    </div>
  </div>
  <div class="card" style="width: 18rem; margin-right: 12px;"> 
    <div class="card-body">
      <h4 class="card-title text-center"><?php echo $php_count; ?></h4>
      <p class="card-text text-center">Number of all PHP functions</p>
      <h4 class="text-center">PHP</h4>
    </div>
  </div>
  <div class="card" style="width: 18rem;"> 
    <div class="card-body">
      <h4 class="card-title text-center"><?php echo $node_count; ?></h4>
      <p class="card-text text-center">Number of all functions</p>
      <h4 class="text-center">NODE</h4>
    </div>
  </div>

</div>

<br /> 
<br />
<br />
<div>
  <h5>Latest Functions</h5>
  <table id="example" class="table caption-top">
    <thead>
      <tr>
        <th scope="col">Name</th>
        <th scope="col">Trigger</th>
        <th scope="col">Created At</th>
      </tr>
    </thead>
      <tbody>
        <?php foreach($latest as $value) { ?>
          <tr>
            <td>
              <a href="index.php?action=func&id=<?php echo $value["id"]; ?>">
                <?php echo $value["name"]; ?>
              </a>
            </td>
            <td><?php echo $value["trigger"]; ?></td>
            <td><?php echo $value["created_at"]; ?></td>
          </tr>
        <?php } ?>
      </tbody>
  </table>
</div>

<br />
<div>
  <h5>Latest Executed Functions</h5>
  <table id="example" class="table caption-top">
    <thead>
      <tr>
        <th scope="col">Level</th>
        <th scope="col">Name</th>
        <th scope="col">Date</th>
      </tr>
    </thead>
      <tbody>
        <?php foreach($last_executed_functions as $value) { ?>
          <tr>
            <td><?php echo $value["level_name"]; ?></td>
            <td><?php echo $value["name"]; ?></td>
            <td><?php echo $value["created_at"]; ?></td>
          </tr>
        <?php } ?>
      </tbody>
  </table>
</div>


<?php include_once("footer.php"); ?>