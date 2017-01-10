 <!DOCTYPE html>
<html>
<body>

 <?php
function myTest() {
    $x = 5; // local scope
    echo "<p>Variable x inside function is: $x</p>";
}
myTest();

// using x outside the function will generate an error
echo "<p>Variable x outside function is: $x</p>";

$cars = array("Volvo","BMW","Toyota");
var_dump($cars);

echo "<br />";
echo "<br />";

$x = 0;

do {
    echo "The number is: $x <br>";
    $x++;
} while ($x <= 5);

echo "<br />";
echo "<br />";

$colors = array("red", "green", "blue", "yellow");

foreach ($colors as $value) {
    echo "$value <br>";
}

echo "<br />";
echo "<br />";

function familyName($fname, $year) {
    echo "$fname Refsnes. Born in $year <br>";
}

familyName("Hege", "1975");
familyName("Stale", "1978");
familyName("Kai Jim", "1983");

echo "<br />";
echo "<br />";

echo "I like " . $cars[0] . ", " . $cars[1] . " and " . $cars[2] . ".";

echo "<br />";
echo "<br />";

var_dump ($GLOBALS);
echo "<br />";
echo $_SERVER['PHP_SELF'];
echo "<br>";
echo $_SERVER['SERVER_NAME'];
echo "<br>";
echo $_SERVER['HTTP_HOST'];
echo "<br>";
echo $_SERVER['HTTP_REFERER'];
echo "<br>";
echo $_SERVER['HTTP_USER_AGENT'];
echo "<br>";
echo $_SERVER['SCRIPT_NAME'];
echo "<br />";
var_dump ($_REQUEST);
echo "<br />";
echo "<br />";
var_dump ($_POST);
echo "<br />";
echo "<br />";
var_dump ($_GET);
echo "<br />";
echo "<br />";
var_dump ($_FILES);
echo "<br />";
echo "<br />";
var_dump ($_ENV);
echo "<br />";
echo "<br />";
var_dump ($_COOKIE);
echo "<br />";
echo "<br />";
var_dump ($_SESSION);
echo "<br />";
echo "<br />";



	
?> 

</body>
</html> 
