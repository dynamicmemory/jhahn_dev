<?php
// TODO: Change how the db is named EVERYWHERE including the actual db 
// TODO: Change description key to content or md EVERYWHERE
?>

<h1>Projects DB editor</h1>
<!-- Main container -->
<div style="display: flex; gap: 2rem;"> 

  <!-- Left col -->
  <div style="min-width: 200px;"> 
    <h3>Projects</h3>
    <ul> 
    <?php #while ($p = $projects->fetchArray(SQLITE3_ASSOC)) : ?>
      <li>
        <a >Empty for now</a>  <!-- href="?id=<?= $p["id"] ?>">-->
      </li>
      <li>
        <a >Empty for now</a> 
      </li>
    <?php #endwhile ?> 
    </ul>
  </div>

  <!-- Center col-->
  <div style="flex: 1;">
  <?php # if ($selected_project): ?>
    <h3>Editing: <?= htmlspecialchars($selected_project["title"]) ?></h3> 

    <form method="POST"> 
      <fieldset> 
        <input type="hidden" name="id" value="<?= $selected_project["id"]?>">

        <label>Name: </label><br>
        <input name="name" value="<?= htmlspecialchars($selected_project["name"]) ?>"
               style="width: 100%"><br><br>

        <label>URL-Slug: </label><br>
        <input name="slug" value="<?= htmlspecialchars($selected_project["slug"]) ?>"
               style="width: 100%"><br><br>

        <label>Content (Markdown body): </label><br>
        <textarea name="description" rows="30" style="width: 100%;">
          <?= htmlspecialchars($selected_project["description"]) ?>
        </textarea><br><br>

        <!-- ADD JSON MEDIA OBJECTS IF I CHOOSE TO IMPLEMENT HERE-->
        <button type="submit">Save</button>

      </fieldset> 


    </form>

  <?php #else: ?>
    <p>Select a project from the left to edit.</>
  <?php #endif; ?>
  </div>
</div>
