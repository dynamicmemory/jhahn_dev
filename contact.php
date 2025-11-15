<?php
$PAGE = 3;

$contact_info = ["Phone Number: That seems like a bad idea to put here.",
                        "Email: That also seems a little sketchy.",
                        "Github: Yeah that seems fine to add here."
];
?>

<?php include "header.php" ?>
<main id="page-content">
<div class="main-container" id="contact-container">
    <div class="left-col" id="contact-left-col">
    </div>
    <div class="center-col" id="contact-center-col">
        <p>Contact info</p>
        <ul>
            <?php foreach($contact_info as $contact): ?>
                <li>- <?= $contact ?></li>
            <?php endforeach; ?>
       </ul> 
    </div>
</div>
</main>
<?php include "footer.php" ?>
