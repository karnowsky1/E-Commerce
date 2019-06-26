<?php
	$title = "Worst Buy Home Page";
	$page = "home";
	include "header.php";
    include 'Item.class.php';
	include "LIB_project1.php";

	require_once("DBPDO.class.php");

	$db = new DB();
	pageNumCheck();
	echo createHeader("Sale Items");
	// echo $db->getAllPeopleAsTable();
	echo $db->DisplayItems('Sale_Items');
	echo createHeader("Catalog");
	echo $db->DisplayItems('Catalog');
	
	
 ?>

		<div>
			<h2 class = "heading">
				Why choose worst Buy?
			</h2>
		</div>

		<div class = "headerLine"> </div>

		<div id="items_controls">
			<span class="aright">Showing Page:</span> 
			<b>[<?php echo$_GET['page'] ?>]</b> &nbsp;&nbsp;
			<a href="index.php?page=1">1</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="index.php?page=2">2</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="index.php?page=3">3</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="index.php?page=4">4</a>&nbsp;&nbsp;&nbsp;&nbsp;
		</div>
		<?php


			include "footer.php";
		 ?>
	</body>


</html>
