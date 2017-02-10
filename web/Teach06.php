<?php
  error_reporting(E_ALL);
  ini_set("display_errors", 1);

  // Database connection
  $connStr = getenv("DATABASE_URL");
  // If there is no database connection string from the "getenv" method then I am running on my local development machine
  if(empty($connStr)) {
    $connStr = "postgres://cs313:P@ssword123@localhost:5432/cs313Dev";
  }
  $url = parse_url($connStr);
  $dbopts = $url;
  try {
    // Create the PDO connection
    $database = new PDO("pgsql:host=" . $dbopts['host'] . "; dbname=" . str_replace('/', '', $dbopts['path']),  $dbopts['user'], $dbopts['pass']);
  }
  catch (PDOException $ex) {
    // If this were in production, you would not want to echo
    // the details of the exception.
    echo "Error connecting to DB. Details: $ex";
    die();
  }
  $db = $database;
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	// get all topics
  $sql_topics = $db->prepare("SELECT * FROM topic");
  $sql_topics->execute();
  $topics = $sql_topics->fetchAll();


  $database = null;
?>

<!DOCTYPE html>
<html>
<head>
  <title>Search the scriptures!</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <script>
    $(function() { // on page load
      
      loadScriptures();// load scriptures
      
      // add click event to form submit button
      $('#submitButton').on('click', function(e) {
        e.preventDefault(); // prevent submission of form
        
        var form = $('#form'); // get form

        // JQeury Ajax post to submitScripture.php
        // the .serialize() function creates a post string from the data in the form.
        $.post('submitScripture.php', form.serialize())
        .always(function(data) { // always runs at the end of the ajax, regardless of status
          console.log(data); // display result to console
          loadScriptures(); // reload the scriptures
        });
      });
    });
    
    // load scriptures function
    var loadScriptures = function() {
      // JQuery ajax GET from getScriptures.php
      $.get('getScriptures.php').always(
        function(data) { 
          $('#results').html(data); // Set the resulting string as the html content of the #results element
      });
    };
  </script>
</head>
<body>
    <form id="form" action="" method="post">
      <label for="book">Book Name:</label>
      <input type="text" name="book" id="book" placeholder="Book Name">
      <br>
      <label for="chapter">Chapter:</label>
      <input type="text" name="chapter" id="chapter" placeholder="Chapter #">
      <br>
      <label for="verse">Verse:</label>
      <input type="text" name="verse" id="verse" placeholder="Verse #">
      <br>
      <label for="content">Content:</label>
      <textarea name="content" id="content" placeholder="Please enter the content of the scripture here"></textarea>
      <br>
      <?php
        foreach($topics as $top) {
          echo "<input name='topics[]' type='checkbox' value='" . $top['id'] . "'>" . $top['name'];
          echo "<br>";
        }
      ?>
      <br>
      <input type="checkbox" name="new"> - <input type="text" name="newTopic" placeholder="New Topic">
      <br>
      <button type="button" id="submitButton">Submit</button>
    </form>
  
    <hr>
  
    <div id="results" ></div>
  </body>
</html>
