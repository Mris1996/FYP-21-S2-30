<?php require_once("NavBar.php");
/*
for($x = 1;$x<50;$x++){

if($x<10){
	
$_SESSION['Object']->ListProduct('Product'.$x,'Home and Lifestyle','Sample Description',round(1000, 0),'Sample caption','/images/sample.jpg');
echo $x;
}
if($x>=10&&$x<20){
$_SESSION['Object']->ListProduct('Product'.$x,'Sports','Sample Description',round(1000, 0),'Sample caption','/images/sample.jpg');
}
if($x>=20&&$x<30){
$_SESSION['Object']->ListProduct('Product'.$x,'Music','Sample Description',round(1000, 0),'Sample caption','/images/sample.jpg');
}
if($x>=30&&$x<40){
$_SESSION['Object']->ListProduct('Product'.$x,'Clothing','Sample Description',round(1000, 0),'Sample caption','/images/sample.jpg');
}
if($x>=40&&$x<50){
$_SESSION['Object']->ListProduct('Product'.$x,'Electronics','Sample Description',round(1000, 0),'Sample caption','/images/sample.jpg');
}
}
*/



for($x=0;$x<1;$x++){
			$raw_data = file_get_contents('http://localhost:4000/getBalance');
			if($raw_data==null){
				$raw_data = file_get_contents('http://localhost:400'.$x.'/getBalance');
				$x=$x+1;
				echo $x;
			}
			
		}


?>