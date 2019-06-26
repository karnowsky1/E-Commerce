<?php
	$title = "Worst Buy Home Page";
	$page = "home";
	include "header.php";
    include 'Item.class.php';
	include "LIB_project1.php";

	require_once("DBPDO.class.php");

	$db = new DB();
	pageNumCheck();
	echo createHeader("Header is working");
	echo "<h2>Sale Items</h2>";
	// echo $db->getAllPeopleAsTable();
	echo $db->DisplayItems('Sale_Items');
	echo "<h2>Catalog</h2>";
	echo $db->DisplayItems('Catalog');
	
	
 ?>

		<div>
			<h2 class = "heading">
				Why to choose worst Buy
			</h2>
		</div>

		<div class = "headerLine"> </div>

		<div>
			<p class = "normText">
				It was a splendid time	in my life that I’ll never forget.
			</p>
		</div>

		<div id="items_controls">
			<span class="aright">Showing items 1 - 5</span> 
			[<b>1</b>] &nbsp;&nbsp;
			<a href="index.php?page=2">2</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="index.php?page=3">3</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="index.php?page=2">&gt;</a>&nbsp;&nbsp;&nbsp;&nbsp;
			<a href="index.php?page=3">&gt;&gt;</a>&nbsp;&nbsp;
		</div>
		<?php


			include "footer.php";
		 ?>
	</body>


</html>
