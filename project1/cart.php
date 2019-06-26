<?php
    $title = "Worst Buy Cart";
	$page = "cart";
    include "header.php";
    include 'Item.class.php';
	include "LIB_project1.php";    
	
	echo "<h2>Current Cart Contents</h2>";

    insertC();
	deleteCheck();
    echo $db->DisplayItemsCart('Cart');
	echo $db->calcCart('Cart');
    



?>

		<!--<div>
			<h2 class = "heading">
				Why to choose worst Buy
			</h2>
		</div>

		<div class = "headerLine"> </div>

		<div>

			<p class = "normText">
				It was a splendid time	in my life that I’ll never forget.
			</p>

		</div>-->

		<?php
			include "footer.php";
		?>
	</body>

</html>