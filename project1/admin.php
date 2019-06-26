<?php
    $title = "Worst Buy Admin Page";
	$page = "admin";
	include "header.php";
    include 'Item.class.php';
	include "LIB_project1.php";

	require_once("DBPDO.class.php");

	$db = new DB();
    
    echo "<h2>Administer Inventory Page</h2>";
    adminSanitizer();
    echo $db->saleSelect();
    deleteSale();


?>

    <div class="form-group">
        <div class="box">
			<form action='admin.php' method='POST' enctype="multipart/form-data">
				<table>
					<tr><td colspan="2" class='areaHeading'>Add Item:</td></tr>
				   <tr>
					   <td>
						   Name:
					   </td>
					   <td>
						   <input type="text" name="name" size="40" value="" />
					   </td>
				   </tr>
				   <tr>
					   <td>
						   Description:
					   </td>
					   <td>
						   <textarea name="description" rows="3" cols="60"></textarea>
					   </td>
				   </tr>
				   <tr>
					   <td>
						   Price:
					   </td>
					   <td>
						   <input type="text" name="price" size="40" value="" />
					   </td>
				   </tr>
				   <tr>
					   <td>
						   Quantity on hand:
					   </td>
					   <td>
						   <input type="text" name="quantity" size="40" value="" />
					   </td>
				   </tr>
				   <tr>
					   <td>
						   Sale Price:
					   </td>
					   <td>
						   <input type="text" name="salesPrice" size="40" value="0" />
					   </td>
				   </tr>
				   <tr>
					   <td>
						   New Image:
					   </td>
					   <td>
						   <input type="file" name="image" />
					   </td>
				    </tr>
			   		<tr>
				        <td>
							<strong>Your Password: </strong>
						</td>
						<td>
							<input type="password" name="password" size="15" />
						</td>
			   </table>
			   <br />
			   <input type="reset" value="Reset Form" />
			   <input type="submit" name="submit_item" value="Submit Item" />
		   </form>
        </div>
    </div >

    <?php
		include "footer.php";
	?>
	</body>


</html> 