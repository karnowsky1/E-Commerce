<!DOCTYPE html>
<html lang = "en">
<head>
	<meta charset=utf-8 />
	<title><?php echo $title;?></title>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="assets/css/styles.css">
	<script src="assets/javascript/style.js"></script>
</head>

<body>
	<div class="background">

		<div class="headerImg"> <!-- logo welcoming the user -->
			<a href="index.php">
				<img class="imgResp" src="assets/images/logo.png" alt="WorstBuy Logo">
				<!-- style="width: 75px; height: 75px;" -->
				<!-- width = "75px" height = "75px" -->
			</a>
		</div>


		<nav> <!-- Navbar created to navigate through the pages -->
			<div id="nav-inner">
				<ul>
					<li<?php echo (isset($page) && $page=='home') ? ' class="active" ' :'' ?>> <a href="index.php" title=""> Home </a> </li>
					<li<?php echo (isset($page) && $page=='cart') ? ' class="active" ' :'' ?>> <a href="cart.php" title=""> Cart </a> </li>
					<li<?php echo (isset($page) && $page=='admin') ? ' class="active" ' :'' ?>> <a href="admin.php" title=""> Admin </a> </li>
				</ul>
			</div>

			<div class="hamburger" onclick="mobileNav(this)">
				<div class="bar1"></div>
				<div class="bar2"></div>
				<div class="bar3"></div>
			</div>
		</nav>

		<!-- Paragraph descrbing myself -->

	</div><!-- background div ends here -->
