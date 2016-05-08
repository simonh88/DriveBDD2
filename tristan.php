<?php

require_once('common.php');

?><!--//INSERT INTO "SSR_P" VALUES('34955558424589742580', 'Provence'); -->

<form action="tristan.php" method="post">
<input type="text" class="form-control"  name="table[1]">
<input type="text" class="form-control"  name="tables[table][1]">

<button type="submit">PO</button>
</form>

<?php 
var_dump($_POST);

?>