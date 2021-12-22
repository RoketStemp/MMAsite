<?php
session_start();
require_once 'php/db.php'; 

function redirect($url)
{
    $string = '<script type="text/javascript">';
    $string .= 'window.location = "' . $url . '"';
    $string .= '</script>';

    echo $string;
}
?>
<!DOCTYPE html>
<html lang="en" style='scrollbar-width: none;'>
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link href="/css/style.css" rel="stylesheet" type="text/css">
</head>
<body style="overflow-x: hidden;">
<div id="alisa">
	<div class="container">
		<ul class="nav justify-content-center mt-3" style="max-height: 50px;">
		    <a href="/index.php"><img id="ufc" src="php/images/logo.png"></a>
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
	$query="SELECT eventID,event_photo FROM ufc_event ORDER BY eventID DESC LIMIT 1";
	$result=mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
	$arr=[];
	$arr = mysqli_fetch_row($result);
	echo "<div class='row justify-content-center mt-3'>";
		echo "<div class='card bg-dark' style='width:70%!important;'>";
			echo "<div id='flow'>";
				echo "<form action='/php/turnament.php' method='GET'><button id='hide' class='btn btn-secondary collapse' name='event' value='".$arr[0]."'>Подробнее</button></form>";
	   			echo "<img id='event_img' src='".$arr[1]."' class='card-img' style='height:300px!important; '>";
   			echo "</div>";
		echo "</div>";
	echo "</div>";
?>
<?php
	$query ="SELECT * FROM news ORDER BY id_news DESC";
	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
if($result)
{
	echo "<div class='container'>";
	while ($row = mysqli_fetch_array($result)) {
		echo "<div class='row col-md-6 d-inline-block ml-1 my-3' style='position:relative!important;'>";
			if ($_SESSION['adminNotAUsualUser'] == "admin") {
				echo "<form method='GET'><button id='pencil' type='submit' name='newsEdit' class='justify-content-center text-center bg-success text-white' value='".$row['id_news']."'><i class='fa fa-pencil' aria-hidden='true'></i></button>";
				echo "<button id='delete' type='submit' name='delete' class='justify-content-center text-center bg-danger text-white' value='".$row['id_news']."'>X</button></form>";
			}
			echo "<div class='card bg-dark text-white'>";
	   			echo "<img id='event_img' src='".$row['photo_news']."' class='card-img'>";
			    echo "<div class='card-img-overlay'>";
				    echo "<h5 class='card-title'>".$row['headline']."</h5>";
			    echo "</div>";
			    echo "<div class='card-footer text-light' data-spy='scroll' style='height:120px!important;scrollbar-width: none;overflow-y: scroll; z-index:100;'>".$row['info']."</div>";
			echo "</div>";
		echo "</div>";	
	}
	echo "</div>";
}
?>
<!------------------------------------Edit panel-------------------------------------->
<?php 
if (isset($_POST['edit'])) {
	$query="UPDATE `news` SET `headline`='".$_POST['headline']."',`info`='".$_POST['info']."',`photo_news`='".$_POST['image']."' WHERE `id_news`='".$_GET['newsEdit']."'";
	mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
	redirect("index.php");
}
?>
<!------------------------------------Add panel-------------------------------------->
<?php 
if (isset($_POST['add'])) {
	$query="INSERT INTO news(`id_news`,`headline`,`info`,`photo_news`)VALUES(NULL,'".$_POST['headline']."','".$_POST['info']."','".$_POST['image']."')";
	mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
	redirect("index.php");
}
?>
<!------------------------------------Delete panel-------------------------------------->
<?php 
if (isset($_GET['delete'])) {
	$query="DELETE FROM news WHERE `id_news`='".$_GET['delete']."'";
	mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
	redirect("index.php");
}
?>

<div id='add' class='addStuff bg-success collapse <?php if (isset($_GET['newsEdit']) || $_SESSION['adminNotAUsualUser'] != "admin") {echo "hide";} else {echo "show"; } ?> text-center justify-content-center rounded-circle pb-1 text-white'><p id="plus">+</p></div>
<div id='addField' class='addStuff bg-success collapse <?php if (isset($_GET['newsEdit'])) {echo "show";} else {echo "hide"; } ?> rounded pb-1 text-white'>
	<form method='POST'>
		<div class="form-group mt-4">
			<div class="custom-file col-sm-11 ml-1">
				<span>Заголовок: </span>
				<input type="text" name="headline" class="bg-secondary text-light float-right"/>
			</div>
		</div>
		<div class="form-group">
			<div class="custom-file col-sm-11 ml-1">
				<span>Текст: </span>
				<input type="text" name="info" class="bg-secondary text-light float-right"/>
			</div>
		</div>
		<div class="form-group">
			<div class="custom-file col-sm-11 ml-1">
				<span>URL картинки: </span>
				<input type="text" name="image" class="bg-secondary text-light float-right"/>
			</div>
		</div>
		<button id="droom" type="submit" class="btn btn-secondary mr-5 float-right" name='<?php if (isset($_GET['newsEdit'])) {echo "edit";} else {echo "add"; } ?>'>
			<?php if (isset($_GET['newsEdit'])) {
				echo "Отредактировать новость";
			} else {
				echo "Добавить новость";
			} ?>
		</button>
	</form>
</div>
<!-------------------------------------------------------------------------->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

<script type="text/javascript">
$(document).ready(function(){
	$("#flow").mouseenter(function(){
		$("#hide").collapse('show');
		$("#event_img").css('opacity','0.5');
	});
	$("#flow").mouseleave(function(){
		$("#hide").collapse('hide');
		$("#event_img").css('opacity','1');
	});
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
		$("#addField").collapse('show');
	});
	$("#pencil").click(function(){
		$("#add").collapse('hide');
		$("#addField").collapse('show');
	});
	$("#droom").click(function(){
		$("#add").collapse('show');
		$("#addField").collapse('hide');
	});
});
</script>
</body>
</html>