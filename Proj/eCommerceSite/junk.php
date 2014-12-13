<?php 
$page_title = 'Junk.com!';
include ('./includes/header.html');


$page_title = 'Browse the Prints';

require ('./mysqli_connect.php');
 
// Default query for this page:
$q = "SELECT product_id, product_name, product_price, product_description, product_img FROM entity_products_th1998726";


// Create the table head:
echo '<table border="0" width="90%" cellspacing="3" cellpadding="3" align="center">
	<tr>
		<td align="left" width="20%"><b>Product</b></td>
		<td align="left" width="20%"><b>Image</b></td>
		<td align="left" width="40%"><b>Description</b></td>
		<td align="right" width="20%"><b>Price</b></td>
	</tr>';


$r = mysqli_query ($dbc, $q);
while ($row = mysqli_fetch_array ($r, MYSQLI_ASSOC)) {

	// Display each record:
	echo "\t<tr>
		<td align='left'>".$row['product_name']."</td>
		<td align='left'><img src='".$row['product_img']."' style='height:50px;width:50px' /></td>
		<td align='left'>".$row['product_description']."</td>
		<td align='right'>$".$row['product_price']."</td>
	</tr>\n";

} 

echo '</table>';
mysqli_close($dbc);


include ('./includes/footer.html');
?>