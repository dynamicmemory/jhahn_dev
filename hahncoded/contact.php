<?php
$contact_info = ["Phone Number: -",
                        "Email: -",
                        "Github: dynamicmemory"
                 ];
?>

<?php include "header.php" ?>
<div class="main-container" id="contact-container">
    <div class="left-col" id="contact-left-col">
    </div>
    <div class="center-col" id="contact-center-col">
        <p>Contact info</p>
        <ul>
            <?php foreach($contact_info as $contact): ?>
                <li><?= $contact ?></li>
            <?php endforeach; ?>
       </ul> 
    </div>
</div>
<?php include "footer.php" ?>
