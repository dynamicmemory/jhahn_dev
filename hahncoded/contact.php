<?php
include "./includes/functions.php";

?>

<?php include "header.php" ?>
<div class="main-container" id="contact-container">
    <div class="left-col" id="contact-left-col">
    </div>
    <div class="center-col" id="contact-center-col">
        <p>Contact info</p>
            <ul> 
            <li><a href="<?= htmlspecialchars(getSetting('contact_email')) ?>">Email</a></li>
            <li><a href="<?= htmlspecialchars(getSetting('contact_github')) ?>">Github</a></li>
            </ul>
    </div>
</div>
<?php include "footer.php" ?>
