<?php
$page_title = 'Junk.com!';
include ('./includes/header.html');


$numRows="";
//connection
$servername = "209.129.8.5";
$username = "48075";
$password = "48075cis12";
$dbname = "48075";

	$conn = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($conn->connect_error){
		die("Connection failed: " . $conn->connect_error);
	};
	$sql = "SELECT product_id FROM entity_products_th1998726";
	$result = $conn->query($sql);
	//check if there is a match
	if ($result->num_rows > 0){
		$numRows= $results->num_rows;
	};
	
  function GenerateRandom($min, $max, $range) {
		$numbers = range($min, $max);
		shuffle($numbers);
		return array_slice($numbers, 0, $range);
  }

  $results= GenerateRandom(0, $numRows, 4);

  while($row = $result->fetch_assoc()){
	for($i=0;$i<3;$i++){
		$sql = "SELECT product_name, product_img FROM entity_products_th1998726 WHERE product_id = '$results[$i]'";
		$result = $conn->query($sql);
		$cookie_name="slide_show_name".$i;
		$cookie_name_value= $row["product_name"];
		$cookie_img="slide_show_img".$i;
		$cookie_img_value=$row["product_img"];
		setcookie($cookie_name, $cookie_name_value, time()+(86400), "/");
		setcookie($cookie_img, $cookie_img_value, time()+(86400), "/");
	};
  };
  
  //close the connection
  $conn->close();  

?>

<div style="width:500px; display:<?php echo $adminShow;?>">
<h1>Administrator</h1><br />
<a href="new_product.php">Add new product</a><br /><br />
<a href="orders.php">View Orders</a>
</div>

<div style="display:<?php echo $customerShow;?>;  top:20px">

<h1 style="text-align:center">JUUUUNNNNKKKKK</h1>
<img id="slideShow" src="" style="height:400px; width:300px" />
<p>&nbsp &nbsp &nbsp <b>W</b>elcome to the most interesting place to buy JUNK! Yes, that stuff you can not resist. You have it everywhere. In your kitchen drawers, in the garage, in your attic, on your walls and just about anywhere else you have space to store stuff. Now you dont have to even leave your house to acquire MORE junk!!</p>

<script type="text/javascript">


var img;
var name;

function getCookie(cname){
    var name = cname + "=";
    var ca = document.cookie.split(';');
    for(var i=0; i < ca.length; i++) {
        var c = ca[i];
        while (c.charAt(0)==' ') c = c.substring(1);
        if (c.indexOf(name) != -1) return c.substring(name.length, c.length);
    }
    return "";
}

for(var i=0;i<3; i++){
	name.i = getCookie("slide_show_name"+i);
	img.i = getCookie("slide_show_img"+i);
};

setInterval("slideShow()", 5000);

function slideShow(){
	var num= Math.floor(Math.random()*4);
	var SS= getElementById("slideShow");
	SS.src = "images/"+img.num;
	SS.alt= name.num;
};
	


</script>
</div>



<?php
include ('./includes/footer.html');
?>
