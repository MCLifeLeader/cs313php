 <!DOCTYPE html>
<html>
<body>

 <?php
 

echo "Environment = " . getenv("PAYPAL_CLIENT") . "<br/>";

$x = 4;
$y = "4";
print "1";

if ($x == $y)
	print "2";
if ($x === $y)
	print "3";

$list1[] = 17;
$list2[0] = 17;

echo "<br/>";
echo "<br/>";

var_dump($list1);
echo "<br/>";
var_dump($list2);

$list3[] = array(17,42);
$list4[] = array(0=>17, 1=>42);

echo "<br/>";
echo "<br/>";

var_dump($list3);
echo "<br/>";
var_dump($list4);


//$ages = array("Steve" = 32, "Mary" = 25);
$ages = array("Steve" => 32, "Mary" => 25);
$ages = array("Steve" => 32, 25 => "Mary");


?> 

</body>
</html> 
