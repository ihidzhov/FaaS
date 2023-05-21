<?php include_once("header.php"); ?>


<h2>Functions</h2>

<br />
 
<p>
  <a href="index.php?action=func" class="text-decoration-none">
    <svg xmlns="http://www.w3.org/2000/svg" style="margin-top:-2px" width="16" height="16" fill="currentColor" class="bi bi-plus-circle" viewBox="0 0 16 16">
      <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
      <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4z"/>
    </svg>  
    Create new Function
  </a>
</p>
https://examples.bootstrap-table.com/#options/table-ajax.html#view-source
<table
  id="table"
  data-toggle="table"
  data-height="460"
  data-ajax="ajaxRequest"
  data-search="true"
  data-side-pagination="server"
  data-pagination="true">
  <thead>
    <tr>
      <th scope="col" data-field="id">ID</th>
      <th scope="col" data-field="name">Name</th>
      <th scope="col" data-field="id">Trigger</th>
      <th scope="col" data-field="id">Created At</th>
      <th scope="col" class="text-center" data-field="id">Actions</th>
    </tr>
  </thead>
</table>

<script>
  // your custom ajax request here
  function ajaxRequest(params) {
    console.log(params)
    FaaS.getList(params);
    // $.get(url + '?' + $.param(params.data)).then(function (res) {
    //   params.success(res)
    // })
  }
</script>

<div class="container"  >
  <table id="example" class="table caption-top">
      <thead>
          <tr>
              <th scope="col">ID</th>
              <th scope="col">Name</th>
              <th scope="col">Trigger</th>
              <th scope="col">Created At</th>
              <th scope="col" class="text-center">Actions</th>
          </tr>
      </thead>
      <tbody>
        <?php foreach($data as $value) { ?>
          <tr>
            <td><?php echo $value["id"]; ?></td>
            <td>
              <a href="index.php?action=func&id=<?php echo $value["id"]; ?>">
                <?php echo $value["name"]; ?>
              </a>
            </td>
            <td><?php echo $value["trigger"]; ?></td>
            <td><?php echo $value["created_at"]; ?></td>
            <td class="text-center">
              <a href="index.php?action=func&id=<?php echo $value["id"]; ?>" title="Edit">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                  <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                </svg>
              </a>
            </td>
          </tr>
        <?php } ?>
      </tbody>
  </table>
</div>
 
 
<?php include_once("footer.php"); ?>