<?php include_once("header.php"); ?>
 
<div>
  <br /> <br /> <br />
  <h5>Functions executions</h5>

  <table
    id="table"
    data-toggle="table"
    data-height="460"
    data-ajax="ajaxRequest"
    data-search="true"
    data-pagination="true"
    data-side-pagination="server"
    data-pagination="true"
    >
    <thead>
      <tr>
        <th scope="col" data-field="level_name">Level</th>
        <th scope="col" data-field="name">Name</th>
        <th scope="col" data-field="message">Message</th>
        <th scope="col" data-field="created_at">Date</th>
      </tr>
    </thead>
  </table>
</div>
 
<script>
  // your custom ajax request here
  function ajaxRequest(params) {
    FaaS.getLogs(params);
  }
</script>

<?php include_once("footer.php"); ?>