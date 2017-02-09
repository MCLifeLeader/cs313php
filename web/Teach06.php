<?php
  error_reporting(E_ALL);
  ini_set("display_errors", 1);

  // Database connection
  $connStr = getenv("DATABASE_URL");
  // If there is no database connection string from the "getenv" method then I am running on my local development machine
  if(empty($connStr)) {
    $connStr = "postgres://cs313:P@ssword123@localhost:5432/cs313Dev";
    //$connStr = "postgres://qvtwllccjytdzv:161e59a883efbf5c828d87bb2e516e1280b9271a4459dbe723ecc90db3538c88@ec2-54-235-92-236.compute-1.amazonaws.com:5432/d2ok4dig0dekbv";
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

  $sql_topics = $db->prepare("SELECT * FROM topic");
  $sql_topics->execute();
  $topics = $sql_topics->fetchAll();

  $database = null;
?>

<!DOCTYPE html>
<html>
<head>
  <title>Search the scriptures!</title>
  
  <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css" />
  <link rel="stylesheet" href="content/main.css" />

  <script src="scripts/jquery-3.1.1.min.js"></script>
  <script src="bootstrap/js/bootstrap.min.js"></script>
  <script src="scripts/main.js"></script>
  
  <script>
    $(function() {
      loadScriptures();
      
      $('#submitButton').on('click', function(e) {
        e.preventDefault();
        var form = $('#form');

        $.post('submitScripture.php', form.serialize())
        .always(function(data) {
          console.log(data); // 'This is the returned text.'
          loadScriptures();
        });
      });
    });
    
    var loadScriptures = function() {
      $.get('getScriptures.php').always(
        function(data) { 
          $('#results').html(data); 
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

