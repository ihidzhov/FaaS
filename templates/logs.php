<?php include_once("header.php"); ?>

<h3>logs</h3>

<div>
  <h5>Functions</h5>
  <table id="example" class="table caption-top">
    <thead>
      <tr>
        <th scope="col">Level</th>
        <th scope="col">Name</th>
        <th scope="col">Message</th>
        <th scope="col">Date</th>
      </tr>
    </thead>
      <tbody>
        <?php foreach($lambda_logs as $value) { ?>
          <tr>
            <td>
            <?php echo $value["level_name"]; ?>
            </td>
            <td><?php echo $value["name"]; ?></td>
            <td><?php echo $value["message"]; ?></td>
            <td><?php echo $value["created_at"]; ?></td>
          </tr>
        <?php } ?>
      </tbody>
  </table>
</div>

<?php include_once("footer.php"); ?>