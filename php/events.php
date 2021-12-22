<?php
session_start();
require_once 'db.php'; 

function redirect($url)
{
    $string = '<script type="text/javascript">';
    $string .= 'window.location = "' . $url . '"';
    $string .= '</script>';

    echo $string;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link href="/css/style.css" rel="stylesheet" type="text/css">
</head>
<body>
<div id="alisa">
	<div class="container">
		<ul class="nav justify-content-center mt-3" style="max-height: 50px;">
		    <a href="/index.php"><img id="ufc" src="images/logo.png"></a>
		</ul>
	</div>
	<hr>
	<div id='uno' class="container col-md-6 collapse mt-3 justify-content-center text-center">
	  	<li class="row d-inline-block col-sm-3 bg-light">
	       	<a id='qq' class="nav-link ff" href="/php/events.php">События</a>
	    </li>
	    <li class="row d-inline-block col-sm-3 ml-3 bg-light">
	        <a id='ee' class="nav-link ff" href="/php/fighters.php">Бойцы</a>
	    </li>
	    <li class="row d-inline-block col-sm-3 ml-3 bg-light">
	        <a id='ww' class="nav-link ff" href="/php/rates.php">Рейтинги</a>
	    </li>
	</div>
</div>
<?php
	$query ="SELECT eventID, event_photo, date, city,arena, ufc_format_event.nameFormat AS 'Format', nubmer FROM ufc_event INNER JOIN ufc_format_event ON ufc_event.type=ufc_format_event.idFormat ORDER BY eventID DESC";
	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
if($result)
{
	echo "<div id='events' class='container' style='height:100%;'>";
	while ($row = mysqli_fetch_array($result)) {
		echo "<div class='row ml-1'>";
			echo "<div class='card my-3' style='max-width: 1000px;'>";
				echo "<div class='row no-gutters'>";
				    echo "<div class='col-md-9 bg-dark'>";
				    	echo "<div class='flow'>";
					    	echo "<form action='/php/turnament.php' method='GET'><button class='hid btn btn-secondary collapse' name='event' value='".$row['eventID']."'>Подробнее</button></form>";
					      	echo "<img src='".$row['event_photo']."' class='card-img event_img'>";
				      	echo "</div>";
				    echo "</div>";
				    echo "<div class='col-md-3' style='font-family: Arnoldboecklin, fantasy;'>";
				      	echo "<div class='card-body text-white'style='background-color:#a8a8a8;'>";
				      		echo "<p class='card-text text-center' style='font-size:1.6em;'><b>".$row['Format']." ".$row['nubmer']."</b></p>";
				        	echo "<p class='card-text'><b>".$row['city']."</b></p>";
				        	echo "<p class='card-text'><b>".$row['arena']."</b></p>";
				        	echo "<p class='card-text invisible'><b>".$row['arena']."</b></p>";
				        	if ($row['Format']=="The Ultimate Fighter Finale" || $row['Format']=="UFC Fight Night") {$pad = "76";}
				        	else{ $pad = "114";}
				        	echo "<p class='card-title text-right m-0' style='padding-top:".$pad."px;'><b>".$row['date']."</b></p>";
				     	echo "</div>";
				    echo "</div>";
				echo "</div>";
			echo "</div>";
		echo "</div>";	
	}
	echo "</div>";
}
?>
<!------------------------------------Add panel-------------------------------------->
<?php 
if (isset($_POST['event'])) {
	$query="INSERT INTO `ufc_event`(`eventID`, `date`, `city`, `arena`, `type`, `nubmer`, `event_photo`) VALUES (NULL,'".$_POST['date']."','".$_POST['city']."','".$_POST['arena']."','".$_POST['type']."','".$_POST['number']."','".$_POST['image']."')";
	mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
	redirect("events.php");
}
?>
<div id='add' class='addStuff bg-success collapse <?php if ($_SESSION['adminNotAUsualUser'] != "admin") {echo "hide";} else {echo "show"; } ?> text-center justify-content-center rounded-circle pb-1 text-white'><p id="plus">+</p></div>
<div id='addEventField' class='addStuff bg-success collapse hide rounded pb-1 text-white'>
	<form method='POST'>
		<div class="form-group">
			<div class="custom-file col-sm-11 mt-3 ml-1">
				<label class="d-inline-block" for="type">Тип турнира:</label>
				<select class="row form-control col-sm-7 ml-1 bg-secondary text-light float-right" id="type" name="type">
					<?php 
						$query = "SELECT * FROM ufc_format_event";
						$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
						if($result)
						{
							while ($row = mysqli_fetch_array($result)) {
								echo "<option value='".$row['idFormat']."'>".$row['nameFormat']."</option>"." ";
							}
						}
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<div class="custom-file col-sm-11 ml-1">
				<span>Номер: </span>
				<input type="text" name="number" class="bg-secondary text-light float-right"/>
			</div>
		</div>
		<div class="form-group">
			<div class="custom-file col-sm-11 ml-1">
				<span>Город: </span>
				<input type="text" name="city" class="bg-secondary text-light float-right"/>
			</div>
		</div>
		<div class="form-group">
			<div class="custom-file col-sm-11 ml-1">
				<span>Арена: </span>
				<input type="text" name="arena" class="bg-secondary text-light float-right"/>
			</div>
		</div>
		<div class="form-group">
			<div class="custom-file col-sm-11 ml-1">
				<span>Дата проведения: </span>
				<input type="date" name="date" class="bg-secondary text-light float-right"/>
			</div>
		</div>
		<div class="form-group">
			<div class="custom-file col-sm-11 ml-1">
				<span>Картинка: </span>
				<input type="text" name="image" class="bg-secondary text-light float-right"/>
			</div>
		</div>
		<button id="droom" type="submit" class="btn btn-secondary mr-5 float-right" name='event'>Добавить новость</button>
	</form>
</div>
<!-------------------------------------------------------------------------->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script type="text/javascript">
$(document).ready(function(){
	$anim = $(".flow");
	$anim.mouseenter(function(e){
		$(this).children(':first').children(':first').collapse('show')
		$(this).children(':last').css('opacity','0.5');
	});
	$anim.mouseleave(function(e){
		$(this).children(':first').children(':first').collapse('hide')
		$(this).children(':last').css('opacity','1');
	});
});
</script>
<script type="text/javascript">
$(document).ready(function(){
	$("#ufc").mouseenter(function(){
		$("#uno").collapse('show');
	});
	$("#alisa").mouseleave(function(){
		$("#uno").collapse('hide');
	});
});
</script>
<script type="text/javascript">
$(document).ready(function(){
	$("#ee").mouseenter(function(){
		$("#ee").css('color','red');
	});
	$("#qq").mouseenter(function(){
		$("#qq").css('color','red');
	});
	$("#ww").mouseenter(function(){
		$("#ww").css('color','red');
	});
	$("#qq").mouseleave(function(){
		$("#qq").css('color','black');
	});
	$("#ee").mouseleave(function(){
		$("#ee").css('color','black');
	});
	$("#ww").mouseleave(function(){
		$("#ww").css('color','black');
	});
});
</script>
<script type="text/javascript">
$(document).ready(function(){
	$("#add").click(function(){
		$("#add").collapse('hide');
		$("#addEventField").collapse('show');
	});
	$("#droom").click(function(){
		$("#add").collapse('show');
		$("#addEventField").collapse('hide');
	});
});
</script>
</body>
</html>