<?php

	
session_start();


//store user data

$region = $_POST['Region'];
$sex = $_POST['Sex'];
$children = $_POST['Children'];
$elderly = $_POST['Elderly'];
$animal = $_POST['Animal'];
$car = $_POST['Car'];
	 
//arrays

$coicop = []; 
$item_w = []; 
$cpih = [];
$user = ["Children" => $children, "Elderly" => $elderly, "Animal" => $animal, "Car" => $car,];
$basket = [ 
			'LD' => ['VALUE' => 2, 'PRODUCTS' => []],
			'SE' => ['VALUE' => 3, 'PRODUCTS' => []], 
			'SW' => ['VALUE' => 4, 'PRODUCTS' => []], 
			'EA' => ['VALUE' => 5, 'PRODUCTS' => []], 
			'EM' => ['VALUE' => 6, 'PRODUCTS' => []], 
			'WM' => ['VALUE' => 7, 'PRODUCTS' => []], 
			'YM'  => ['VALUE' => 8, 'PRODUCTS' => []], 
			'NW' => ['VALUE' => 9, 'PRODUCTS' => []], 
			'NT' => ['VALUE' => 10, 'PRODUCTS' => []], 
			'WL' => ['VALUE' => 11, 'PRODUCTS' => []], 
			'SC' => ['VALUE' => 12, 'PRODUCTS' => []], 
			'NI' => ['VALUE' => 13, 'PRODUCTS' => []]
		];
?>

<!DOCTYPE html>
<html>


<head>

	
	<title>Survey</title>

	
</head>


<body>


<?php
//https://www.airpair.com/php/fatal-error-allowed-memory-size
ini_set('memory_limit', '256M');

//debug_backtrace
ini_set('display_errors', 'On');
error_reporting(E_ALL);


/*
	
	1. Open PDO connection 
	2. prepare the SQL queries to execute
	3. Create empty array for services 
	4. Insert data in 3 arrays
		4.1 CPIH
		4.2 COICOP
		4.3 ITEM_W
	5. Create empty array for goods
	6. 
	
*/


try {

//connection http://php.net/manual/en/pdo.prepare.php 

$db = new PDO ('mysql:host=db.dcs.aber.ac.uk;dbname=cs39620_17_18_mim32', 'mim32', 'michelangelomastroroccodegrandis');

//Queries 
$sql = $db->prepare("SELECT * FROM price_index WHERE ITEM_ID NOT IN (SELECT ITEM_ID FROM price_quote) ORDER BY COICOP_WEIGHT");

$sth = $db->prepare("SELECT * FROM price_index ORDER BY ITEM_ID");

$stmt2 = $db->prepare("SELECT * FROM price_quote WHERE REGION = 2 AND STRATUM_WEIGHT > 0 ORDER BY ITEM_ID");
$stmt3 = $db->prepare("SELECT * FROM price_quote WHERE REGION = 3 AND STRATUM_WEIGHT > 0 ORDER BY ITEM_ID");
$stmt4 = $db->prepare("SELECT * FROM price_quote WHERE REGION = 4 AND STRATUM_WEIGHT > 0 ORDER BY ITEM_ID");
$stmt5 = $db->prepare("SELECT * FROM price_quote WHERE REGION = 5 AND STRATUM_WEIGHT > 0 ORDER BY ITEM_ID");
$stmt6 = $db->prepare("SELECT * FROM price_quote WHERE REGION = 6 AND STRATUM_WEIGHT > 0 ORDER BY ITEM_ID");
$stmt7 = $db->prepare("SELECT * FROM price_quote WHERE REGION = 7 AND STRATUM_WEIGHT > 0 ORDER BY ITEM_ID");
$stmt8 = $db->prepare("SELECT * FROM price_quote WHERE REGION = 8 AND STRATUM_WEIGHT > 0 ORDER BY ITEM_ID");
$stmt9 = $db->prepare("SELECT * FROM price_quote WHERE REGION = 9 AND STRATUM_WEIGHT > 0 ORDER BY ITEM_ID");
$stmt10 = $db->prepare("SELECT * FROM price_quote WHERE REGION = 10 AND STRATUM_WEIGHT > 0 ORDER BY ITEM_ID");
$stmt11 = $db->prepare("SELECT * FROM price_quote WHERE REGION = 11 AND STRATUM_WEIGHT > 0 ORDER BY ITEM_ID");
$stmt12 = $db->prepare("SELECT * FROM price_quote WHERE REGION = 12 AND STRATUM_WEIGHT > 0 ORDER BY ITEM_ID");
$stmt13 = $db->prepare("SELECT * FROM price_quote WHERE REGION = 13 AND STRATUM_WEIGHT > 0 ORDER BY ITEM_ID");


//arrays for 3d array

$item = [];
$Item = [];
$Item2 = [];
$Item3 = [];
$Item4 = [];
$basket_goods = [];
$list = [];


//basket of services 

$sql->execute();
$results = $sql->fetchAll(PDO::FETCH_ASSOC);


//variables

$x = [];
$y = [];
$w = [];
$q = [];

//create 3 arrays $cpih, $coicop. $item_w

foreach ($results as $value => $key) {


	$Item[$key['ITEM_ID']] = [

		'ITEM_DESC' => $key['ITEM_DESC'],
		'COICOP_WEIGHT' => $key['COICOP_WEIGHT'],
		'ITEM_WEIGHT' => $key['ITEM_WEIGHT'],
		'CPIH_COICOP_WEIGHT' => $key['CPIH_COICOP_WEIGHT'],
		'CLASS' => $key['CLASS'],
		'LIST' => $list

	];


$x = $Item;


	$Item2[$key['ITEM_ID']] = [


		'ITEM_ID' => $key['ITEM_ID'],
		'ITEM_DESC' => $key['ITEM_DESC'],
		'COICOP_WEIGHT' => $key['COICOP_WEIGHT'],
		'ITEM_WEIGHT' => $key['ITEM_WEIGHT'],
		'CPIH_COICOP_WEIGHT' => $key['CPIH_COICOP_WEIGHT'],
		'CLASS' => $key['CLASS']


	];


	//condition to split TABLE price_index in $coicop, $cpih and $item_w  			

	if  ($key['COICOP_WEIGHT'] == 0.00)	{			


		$y = $Item;
		$w = $Item2;


	}; 	


}; 


foreach ($w as $value => $key) {


	if  ($key['ITEM_WEIGHT'] == 0.00)	{


		$Item3[$key['ITEM_ID']] = [

			'ITEM_DESC' => $key['ITEM_DESC'],
			'CPIH_COICOP_WEIGHT' => $key['CPIH_COICOP_WEIGHT'],
			'CLASS' => $key['CLASS']	

		];	

		$Item4[$key['ITEM_ID']] = [

			'ITEM_DESC' => $key['ITEM_DESC'],
			'COICOP_WEIGHT' => $key['COICOP_WEIGHT'],
			'ITEM_WEIGHT' => $key['ITEM_WEIGHT'],
			'CPIH_COICOP_WEIGHT' => $key['CPIH_COICOP_WEIGHT'],
			'CLASS' => $key['CLASS'],
			'LIST' => $list
		];

		
		$q = $Item4;
		$cpih = $Item3;


	}; 	
	
};


//https://www.w3schools.com/php/func_array_udiff.asp		

function myfunction($a,$b)	{
	
	
	if ($a===$b)	{
  
		
		return 0;
	
	
	};
  
  
  return ($a>$b)?1:-1;

};


$coicop = array_udiff($x,$y,"myfunction");
$item_w = array_udiff($y,$q,"myfunction");

//unset arrays

unset($Item);
unset($Item2);
unset($Item3);
unset($Item4);
unset($y);
unset($w);
unset($q);



//close connection query

$sql->closeCursor();


//execute new query	

$sth->execute();
$results= $sth->fetchAll(PDO::FETCH_ASSOC);


//create array that not include items from previous query

$h = [];
foreach ($results as $value => $key) {
	
	$item[$key['ITEM_ID']] = [
		'ITEM_DESC' => $key['ITEM_DESC'],
		'COICOP_WEIGHT' => $key['COICOP_WEIGHT'],
		'ITEM_WEIGHT' => $key['ITEM_WEIGHT'],
		'CPIH_COICOP_WEIGHT' => $key['CPIH_COICOP_WEIGHT'],
		'CLASS' => $key['CLASS'],
		'LIST' => $list
	];
	
$h = $item;
	
};


//basket of goods 

$basket_goods = array_udiff($h, $x,"myfunction");

//Perform RegExp to select items for user



$Men = [];
$Women = [];
$Children = [];
$Elderly = [];
$Animal = [];
$Car = [];

//http://www.rexegg.com/regex-quickstart.html RegExp

foreach ($basket_goods as $key => $value) {

	
	if (preg_match_all("/(^MENS.*) | (^MEN'S.*) | (GENT'S ) | (CONDOM )/", $value['ITEM_DESC'])) {
		
		$Men[$key] = $value;
		
	};
	
	if (preg_match_all("/(OMEN) | (OMANS) | (HAIR STYLING) | (LADY) | (LADIES) | (GOLD) | (EARRINGS) | (DIAMOND) | (NECKLACE) | (TAMPONS) | (MASCARA) | (LIP) | (NAIL) | (MANICURE)/", $value['ITEM_DESC'])) {
		
		$Women[$key] = $value;
		
	};
	
	if (preg_match_all("/(GIRLS)| (CHILDS) | (BOYS) | (PUSHCHAIR) | (NURSERY) | (SCHOOL) | (BABY) | (MODEL) | (TOY)/", $value['ITEM_DESC'])) {
		
		$Children[$key] = $value;
		
	};
	
	if (preg_match_all("/(FUNERAL) | (ASSISTANT) | (BASIC WILL) | (NURSING)/", $value['ITEM_DESC'])) {
		
		$Elderly[$key] = $value;
		
	};
	
	if (preg_match_all("/(^CAT )|(^DOG)|(MAMMAL)|(BIRD)|(BOOSTER)|(PET)|(^LIVERY)/", $value['ITEM_DESC'])) {
		
		$Animal[$key] = $value;
		
	};
	
	if (preg_match_all("/(CAR) | (DIESEL) | (PETROL) | (VEHICLE EXCISE) | (BRAKE) | (EXHAUST) | (DRIVING)/", $value['ITEM_DESC'])) {
		
		$Car[$key] = $value;
		
	};
	
};

$basket_good = [];
$Basket_good = [];

if ($sex == 0) {
	
	if ($children == 0) {
	
		if ($elderly == 0) {
	
			if ($animal == 0) {
	
				if ($car == 0) {
	
					$Basket_good = $Women + $Children + $Elderly + $Animal + $Car; 
					
				} 
				
				else 
				
				{
	
					$Basket_good = $Women + $Children + $Elderly + $Animal;
	
				};
	
			} 
			
			else 
			
			{
	
				if ($car == 0) {
	
					$Basket_good = $Women + $Children + $Elderly + $Car;
					
				} 
				
				else 
				
				{
	
					$Basket_good = $Women + $Children + $Elderly;
					
				};
	
			};
	
		} 
		
		else 
		
		{
	
			if ($animal == 0) {
	
				if ($car == 0) {
	
					$Basket_good = $Women + $Children + $Animal + $Car;
	
				} 
			
				else 
			
				{

					$Basket_good = $Women + $Children + $Animal;
	
				};
	
			} 
		
			else 
				
			{
	
				if ($car == 0) {
	
					$Basket_good = $Women + $Children + $Car;
					
				} 
			
				else 
				
				{	
				
					$Basket_good = $Women + $Children;
					
				};
	
			};
	
		};
	
	} 
		
	else 
	
	{
	
		if ($elderly == 0) {
	
			if ($animal == 0) {
	
				if ($car == 0) {
	
					$Basket_good = $Women + $Elderly + $Animal + $Car;
	
				} 
			
				else 
				
				{
	
					$Basket_good = $Women+ $Elderly + $Animal;
					
				};
	
			} 
			
			else 
			
			{

				if ($car == 0) {
	
					$Basket_good = $Women + $Elderly + $Car;
					
				} 
			
				else 
				
				{

					$Basket_good = $Women + $Elderly;
					
				};
	
			};
	
		} 
	
		else 
		
		{
	
			if ($animal == 0) {
	
				if ($car == 0) {
	
					$Basket_good = $Women + $Animal + $Car;
					
				} 
			
				else 
				
				{
	
					$Basket_good = $Women + $Animal;
					
				};
	
			} 
			
			else 
			
			{
	
				if ($car == 0) {
	
					$Basket_good = $Women + $Car;
					
				} 
				
				else
				
				{
	
					$Basket_good = $Women;
					
				};
	
			};
	
		};
	
	};
	
} 
	
else 

{
	
	if ($children == 0) {
	
		if ($elderly == 0) {
	
			if ($animal == 0) {
	
				if ($car == 0) {
	
					
					$Basket_good = $Men + $Children + $Elderly + $Animal + $Car; 
					
				} 
				
				else 
				
				{
	
					$Basket_good = $Men + $Children + $Elderly + $Animal;
	
				};
	
			} 
			
			else 
			
			{
	
				if ($car == 0) {
	
					$Basket_good = $Men + $Children + $Elderly + $Car;
					
				} 
				
				else 
				
				{
	
					$Basket_good = $Men + $Children + $Elderly;
					
				};
	
			};
	
		} 
		
		else 
		
		{
	
			if ($animal == 0) {
	
				if ($car == 0) {
	
					$Basket_good = $Men + $Children + $Animal + $Car;
					
				} 
				
				else 
				
				{
	
					$Basket_good = $Men + $Children + $Animal;
					
				};
	
			} 
				
			else 
				
			{
	
				if ($car == 0) {
	
					$Basket_good = $Men + $Children + $Car;
					
				} 
				
				else 
				
				{
	
					$Basket_good = $Men + $Children;
					
				};
	
			};
	
		};
	
	} 
	
	else 
	
	{
	
		if ($elderly == 0) {
	
			if ($animal == 0) {
	
				if ($car == 0) {
	
					$Basket_good = $Men + $Elderly + $Animal + $Car;
	
				} 
					
				else 
				
				{
	
					$Basket_good = $Men + $Elderly + $Animal;
					
				};
	
			} 
			
			else 
				
			{
	
				if ($car == 0) {
	
					$Basket_good = $Men + $Elderly + $Car;
					
				} 
				
				else 
				
				{
				
					$Basket_good = $Men + $Elderly;
					
				};
	
			};
	
		} 
		
		else 
		
		{
	
			if ($animal == 0) {
	
				if ($car == 0) {
	
					$Basket_good = $Men + $Animal + $Car;
					
				} 
					
				else 
				
				{
	
					$Basket_good = $Men + $Animal;
					
				};
	
			} 
				
			else 
			
			{	
			
				if ($car == 0) {
	
					$Basket_good = $Men + $Car;
					
				} 
				
				else
				
				{
	
					$Basket_good = $Men;
					
				};
	
			};
	
		};
	
	};
	
};

//DELETE FROM ARRAYS

$basket_good = array_udiff($basket_goods, $Basket_good, "myfunction");	


unset($Basket_good);
unset($basket_goods);
//loop from query




foreach ($basket as $key => $value){
	
	$basket[$key]['PRODUCTS'] = $basket_good;

};



unset($item);
unset($x);
unset($h);
unset($basket_good);

//close connection
$sth->closeCursor();


//LD QUERY	

$stmt2->execute();
$items = $stmt2->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC);

foreach($items as $key => $value)	{

//ARRAYS
$p = [];
$s = [];
	

foreach($value as $k => $v)	{

		unset($v['ID']);
		unset($v['REGION']);
		
		if (in_array($v['PRICE'], $s)) {
			
			continue;
			
		}
		
		$s[$k] = $v['PRICE'];

		$p[$key][$k] = ['PRICE' => $v['PRICE'], 'STRATUM_WEIGHT' => $v['STRATUM_WEIGHT'], 'STRATUM_TYPE' => $v['STRATUM_TYPE'], 'INDICATOR_BOX' => $v['INDICATOR_BOX'], 'PRICE_RELATIVE' => $v['PRICE_RELATIVE'], 'SHOP_TYPE' => $v['SHOP_TYPE'], 'SHOP_WEIGHT' => $v['SHOP_WEIGHT']];
		$p2 = ['ITEM_DESC' => $v['ITEM_DESC']];
		
	};
	

$resulting_array = $p2 + $p[$key];
$basket['LD']['PRODUCTS'][$key] = $resulting_array;
	
	
unset($p);
unset($p2);
unset($s);
unset($resulting_array);
};

 
$stmt2->closeCursor();

//SE QUERY	

$stmt3->execute();
$items = $stmt3->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC);

 
foreach($items as $key => $value)	{

//ARRAYS
$p = [];
$s = [];
	

foreach($value as $k => $v)	{

		unset($v['ID']);
		unset($v['REGION']);
		
		if (in_array($v['PRICE'], $s)) {
			
			continue;
			
		}
		
		$s[$k] = $v['PRICE'];

		$p[$key][$k] = ['PRICE' => $v['PRICE'], 'STRATUM_WEIGHT' => $v['STRATUM_WEIGHT'], 'STRATUM_TYPE' => $v['STRATUM_TYPE'], 'INDICATOR_BOX' => $v['INDICATOR_BOX'], 'PRICE_RELATIVE' => $v['PRICE_RELATIVE'], 'SHOP_TYPE' => $v['SHOP_TYPE'], 'SHOP_WEIGHT' => $v['SHOP_WEIGHT']];
		$p2 = ['ITEM_DESC' => $v['ITEM_DESC']];
		
	};
	

$resulting_array = $p2 + $p[$key];
$basket['SE']['PRODUCTS'][$key] = $resulting_array;
	
	
unset($p);
unset($p2);
unset($s);
unset($resulting_array);
};


$stmt3->closeCursor();

//SW QUERY

$stmt4->execute();
$items = $stmt4->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC);


foreach($items as $key => $value)	{

//ARRAYS
$p = [];
$s = [];
	

foreach($value as $k => $v)	{

		unset($v['ID']);
		unset($v['REGION']);
		
		if (in_array($v['PRICE'], $s)) {
			
			continue;
			
		}
		
		$s[$k] = $v['PRICE'];

		$p[$key][$k] = ['PRICE' => $v['PRICE'], 'STRATUM_WEIGHT' => $v['STRATUM_WEIGHT'], 'STRATUM_TYPE' => $v['STRATUM_TYPE'], 'INDICATOR_BOX' => $v['INDICATOR_BOX'], 'PRICE_RELATIVE' => $v['PRICE_RELATIVE'], 'SHOP_TYPE' => $v['SHOP_TYPE'], 'SHOP_WEIGHT' => $v['SHOP_WEIGHT']];
		$p2 = ['ITEM_DESC' => $v['ITEM_DESC']];
		
	};
	

$resulting_array = $p2 + $p[$key];
$basket['SW']['PRODUCTS'][$key] = $resulting_array;
	
	
unset($p);
unset($p2);
unset($s);
unset($resulting_array);
};


$stmt4->closeCursor();

//EA QUERY

$stmt5->execute();
$items = $stmt5->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC);


foreach($items as $key => $value)	{

//ARRAYS
$p = [];
$s = [];
	

foreach($value as $k => $v)	{

		unset($v['ID']);
		unset($v['REGION']);
		
		if (in_array($v['PRICE'], $s)) {
			
			continue;
			
		}
		
		$s[$k] = $v['PRICE'];

		$p[$key][$k] = ['PRICE' => $v['PRICE'], 'STRATUM_WEIGHT' => $v['STRATUM_WEIGHT'], 'STRATUM_TYPE' => $v['STRATUM_TYPE'], 'INDICATOR_BOX' => $v['INDICATOR_BOX'], 'PRICE_RELATIVE' => $v['PRICE_RELATIVE'], 'SHOP_TYPE' => $v['SHOP_TYPE'], 'SHOP_WEIGHT' => $v['SHOP_WEIGHT']];
		$p2 = ['ITEM_DESC' => $v['ITEM_DESC']];
		
	};
	

$resulting_array = $p2 + $p[$key];
$basket['EA']['PRODUCTS'][$key] = $resulting_array;
	
	
unset($p);
unset($p2);
unset($s);
unset($resulting_array);
};


$stmt5->closeCursor();


//EM QUERY

$stmt6->execute();
$items = $stmt6->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC);


foreach($items as $key => $value)	{

//ARRAYS
$p = [];
$s = [];
	

foreach($value as $k => $v)	{

		unset($v['ID']);
		unset($v['REGION']);
		
		if (in_array($v['PRICE'], $s)) {
			
			continue;
			
		}
		
		$s[$k] = $v['PRICE'];

		$p[$key][$k] = ['PRICE' => $v['PRICE'], 'STRATUM_WEIGHT' => $v['STRATUM_WEIGHT'], 'STRATUM_TYPE' => $v['STRATUM_TYPE'], 'INDICATOR_BOX' => $v['INDICATOR_BOX'], 'PRICE_RELATIVE' => $v['PRICE_RELATIVE'], 'SHOP_TYPE' => $v['SHOP_TYPE'], 'SHOP_WEIGHT' => $v['SHOP_WEIGHT']];
		$p2 = ['ITEM_DESC' => $v['ITEM_DESC']];
		
	};
	

$resulting_array = $p2 + $p[$key];
$basket['EM']['PRODUCTS'][$key] = $resulting_array;
	
	
unset($p);
unset($p2);
unset($s);
unset($resulting_array);
};


$stmt6->closeCursor();

//WM QUERY

$stmt7->execute();
$items = $stmt7->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC);


foreach($items as $key => $value)	{

//ARRAYS
$p = [];
$s = [];
	

foreach($value as $k => $v)	{

		unset($v['ID']);
		unset($v['REGION']);
		
		if (in_array($v['PRICE'], $s)) {
			
			continue;
			
		}
		
		$s[$k] = $v['PRICE'];

		$p[$key][$k] = ['PRICE' => $v['PRICE'], 'STRATUM_WEIGHT' => $v['STRATUM_WEIGHT'], 'STRATUM_TYPE' => $v['STRATUM_TYPE'], 'INDICATOR_BOX' => $v['INDICATOR_BOX'], 'PRICE_RELATIVE' => $v['PRICE_RELATIVE'], 'SHOP_TYPE' => $v['SHOP_TYPE'], 'SHOP_WEIGHT' => $v['SHOP_WEIGHT']];
		$p2 = ['ITEM_DESC' => $v['ITEM_DESC']];
		
	};
	

$resulting_array = $p2 + $p[$key];
$basket['WM']['PRODUCTS'][$key] = $resulting_array;
	
	
unset($p);
unset($p2);
unset($s);
unset($resulting_array);
};


$stmt7->closeCursor();

//YM QUERY

$stmt8->execute();
$items = $stmt8->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC);


foreach($items as $key => $value)	{

//ARRAYS
$p = [];
$s = [];
	

foreach($value as $k => $v)	{

		unset($v['ID']);
		unset($v['REGION']);
		
		if (in_array($v['PRICE'], $s)) {
			
			continue;
			
		}
		
		$s[$k] = $v['PRICE'];

		$p[$key][$k] = ['PRICE' => $v['PRICE'], 'STRATUM_WEIGHT' => $v['STRATUM_WEIGHT'], 'STRATUM_TYPE' => $v['STRATUM_TYPE'], 'INDICATOR_BOX' => $v['INDICATOR_BOX'], 'PRICE_RELATIVE' => $v['PRICE_RELATIVE'], 'SHOP_TYPE' => $v['SHOP_TYPE'], 'SHOP_WEIGHT' => $v['SHOP_WEIGHT']];
		$p2 = ['ITEM_DESC' => $v['ITEM_DESC']];
		
	};
	

$resulting_array = $p2 + $p[$key];
$basket['YM']['PRODUCTS'][$key] = $resulting_array;
	
	
unset($p);
unset($p2);
unset($s);
unset($resulting_array);
};


$stmt8->closeCursor();

//NW QUERY

$stmt9->execute();
$items = $stmt9->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC);

foreach($items as $key => $value)	{

//ARRAYS
$p = [];
$s = [];
	

foreach($value as $k => $v)	{

		unset($v['ID']);
		unset($v['REGION']);
		
		if (in_array($v['PRICE'], $s)) {
			
			continue;
			
		}
		
		$s[$k] = $v['PRICE'];

		$p[$key][$k] = ['PRICE' => $v['PRICE'], 'STRATUM_WEIGHT' => $v['STRATUM_WEIGHT'], 'STRATUM_TYPE' => $v['STRATUM_TYPE'], 'INDICATOR_BOX' => $v['INDICATOR_BOX'], 'PRICE_RELATIVE' => $v['PRICE_RELATIVE'], 'SHOP_TYPE' => $v['SHOP_TYPE'], 'SHOP_WEIGHT' => $v['SHOP_WEIGHT']];
		$p2 = ['ITEM_DESC' => $v['ITEM_DESC']];
		
	};
	

$resulting_array = $p2 + $p[$key];
$basket['NW']['PRODUCTS'][$key] = $resulting_array;
	
	
unset($p);
unset($p2);
unset($s);
unset($resulting_array);
};


$stmt9->closeCursor();

//NT QUERY

$stmt10->execute();
$items = $stmt10->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC);


foreach($items as $key => $value)	{

//ARRAYS
$p = [];
$s = [];
	

foreach($value as $k => $v)	{

		unset($v['ID']);
		unset($v['REGION']);
		
		if (in_array($v['PRICE'], $s)) {
			
			continue;
			
		}
		
		$s[$k] = $v['PRICE'];

		$p[$key][$k] = ['PRICE' => $v['PRICE'], 'STRATUM_WEIGHT' => $v['STRATUM_WEIGHT'], 'STRATUM_TYPE' => $v['STRATUM_TYPE'], 'INDICATOR_BOX' => $v['INDICATOR_BOX'], 'PRICE_RELATIVE' => $v['PRICE_RELATIVE'], 'SHOP_TYPE' => $v['SHOP_TYPE'], 'SHOP_WEIGHT' => $v['SHOP_WEIGHT']];
		$p2 = ['ITEM_DESC' => $v['ITEM_DESC']];
		
	};
	

$resulting_array = $p2 + $p[$key];
$basket['NT']['PRODUCTS'][$key] = $resulting_array;
	
	
unset($p);
unset($p2);
unset($s);
unset($resulting_array);
};


$stmt10->closeCursor();

//WL QUERY

$stmt11->execute();
$items = $stmt11->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC);


foreach($items as $key => $value)	{

//ARRAYS
$p = [];
$s = [];
	

foreach($value as $k => $v)	{

		unset($v['ID']);
		unset($v['REGION']);
		
		if (in_array($v['PRICE'], $s)) {
			
			continue;
			
		}
		
		$s[$k] = $v['PRICE'];

		$p[$key][$k] = ['PRICE' => $v['PRICE'], 'STRATUM_WEIGHT' => $v['STRATUM_WEIGHT'], 'STRATUM_TYPE' => $v['STRATUM_TYPE'], 'INDICATOR_BOX' => $v['INDICATOR_BOX'], 'PRICE_RELATIVE' => $v['PRICE_RELATIVE'], 'SHOP_TYPE' => $v['SHOP_TYPE'], 'SHOP_WEIGHT' => $v['SHOP_WEIGHT']];
		$p2 = ['ITEM_DESC' => $v['ITEM_DESC']];
		
	};
	

$resulting_array = $p2 + $p[$key];
$basket['WL']['PRODUCTS'][$key] = $resulting_array;
	
	
unset($p);
unset($p2);
unset($s);
unset($resulting_array);
};


$stmt11->closeCursor();

//SC QUERY

$stmt12->execute();
$items = $stmt12->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC);

foreach($items as $key => $value)	{

//ARRAYS
$p = [];
$s = [];
	

foreach($value as $k => $v)	{

		unset($v['ID']);
		unset($v['REGION']);
		
		if (in_array($v['PRICE'], $s)) {
			
			continue;
			
		}
		
		$s[$k] = $v['PRICE'];

		$p[$key][$k] = ['PRICE' => $v['PRICE'], 'STRATUM_WEIGHT' => $v['STRATUM_WEIGHT'], 'STRATUM_TYPE' => $v['STRATUM_TYPE'], 'INDICATOR_BOX' => $v['INDICATOR_BOX'], 'PRICE_RELATIVE' => $v['PRICE_RELATIVE'], 'SHOP_TYPE' => $v['SHOP_TYPE'], 'SHOP_WEIGHT' => $v['SHOP_WEIGHT']];
		$p2 = ['ITEM_DESC' => $v['ITEM_DESC']];
		
	};
	

$resulting_array = $p2 + $p[$key];
$basket['SC']['PRODUCTS'][$key] = $resulting_array;
	
	
unset($p);
unset($p2);
unset($s);
unset($resulting_array);
};

$stmt12->closeCursor();

//NI QUERY

$stmt13->execute();
$items = $stmt13->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC);


foreach($items as $key => $value)	{

//ARRAYS
$p = [];
$s = [];
	

foreach($value as $k => $v)	{

		unset($v['ID']);
		unset($v['REGION']);
		
		if (in_array($v['PRICE'], $s)) {
			
			continue;
			
		}
		
		$s[$k] = $v['PRICE'];

		$p[$key][$k] = ['PRICE' => $v['PRICE'], 'STRATUM_WEIGHT' => $v['STRATUM_WEIGHT'], 'STRATUM_TYPE' => $v['STRATUM_TYPE'], 'INDICATOR_BOX' => $v['INDICATOR_BOX'], 'PRICE_RELATIVE' => $v['PRICE_RELATIVE'], 'SHOP_TYPE' => $v['SHOP_TYPE'], 'SHOP_WEIGHT' => $v['SHOP_WEIGHT']];
		$p2 = ['ITEM_DESC' => $v['ITEM_DESC']];
		
	};
	

$resulting_array = $p2 + $p[$key];
$basket['NI']['PRODUCTS'][$key] = $resulting_array;

	
unset($p);
unset($p2);
unset($s);
unset($resulting_array);

};

$stmt13->closeCursor();


$db = null;


//TABLE

$table = [];

foreach ($basket as $row => $value) {
	
	$a[$row] = $value['VALUE'];
	

	
	
	
	if (!($a[$row] == $region)) {
	
	continue;
	
	}

	$table = $basket[$row]['PRODUCTS'];

break;

};

print_r($table);

}

catch (PDOexception $e) {
    echo "Error is: " . $e-> etmessage();
};

?>
</body>
</html>
