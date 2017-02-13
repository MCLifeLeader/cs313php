<?php
  error_reporting(E_ALL);
  ini_set("display_errors", 1);
//   $scripture = "";
//   $isContent = false;

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

  $sql_topics = $db->prepare("SELECT * FROM topic");
  $sql_topics->execute();
  $topics = $sql_topics->fetchAll();


    if (
      !empty($_POST["book"]) &&
      !empty($_POST["chapter"]) &&
      !empty($_POST["verse"]) &&
      !empty($_POST["content"]) &&
      !empty($_POST["topics"])
    ) {
      $newTopic = false;
      if (!empty($_POST["new"]) && !empty($_POST["newTopic"])) {
        $sql = $db->prepare("INSERT INTO topic ("
                              ."name"
                            .") VALUES ("
                              .":newTopic"
                            .")");
        $sql->execute(array(
          ":newTopic" => $_POST["newTopic"]
        ));
        $newTopic = true;
        $newTopic_id = $db->lastInsertId('topic_id_seq');
      }
          
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
      if ($newTopic) {
        array_push($inserts, "('$scripture_id', '$newTopic_id')");
      }
      $topic_insert_query = "INSERT INTO scripture_topic (scripture_id, topic_id) VALUES ";
      $topic_insert_query .= implode(", ", $inserts);
      $topic_insertion = $db->prepare($topic_insert_query);
      $topic_insertion->execute();
      
      $showForm = false;
    } else {
      echo "Put data into all the fields fool. (Mr. T)";
    }

  $database = null;
?>
