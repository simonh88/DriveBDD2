<link rel="stylesheet" href="lib/bootstrap/css/bootstrap.css" />
<link rel="stylesheet" href="lib/css/drive.css" />
<link rel="stylesheet" href="lib/css/ddhover.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script src="lib/bootstrap/js/bootstrap.js"></script>

<form class="form-inline" action="tristan.php" method="post" id="test">
  <div class="form-group">
    <label for="exampleInputName2">Name</label>
    <input type="hidden" name="reference" value="123">
  </div>
  <div class="form-group">
    <label for="exampleInputEmail2">Quantite</label>
    <input type="number" name="qte" class="form-control" >
  </div>
  <button type="submit" class="btn btn-default" form="test">Send invitation</button>
</form>

<?php
var_dump($_POST); ?>

<!--//INSERT INTO "SSR_P" VALUES('34955558424589742580', 'Provence'); -->