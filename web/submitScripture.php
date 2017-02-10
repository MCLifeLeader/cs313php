<?php 

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
	
  // build scriptures return string.
  // this is ugly, but it's just the php-ized version of the html/php loop we were doing before.
  $ajaxResult = "";
  foreach($sResult as $script) {
    $ajaxResult .= "<div class='scripture'><label><strong>";
    $ajaxResult .= ($script['book'] . " " . $script['chapter'] . ":" . $script['verse']);
    $ajaxResult .= "</strong></label>";
    $ajaxResult .= "<p>" . $script['content'] . "</p>";
    $ajaxResult .= "<p><ul>";
    foreach($tResult as $topic) {
      if($topic["scripture_id"] == $script["id"]) {
        $ajaxResult .= '<li>' . $topic['name'] . '</li>';
      }
    }
    $ajaxResult .= "</ul></p></div>";
  }
  $database = null;
  echo $ajaxResult;
?>
