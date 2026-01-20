<?php 
?>
    <footer> 
        <p><?=getSetting("footer")?> ~ <?=date("Y")?>.
        
        
        <div id="contact-info">
          <a id="github" 
             href="<?= getSetting("contact_github") ?>" 
             target="_blank"
             rel="noopener">github
          </a> 
          | 
          <a id="email" 
             href="mailto:<?= getSetting("contact_email") ?>" 
             target="_blank"
             rel="noopener">email
          </a>
        </div>
        
        
        </p>
    </footer>
  </body>
</html>


