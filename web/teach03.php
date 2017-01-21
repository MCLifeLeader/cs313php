<?php
    // Config PHP To Display Errors
	error_reporting(E_ALL);
	ini_set("display_errors", 1);

	// https://xkcd.com/327/
    function sanitize($data) {
      $data = trim($data);
      $data = stripslashes($data);
      $data = htmlspecialchars($data);
      return $data;
    }

	$showForm = true;

    // Associative array containing all majors.
	$majors = array(
      "CS"  => "Computer Science",
      "WDD" => "Web Design and Development",
      "CIT" => "Computer Information Technology",
      "CE"  => "Computer Engineering"
	);

    // Associative array containing all continents.
	$continents = array(
    	"na" => "North America",
    	"sa" => "South America",
    	"eu" => "Europe",
    	"as" => "Asia",
    	"au" => "Australia",
    	"af" => "Africa",
    	"an" => "Antarctica"
    );

	$name;
	$email;
	$major;
	$displayMajor;
	$comments;
	$displayContinents = array();

    $nameErr = "";
    $emailErr = "";
    $continentErr = "";
    $majorErr = "";

    // If the form was posted with a Name variable...
    // another option... if ($_SERVER["REQUEST_METHOD"] == "POST")
	// then, sanitize and validate using emtpty()
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		$showForm = false;
    
      	$name = sanitize($_POST["Name"]);
        $email = sanitize($_POST["Email"]);
      	$major = sanitize($_POST["Major"]);
        $continent = $_POST["Continents"];
                                
        if (empty($name)) { 
          	$nameErr = "Name is Required"; 
            $showForm = true;
        } 
            
        if (empty($_POST["Email"])) { $emailErr = "Email is Required"; $showForm = true; }
        else if (!filter_var($_POST["Email"], FILTER_VALIDATE_EMAIL)) {
          $emailErr = "Invalid Email Format"; 
          $showForm = true;
        }
      
        if (empty($_POST["Major"])) { 
          $majorErr = "Major is Required";
          $showForm = true; } 
      
        if (empty($_POST["Continents"])) { 
          $continentErr = "Continent is Required"; 
          $showForm = true;
        } 
      
        // Iterate through majors and store display name
        $displayMajor = $majors[$major];
		$comments = sanitize($_POST["Comments"]);

        // Iterate through continents and build array of display names
        foreach ($_POST["Continents"] as $postCont) {
          array_push($displayContinents, sanitize($continents[$postCont]));
        }
        // Concatenate contintents together using a comma
      	$displayContString = implode(", ", $displayContinents);
	}
?>

<!DOCTYPE html>
<html lang="en-us">
	<head>
		<title>Simple Survey - Group 4</title>
  
  		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

  	</head>
	<body>
  		<div class="container body-content">
          <?php // DISPLAYING FORM ?>
          <?php if ($showForm): ?>
          <div class="row">
              <div class="col-md-12 col-xs-offset-0 col-sm-offset-0 col-md-offset-6 col-lg-offset-0">
                  <div class="panel panel-info" style="border-width: 2px;">
                      <div class="panel-heading">
                          <h3 class="panel-title" style="font-weight: bolder;">
                              Input Survey
                          </h3>
                      </div>
                      <div class="panel-body">
                          <div class="col-md-12">
                            <form action="" method="POST">
                            <?php // use isset() here to populate the fields with previous values ?>
                            <div class="form-group">
                                <label class="control-label" for="Name">Name *</label>
                                <input class="form-control" 
                                        type="text" 
                                        name="Name" 
                                          id="Name" 
                                 placeholder="Name"
                                    required>
                                <span class="error"><?php echo $nameErr; ?></span>
                            </div>

                            <div class="form-group">
                                <label class="control-label" for="Email">Email *</label>
                                <input class="form-control"
                                        type="email" 
                                        name="Email" 
                                          id="Email" 
                                 placeholder="Email"
                                    required>
                                <span class="error"><?php echo $emailErr; ?></span>
                            </div>

                            <label class="control-label" for="Major">Major *</label>
                            <br />
                            <?php // Build list of majors - radio buttons ?>
                            <?php foreach ($majors as $code => $name): ?>
                                <div class="radio">
                                    <input  type="radio"
                                            name="Major"
                                              id="<?php echo $code; ?>"
                                           value="<?php echo $code; ?>"
                                         required
                                			<?php if(isset($major) && $code == $major) { echo ' checked'; } ?>>
                                    <label class="control-label" for="<?php echo $code; ?>"><?php echo $name ?></label>
                                </div>
                            <?php endforeach ?>
                            <br />

                            <label class="control-label" for="Continents">Continents </label>
                            <br />
                            <?php // Build list of continents - checkboxes ?>
                            <?php foreach ($continents as $code => $name): ?>
                                <div class="checkbox">
                                    <input type="checkbox"
                                           name="Continents[]"
                                             id="<?php echo $code; ?>"
                                          value="<?php echo $code; ?>"
                                           <?php if($code == 'na') { echo ' required'; } ?>>
                                    <label  for="<?php echo $code; ?>"><?php echo $name; ?></label>
                                </div>
                            <?php endforeach ?>

                            <div class="form-group">
                                <label class="control-label" for="Comments">Comments</label>
                                <textarea class="form-control" name="Comments" placeholder="Comments"></textarea>
                            </div>
                            <input class="btn btn-primary" type="submit" name="Submit" value="Submit">
                          </div>
                      </div>
                      <div class="panel-footer">
                          <div style="font-size: smaller;">
                              &nbsp;
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          </form>
          <?php // DISPLAYING RESULTS ?>
          <?php else: ?>
          <div class="row">
              <div class="col-md-12 col-xs-offset-0 col-sm-offset-0 col-md-offset-6 col-lg-offset-0">
                  <div class="panel panel-info" style="border-width: 2px;">
                      <div class="panel-heading">
                          <h3 class="panel-title" style="font-weight: bolder;">
                              Results
                          </h3>
                      </div>
                      <div class="panel-body">
                          <div class="col-md-12 result">
                            <p> Name:       <?php echo $name;              ?> </p>
                            <p> Email:    <a href="mailto:<?php echo $email; ?>">
                                            <?php echo $email; ?> </a> </p>
                            <p> Major:      <?php echo $displayMajor;      ?> </p>
                            <p> Continents: <?php echo $displayContString; ?> </p>
                            <p> Comments:   <?php echo $comments;          ?> </p>
                          </div>
                      </div>
                      <div class="panel-footer">
                          <div style="font-size: smaller;">
                              &nbsp;
                          </div>
                      </div>
                  </div>
              </div>
          </div>
          <?php endif; ?>
        </div>
	</body>
</html>
