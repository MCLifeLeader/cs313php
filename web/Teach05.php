<?php  
	error_reporting(E_ALL);
	ini_set("display_errors", 1);
	$scripture = "";
	$isContent = false;
	if ($_SERVER['REQUEST_METHOD'] == 'GET') {
        $connStr = getenv("DATABASE_URL");
        $url = parse_url($connStr);
        $dbopts = $url;
        // If there is no database connection string from the "getenv" method then I am running on my local development machine
        if(empty($connStr)) {
            $database = new PDO("pgsql:host=localhost port=5432 dbname=cs313Dev user=cs313 password=P@ssword123");
        }
        else {
            // Environment variable set. Use and parse the string from Heroku service
            $database = new PDO("pgsql:host=" . $dbopts['host'] . "; dbname=" . str_replace('/', '', $dbopts['path']),  $dbopts['user'], $dbopts['pass']);
        }
        $db = $database;
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        if (!empty($_GET['id'])) {
        $isContent = true;
        $sql = $db->prepare("SELECT * FROM scriptures
                                                WHERE id = :id");
        $sql->execute(array(":id" => $_GET['id']));
        $result = $sql->fetch(PDO::FETCH_ASSOC);
        } else if (!empty($_GET['scripture'])) {
        $sql = $db->prepare("SELECT * FROM scriptures 
                            WHERE LOWER(book) LIKE '%" . strtolower($_GET['scripture']) . "%' OR "
                            ." LOWER(content) LIKE '%" . strtolower($_GET['scripture']) . "%'"
                            );
        $sql->execute();
        
        $result = $sql->fetchAll();
        } else {
            $scripture = "Search for stuff!";
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
  	<form action="" method="get">
  		<input type="text" name="scripture">
  		<br>
  		<input type="submit" value="SEARCH!!!">
  	</form>
  	<br>
  	<br>
  	<?php 
      if (!$isContent) {
        if (!empty($result)) {
          foreach($result as $row) {
            echo '<strong>
                    <a href="Teach05.php?id='.$row["id"].'">' 
                      . $row["book"] . " " . $row["chapter"] . ":" . $row["verse"] . "
                    </a>
                  </strong><br><br>";
          } 
        } else {
          echo 'Search for things!';
        }
      } else {
       	echo '<strong>' . $result["book"] . " " . $result["chapter"] . ":" . $result["verse"] . "</strong> - " . $result['content'];
      }
		?>
  </body>
</html>
