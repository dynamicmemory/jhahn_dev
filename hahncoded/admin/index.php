<?php 
// Simplify this security flow into a util function or header or something, I use it everywhere
require_once "auth.php";
require "../../website_data/database.php";
require_once "../includes/csrf.php";
csrf_verify();

?>

<?php include "header.php" ?>

<main>
  <div class="center-panel" style="text-align: center;"> 
    <p>Dashboard under construction, will include: site metrics, last edited, etc</p>
  </div>
</main>

<?php include "footer.php" ?>
