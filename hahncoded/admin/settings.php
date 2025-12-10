<?php
require_once "auth.php";
require "../../website_data/database.php";

// Sending a new/updating a record in the settings table
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $key = $_POST["key"];
    $value = $_POST["value"];
    $type = $_POST["type"];
    $tag = $_POST["tag"];

    // Create a new setting 
    if ($_POST["mode"] === "create") {
        $statement = $database->prepare("INSERT OR IGNORE settings 
            WHERE (key, value, type, tag) 
            VALUES (?, ?, ?, ?)");
        $statement->bindValue(1, $key, SQLITE3_TEXT);
        $statement->bindValue(2, $value, SQLITE3_TEXT);
        $statement->bindValue(3, $type, SQLITE3_TEXT);
        $statement->bindValue(4, $tag, SQLITE3_TEXT);
        $statement->execute();
        echo "<p>Successfully added $key to the settings table</p>";
    }

    // Update an exisiting setting 
    if ($_POST["mode"] === "update") {
        /* $id = $_ */


        echo "<p>Successfully updated $key</p>";
    }
}

// All the get stuff and populating the fields
// TODO: Get id from db, then i can do update above, then i can add and update
//       settings, then i can build the function to serve up the data, then i 
//       can place a call in home to load up the <p> to test it out.

?>
<!-- Make a new header for the admin panel so i can load css scripts and the like-->
<html> 
    <head> 
        <link rel="stylesheet" type="text/css" href="/css/admin.css">
    </head>



<h1>Settings</h1> 
<a href="index.php">Dashboard</a>

<!-- Main container-->
  <div class="main-container">

<!-- Side panel-->
    <div class="side-panel">

    </div>
<!-- Center panel-->
    <div class="center-panel">

      <form method="POST">
        <fieldset> 
          <label>Key</label>
          <input name="key"> </input>
          <label>Value</label>
          <textarea name="value"> </textarea>
          <label>Type</label>
          <input name="type"> </input>
          <label>Tag</label>
          <input name="tag"> </input>
          <button type="submit">SUMBIT</button>


        </fieldset>
      </form>

    </div>
  </div>
</html>
<!-- -->
