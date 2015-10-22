<!DOCTYPE html>
<html>
	<head>
		<title>Fruit Store</title>
		<link href="http://selab.hanyang.ac.kr/courses/cse326/2015/problems/pResources/gradestore.css" type="text/css" rel="stylesheet" />
	</head>

	<body>
		
		<?php
		# Ex 4 : 
		# Check the existance of each parameter using the PHP function 'isset'.
		# Check the blankness of an element in $_POST by comparing it to the empty string.
		# (can also use the element itself as a Boolean test!)
		if (!isset($_POST["Name"]) || !isset($_POST["MembershipNumber"]) || !isset($_POST["Options"]) 
			|| !isset($_POST["Fruits"]) || !isset($_POST["Quantity"]) || !isset($_POST["Credit"]) || !isset($_POST["Creditcard"])
			|| $_POST["Name"] == "" || $_POST["MembershipNumber"] == "" || $_POST["Options"] == "" 
			|| $_POST["Fruits"] == "" || $_POST["Quantity"] == "" || $_POST["Credit"] == "" || $_POST["Creditcard"] == "" ){
		?>		
			<h1>Sorry</h1>
			<p>You didn't fill out the form completely. <a href="http://127.0.0.1:8020/fruitstore/fruitstore.html">Try again?</a></p> 

		<?php
		# Ex 5 : 
		# Check if the name is composed of alphabets, dash(-), ora single white space.
		} elseif (!preg_match("/[a-zA-Z]([-\s])[a-zA-Z]/", $_POST["Name"])) { 
		?>
			<h1>Sorry</h1>
			<p>You didn't provide a valid name. <a href="http://127.0.0.1:8020/fruitstore/fruitstore.html">Try again?</a></p>

		<?php
		# Ex 5 : 
		# Check if the credit card number is composed of exactly 16 digits.
		# Check if the Visa card starts with 4 and MasterCard starts with 5. 
		} elseif (!preg_match("/[0-9]{16}/", $_POST["Credit"])) {
		?>
			<h1>Sorry</h1>
			<p>You didn't provide a valid credit card number. <a href="http://127.0.0.1:8020/fruitstore/fruitstore.html">Try again?</a></p>		
		
		<?php
		} elseif ($_POST["Creditcard"] == "Visa" && !preg_match("/4[0-9]{15}/", $_POST["Credit"])) {
		?>
			<h1>Sorry</h1>
			<p>You didn't provide a valid credit card number. <a href="http://127.0.0.1:8020/fruitstore/fruitstore.html">Try again?</a></p>
			
		<?php
		} elseif ($_POST["Creditcard"] == "MasterCard" && !preg_match("/5[0-9]{15}/", $_POST["Credit"])) {
		?>
			<h1>Sorry</h1>
			<p>You didn't provide a valid credit card number. <a href="http://127.0.0.1:8020/fruitstore/fruitstore.html">Try again?</a></p>
		
		<?php 
		} else {
		?>

		<h1>Thanks!</h1>
		<p>Your information has been recorded.</p>
		
		<!-- Ex 2: display submitted data -->
		<ul> 
			<li>Name: <?= $_POST["Name"]?></li>
			<li>Membership Number: <?= $_POST["MembershipNumber"]?></li>
			<li>Options: <?= processCheckbox($_POST["Options"])?></li>
			<li>Fruits: <?= $_POST["Fruits"]?> - <?= $_POST["Quantity"]?></li>
			<li>Credit <?= $_POST["Credit"]?> (<?= $_POST["Creditcard"]?>)</li>
		</ul>
		 
		<p>This is the sold fruits count list:</p>
		
		<?php
			$filename = "customers.txt";
			/* Ex 3: 
			 * Save the submitted data to the file 'customers.txt' in the format of : "name;membershipnumber;fruit;number".
			 * For example, "Scott Lee;20110115238;apple;3"
			 */
			file_put_contents($filename, "\n".$_POST["Name"].";".$_POST["MembershipNumber"].";".$_POST["Fruits"].";".$_POST["Quantity"], FILE_APPEND);
		?>
		
		<!-- Ex 3: list the number of fruit sold in a file "customers.txt".
			Create unordered list to show the number of fruit sold -->
		<ul>
		<?php 
			$fruitcounts = soldFruitCount($filename);
			foreach($fruitcounts as $key=>$value) {
		?>
		<li><?= $key?> - <?= $value?></li>
		<?php
		}
		?>
		</ul>
		
		<?php
		}
		?>
		
		<?php
			/* Ex 3 :
			* Get the fruits species and the number from "customers.txt"
			* 
			* The function parses the content in the file, find the species of fruits and count them.
			* The return value should be an key-value array
			* For example, array("Melon"=>2, "Apple"=>10, "Orange" => 21, "Strawberry" => 8)
			*/
			function soldFruitCount($filename) {
				foreach (file($filename) as $name) {
					$customer = explode("\n", $name);
				}
				$customer3 = array();
				$apple = 0;
				$melon = 0;
				$strawberry = 0;
				$orange = 0;
			
				for ($i = 0; $i < count($customer); $i++) {
					$customer2 = explode(";", $customer[$i]);
					if ($customer2[4 * $i + 2] == "Apple") {
						$apple += $customer2[4 * $i + 3];
					}
					elseif ($customer2[4 * $i + 2] == "Melon") {
						$melon += $customer2[4 * $i + 3];
					}
					elseif ($customer2[4 * $i + 2] == "Strawberry") {
						$strawberry += $customer2[4 * $i + 3];
					}
					elseif ($customer2[4 * $i + 2] == "Orange") {
						$orange += $customer2[4 * $i + 3];
					}
				}
				
				$customer3["Apple"] = $apple;
				$customer3["Melon"] = $melon;
				$customer3["Strawberry"] = $strawberry;
				$customer3["Orange"] = $orange;
				
				return $customer3;
			}
			
			function processCheckbox($names){
				if (isset($names)) {
					$result = implode(", ", $names);	
				}
				return $result;
			}
		?>
		
	</body>
</html>
