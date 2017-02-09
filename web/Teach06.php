<?php
  error_reporting(E_ALL);
  ini_set("display_errors", 1);
  $scripture = "";
  $isContent = false;

  // Database connection
  $connStr = getenv("DATABASE_URL");
  // If there is no database connection string from the "getenv" method then I am running on my local development machine
  if(empty($connStr)) {
    //$connStr = "postgres://cs313:P@ssword123@localhost:5432/cs313Dev";
    $connStr = "postgres://qvtwllccjytdzv:161e59a883efbf5c828d87bb2e516e1280b9271a4459dbe723ecc90db3538c88@ec2-54-235-92-236.compute-1.amazonaws.com:5432/d2ok4dig0dekbv";
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

  /*
  // Database connection
  $url = parse_url("postgres://qvtwllccjytdzv:161e59a883efbf5c828d87bb2e516e1280b9271a4459dbe723ecc90db3538c88@ec2-54-235-92-236.compute-1.amazonaws.com:5432/d2ok4dig0dekbv");
  $dbopts = $url;
  $database = new PDO("pgsql:host=" . $dbopts['host'] . "; dbname=" . str_replace('/', '', $dbopts['path']),  $dbopts['user'], $dbopts['pass']);
  $db = $database;
  $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  */

  $sql_topics = $db->prepare("SELECT * FROM topic");
  $sql_topics->execute();
  $topics = $sql_topics->fetchAll();

	$showForm = true;

  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (
      !empty($_POST["book"]) &&
      !empty($_POST["chapter"]) &&
      !empty($_POST["verse"]) &&
      !empty($_POST["content"]) &&
      !empty($_POST["topics"])
    ) {
      $sql = $db->prepare("INSERT INTO scriptures ("
      ."book, "
      ."chapter, "
      ."verse, "
      ."content"
      .") VALUES ("
      .":book, "
      .":chapter, "
      .":verse, "
      .":content"
      .")");
      $sql->execute(array(
        ":book" => $_POST["book"],
        ":chapter" => $_POST["chapter"],
        ":verse" => $_POST["verse"],
        ":content" => $_POST["content"]
      ));

      // Insert a new scripture
      // Get its id number (does it need a parameter?)
      $scripture_id = $db->lastInsertId('scriptures_id_seq');

      // Insert topics using id number
      $inserts = array();
      foreach ($_POST["topics"] as $topic_id) {
        array_push($inserts, "('$scripture_id', '$topic_id')");
      }
      $topic_insert_query = "INSERT INTO scripture_topic (scripture_id, topic_id) VALUES ";
      $topic_insert_query .= implode(", ", $inserts);
      $topic_insertion = $db->prepare($topic_insert_query);
      $topic_insertion->execute();
      
			$showForm = false;
    } else {
      echo "Put data into all the fields fool. (Mr. T)";
    }
    /*
SELECT DISTINCT s.id, s.book, s.chapter, s.verse, s.content FROM scriptures s
JOIN scripture_topic st ON st.scripture_id = s.id
JOIN topic t ON t.id = st.topic_id

SELECT t.name, st.scripture_id FROM scriptures s
JOIN scripture_topic st ON st.scripture_id = s.id
JOIN topic t ON t.id = st.topic_id
    */
    
    if(!$showForm) {
      $sql = $db->prepare("SELECT DISTINCT s.id, s.book, s.chapter, s.verse, s.content FROM scriptures s "
                          ."JOIN scripture_topic st ON st.scripture_id = s.id "
                          ."JOIN topic t ON t.id = st.topic_id");
      $sql->execute();
      $sResult = $sql->fetchAll();
      $sql = $db->prepare("SELECT t.name, st.scripture_id FROM scriptures s "
                          ."JOIN scripture_topic st ON st.scripture_id = s.id "
                          ."JOIN topic t ON t.id = st.topic_id");
      $sql->execute();
      $tResult = $sql->fetchAll();
    }
  }  

  $database = null;
?>

<!DOCTYPE html>
<html>
<head>
  <title>Search the scriptures!</title>
</head>
<body>
  <?php if($showForm): ?>
    <form action="" method="post">
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
      <input type="submit" value="Submit">
    </form>
  <?php else: ?>
    <div id="results" >
    <?php foreach($sResult as $script): ?>
      <div class="scripture">
        <label>
      		<?php echo $script['book'] . " " . $script['chapter'] . ":" . $script['verse']; ?> 
        </label>
        <p>
          <?php echo $script['content']; ?>
        </p>
        <p>
          <ul>
            <?php foreach($tResult as $topic) {
        			if($topic["scripture_id"] == $script["id"]) {
            		echo '<li>'. $topic['name'] .'</li>';
            	}
           	} ?>
          </ul>
        </p>
      </div>
    <?php endforeach; ?>
  	</div>
		<?php endif; ?>
  </body>
</html>
