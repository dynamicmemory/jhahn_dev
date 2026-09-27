<?php 
?>
      <footer class="footer"> 

        <p><?=getSetting("footer")?> ~ <?=date("Y")?>.</p>

        <p>
          <a id="github" href="<?= getSetting("contact_github") ?>" target="_blank"
            aria-label="GitHub" rel="noopener">Github
          </a>
          |
          <a href="mailto:<?= getSetting("contact_email") ?>">
            Email
          </a>
        </p>

      </footer>
    </div>
  </body>
</html>
