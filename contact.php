<?php
$contact_info = ["Phone Number: That seems like a bad idea to put here.",
                        "Email: That also seems a little sketchy.",
                        "Github: Yeah that seems fine to add here."
];
?>

<?php include "header.php" ?>
<div id="contact-container">
    <div id="center-container">
        <p>Contact info</p>
        <ul>
            <?php foreach($contact_info as $contact): ?>
                <li>- <?= $contact ?></li>
            <?php endforeach; ?>
       </ul> 
    </div>
</div>
<?php include "footer.php" ?>
