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
if (isset($_GET['newsEdit'])) {
	$query = "SELECT event_iD FROM fight WHERE fightID='".$_GET['newsEdit']."'";
	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
	$eve = mysqli_fetch_row($result)[0];
} else {
	$eve = $_GET['event'];
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
<div class="container mt-5 justify-content-center  text-center ">
  	<li id="One" class="row d-inline-block col-md-4 text-light bg-secondary py-2">
   		<h5 class="red-col">Главный кард</h5>
    </li>
    <li id="Two" class="row d-inline-block col-md-4 ml-3 bg-secondary text-light py-2">
    	<h5 class="red-col">Предварительный</h5>
    </li>
    <li id="Three" class="row d-inline-block col-md-4 ml-3 bg-secondary text-light py-2">
    	<h5 class="red-col">Ранний предварительный</h5>
    </li>
</div>
<div class="container mt-3 collapse show justify-content-center text-center" id="MainCardCollapse">
	<?php
	$query ="SELECT fight.fightID AS 'id', fight.card AS 'Card', ufc_event.eventID AS 'Event', fight.fighter1_id AS 'Fighter1', fight.fighter2_id AS 'Fighter2', typeweight.typeofWeight AS 'Devision', w.name AS 'Winner', type_win.name AS 'Type' FROM fight INNER JOIN fighter w ON fight.winner_id=w.fighterID INNER JOIN typeweight ON fight.devision=typeweight.weightID INNER JOIN type_win ON fight.typeofWin=type_win.type_id INNER JOIN ufc_event ON fight.event_id=ufc_event.eventID WHERE `Card`='Главный' AND ufc_event.eventID='".$eve."'";
	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
	if($result)
	{
		while ($row = mysqli_fetch_array($result)) {
			$fighter1 ="SELECT name, surname, photo FROM fighter WHERE fighterID='".$row['Fighter1']."'";
			$resultf1 = mysqli_query($link, $fighter1) or die("Ошибка " . mysqli_error($link));
			$fighter2 ="SELECT name, surname, photo FROM fighter WHERE fighterID='".$row['Fighter2']."'";
			$resultf2 = mysqli_query($link, $fighter2) or die("Ошибка " . mysqli_error($link));
			$arr = [];
			$arr2 = [];
			$arr = mysqli_fetch_row($resultf1);
			$arr2 = mysqli_fetch_row($resultf2);
			echo "<div class='row d-inline-block col-sm-10 ml-1'>";
				echo "<div class='card mt-3'>";
					echo "<div class='row no-gutters' style='position:relative!important;'>";
						if ($_SESSION['adminNotAUsualUser'] == "admin") {
							echo "<form method='GET'><button id='pencilT' type='submit' name='newsEdit' class='justify-content-center text-center bg-success text-white' value='".$row['id']."'><i class='fa fa-pencil' aria-hidden='true'></i></button></form>";
						}
						if ($row['Type'] != 'Ожидается' && $row['Type'] != 'Отмена боя' && $row['Type'] != 'Техническая ничья' && $arr[0] == $row['Winner']) {
						    echo "<div class='col-md-2'>";
						      	echo "<img src='".$arr[2]."' class='card-img bg-success'>";
						    echo "</div>";
						} else {
							echo "<div class='col-md-2'>";
						      	echo "<img src='".$arr[2]."' class='card-img'>";
						    echo "</div>";
						}
					    echo "<div class='col-md-8'>";
					      	echo "<div class='card-body'>";
						      	if ($row['Type'] == 'Ожидается' || $row['Type'] == 'Отмена боя' || $row['Type'] == 'Техническая ничья') {
						      		echo "<div class='d-inline-block col-md-6 text-left'><p class='card-title' style='font-size:1.3em;'>".$arr[0]." ".$arr[1]."</p><hr></div>";
						        	echo "<div class='d-inline-block col-md-6 text-right'><p class='card-title' style='font-size:1.3em;'>".$arr2[0]." ".$arr2[1]."</p><hr></div>";
						        	echo "<p class='card-text text-center'><span style='color:#66696e; border-bottom: 1px solid grey; font-size:2.5em;'>VS</span></p>";
						        	echo "<p class='card-text'>".$row['Devision']."</p>";
						        	echo "<p class='card-text pt-1'>Результат: ".$row['Type']."</p>";
						      	} else {
					      			echo "<div class='d-inline-block col-md-6 text-left'><p class='card-title' style='font-size:1.3em;'>".$arr[0]." ".$arr[1]."</p><hr></div>";
					      			echo "<div class='d-inline-block col-md-6 text-right'><p class='card-title' style='font-size:1.3em;'>".$arr2[0]." ".$arr2[1]."</p><hr></div>";
						        	echo "<p class='card-text text-center'><span style='color:#66696e; border-bottom: 1px solid grey; font-size:2.5em;'>VS</span></p>";
						        	echo "<p class='card-text'>".$row['Devision']."</p>";
						        	echo "<p class='card-text pt-1'>Результат: ".$row['Type']."</p>";
						      	}
					     	echo "</div>";
					    echo "</div>";
					    if ($row['Type'] != 'Ожидается' && $row['Type'] != 'Отмена боя' && $row['Type'] != 'Техническая ничья' && $arr2[0] == $row['Winner']) {
						    echo "<div class='col-md-2'>";
						      	echo "<img src='".$arr2[2]."' class='card-img bg-success'>";
						    echo "</div>";
						} else {
							echo "<div class='col-md-2'>";
						      	echo "<img src='".$arr2[2]."' class='card-img '>";
						    echo "</div>";
						}
					echo "</div>";
				echo "</div>";
			echo "</div>";	
		}
	}
	?>
</div>

<div class="container mt-3 collapse hide justify-content-center text-center" id="RefilmCardCollapse">
	<?php
	$query ="SELECT fight.fightID AS 'id', fight.card AS 'Card', ufc_event.eventID AS 'Event', fight.fighter1_id AS 'Fighter1', fight.fighter2_id AS 'Fighter2', typeweight.typeofWeight AS 'Devision', w.name AS 'Winner', type_win.name AS 'Type' FROM fight INNER JOIN fighter w ON fight.winner_id=w.fighterID INNER JOIN typeweight ON fight.devision=typeweight.weightID INNER JOIN type_win ON fight.typeofWin=type_win.type_id INNER JOIN ufc_event ON fight.event_id=ufc_event.eventID WHERE `Card`='Предварительный' AND ufc_event.eventID='".$eve."'";
	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
	if($result)
	{
		while ($row = mysqli_fetch_array($result)) {
			$fighter1 ="SELECT name, surname, photo FROM fighter WHERE fighterID='".$row['Fighter1']."'";
			$resultf1 = mysqli_query($link, $fighter1) or die("Ошибка " . mysqli_error($link));
			$fighter2 ="SELECT name, surname, photo FROM fighter WHERE fighterID='".$row['Fighter2']."'";
			$resultf2 = mysqli_query($link, $fighter2) or die("Ошибка " . mysqli_error($link));
			$arr = [];
			$arr2 = [];
			$arr = mysqli_fetch_row($resultf1);
			$arr2 = mysqli_fetch_row($resultf2);
			echo "<div class='row d-inline-block col-sm-10 ml-1'>";
				echo "<div class='card mt-3'>";
					echo "<div class='row no-gutters' style='position:relative!important;'>";
						if ($_SESSION['adminNotAUsualUser'] == "admin") {
							echo "<form method='GET'><button id='pencilT' type='submit' name='newsEdit' class='justify-content-center text-center bg-success text-white' value='".$row['id']."'><i class='fa fa-pencil' aria-hidden='true'></i></button></form>";
						}
						if ($row['Type'] != 'Ожидается' && $row['Type'] != 'Отмена боя' && $row['Type'] != 'Техническая ничья' && $arr[0] == $row['Winner']) {
						    echo "<div class='col-md-2'>";
						      	echo "<img src='".$arr[2]."' class='card-img bg-success'>";
						    echo "</div>";
						} else {
							echo "<div class='col-md-2'>";
						      	echo "<img src='".$arr[2]."' class='card-img'>";
						    echo "</div>";
						}
					    echo "<div class='col-md-8'>";
					      	echo "<div class='card-body'>";
						      	if ($row['Type'] == 'Ожидается' || $row['Type'] == 'Отмена боя' || $row['Type'] == 'Техническая ничья') {
						      		echo "<div class='d-inline-block col-md-6 text-left'><p class='card-title' style='font-size:1.3em;'>".$arr[0]." ".$arr[1]."</p><hr></div>";
						        	echo "<div class='d-inline-block col-md-6 text-right'><p class='card-title' style='font-size:1.3em;'>".$arr2[0]." ".$arr2[1]."</p><hr></div>";
						        	echo "<p class='card-text text-center'><span style='color:#66696e; border-bottom: 1px solid grey; font-size:2.5em;'>VS</span></p>";
						        	echo "<p class='card-text'>".$row['Devision']."</p>";
						        	echo "<p class='card-text pt-1'>Результат: ".$row['Type']."</p>";
						      	} else {
					      			echo "<div class='d-inline-block col-md-6 text-left'><p class='card-title' style='font-size:1.3em;'>".$arr[0]." ".$arr[1]."</p><hr></div>";
					      			echo "<div class='d-inline-block col-md-6 text-right'><p class='card-title' style='font-size:1.3em;'>".$arr2[0]." ".$arr2[1]."</p><hr></div>";
						        	echo "<p class='card-text text-center'><span style='color:#66696e; border-bottom: 1px solid grey; font-size:2.5em;'>VS</span></p>";
						        	echo "<p class='card-text'>".$row['Devision']."</p>";
						        	echo "<p class='card-text pt-1'>Результат: ".$row['Type']."</p>";
						      	}
					     	echo "</div>";
					    echo "</div>";
					    if ($row['Type'] != 'Ожидается' && $row['Type'] != 'Отмена боя' && $row['Type'] != 'Техническая ничья' && $arr2[0] == $row['Winner']) {
						    echo "<div class='col-md-2'>";
						      	echo "<img src='".$arr2[2]."' class='card-img bg-success'>";
						    echo "</div>";
						} else {
							echo "<div class='col-md-2'>";
						      	echo "<img src='".$arr2[2]."' class='card-img '>";
						    echo "</div>";
						}
					echo "</div>";
				echo "</div>";
			echo "</div>";	
		}
	}
	?> 	
</div>

<div class="container mt-3 collapse hide justify-content-center text-center" id="EarlyRefilmCardCollapse">
	<?php
	$query ="SELECT fight.fightID AS 'id', fight.card AS 'Card', ufc_event.eventID AS 'Event', fight.fighter1_id AS 'Fighter1', fight.fighter2_id AS 'Fighter2', typeweight.typeofWeight AS 'Devision', w.name AS 'Winner', type_win.name AS 'Type' FROM fight INNER JOIN fighter w ON fight.winner_id=w.fighterID INNER JOIN typeweight ON fight.devision=typeweight.weightID INNER JOIN type_win ON fight.typeofWin=type_win.type_id INNER JOIN ufc_event ON fight.event_id=ufc_event.eventID WHERE `Card`='Ранний предварительный' AND ufc_event.eventID='".$eve."'";
	$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
	if($result)
	{
		while ($row = mysqli_fetch_array($result)) {
			$fighter1 ="SELECT name, surname, photo FROM fighter WHERE fighterID='".$row['Fighter1']."'";
			$resultf1 = mysqli_query($link, $fighter1) or die("Ошибка " . mysqli_error($link));
			$fighter2 ="SELECT name, surname, photo FROM fighter WHERE fighterID='".$row['Fighter2']."'";
			$resultf2 = mysqli_query($link, $fighter2) or die("Ошибка " . mysqli_error($link));
			$arr = [];
			$arr2 = [];
			$arr = mysqli_fetch_row($resultf1);
			$arr2 = mysqli_fetch_row($resultf2);
			echo "<div class='row d-inline-block col-sm-10 ml-1'>";
				echo "<div class='card mt-3'>";
					echo "<div class='row no-gutters' style='position:relative!important;'>";
						if ($_SESSION['adminNotAUsualUser'] == "admin") {
							echo "<form method='GET'><button id='pencilT' type='submit' name='newsEdit' class='justify-content-center text-center bg-success text-white' value='".$row['id']."'><i class='fa fa-pencil' aria-hidden='true'></i></button></form>";
						}
						if ($row['Type'] != 'Ожидается' && $row['Type'] != 'Отмена боя' && $row['Type'] != 'Техническая ничья' && $arr[0] == $row['Winner']) {
						    echo "<div class='col-md-2'>";
						      	echo "<img src='".$arr[2]."' class='card-img bg-success'>";
						    echo "</div>";
						} else {
							echo "<div class='col-md-2'>";
						      	echo "<img src='".$arr[2]."' class='card-img'>";
						    echo "</div>";
						}
					    echo "<div class='col-md-8'>";
					      	echo "<div class='card-body'>";
						      	if ($row['Type'] == 'Ожидается' || $row['Type'] == 'Отмена боя' || $row['Type'] == 'Техническая ничья') {
						      		echo "<div class='d-inline-block col-md-6 text-left'><p class='card-title' style='font-size:1.3em;'>".$arr[0]." ".$arr[1]."</p><hr></div>";
						        	echo "<div class='d-inline-block col-md-6 text-right'><p class='card-title' style='font-size:1.3em;'>".$arr2[0]." ".$arr2[1]."</p><hr></div>";
						        	echo "<p class='card-text text-center'><span style='color:#66696e; border-bottom: 1px solid grey; font-size:2.5em;'>VS</span></p>";
						        	echo "<p class='card-text'>".$row['Devision']."</p>";
						        	echo "<p class='card-text pt-1'>Результат: ".$row['Type']."</p>";
						      	} else {
					      			echo "<div class='d-inline-block col-md-6 text-left'><p class='card-title' style='font-size:1.3em;'>".$arr[0]." ".$arr[1]."</p><hr></div>";
					      			echo "<div class='d-inline-block col-md-6 text-right'><p class='card-title' style='font-size:1.3em;'>".$arr2[0]." ".$arr2[1]."</p><hr></div>";
						        	echo "<p class='card-text text-center'><span style='color:#66696e; border-bottom: 1px solid grey; font-size:2.5em;'>VS</span></p>";
						        	echo "<p class='card-text'>".$row['Devision']."</p>";
						        	echo "<p class='card-text pt-1'>Результат: ".$row['Type']."</p>";
						      	}
					     	echo "</div>";
					    echo "</div>";
					    if ($row['Type'] != 'Ожидается' && $row['Type'] != 'Отмена боя' && $row['Type'] != 'Техническая ничья' && $arr2[0] == $row['Winner']) {
						    echo "<div class='col-md-2'>";
						      	echo "<img src='".$arr2[2]."' class='card-img bg-success'>";
						    echo "</div>";
						} else {
							echo "<div class='col-md-2'>";
						      	echo "<img src='".$arr2[2]."' class='card-img '>";
						    echo "</div>";
						}
					echo "</div>";
				echo "</div>";
			echo "</div>";	
		}
	}
	?> 	
</div>
<!------------------------------------Add panel-------------------------------------->
<?php 
if (isset($_POST['add'])) {
	$query="INSERT INTO `fight`(`fightID`, `event_id`, `card`, `fighter1_id`, `fighter2_id`, `devision`, `winner_id`, `typeofWin`) VALUES(NULL,'".$eve."','".$_POST['card']."','".$_POST['fighter1']."','".$_POST['fighter2']."','".$_POST['weight']."','".$_POST['winner']."','".$_POST['win']."')";
	mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
	redirect("turnament.php?event=".$eve."");
}
?>
<!------------------------------------Edit panel-------------------------------------->
<?php 
if (isset($_POST['edit'])) {
	$query="UPDATE `fight` SET `event_id`='".$eve."',`card`='".$_POST['card']."',`fighter1_id`='".$_POST['fighter1']."',`fighter2_id`='".$_POST['fighter2']."',`devision`='".$_POST['weight']."',`winner_id`='".$_POST['winner']."',`typeofWin`='".$_POST['win']."' WHERE `fightID`='".$_GET['newsEdit']."'";
	mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link));
	redirect("turnament.php?event=".$eve."");
}
?>
<div id='add' class='addStuff bg-success collapse <?php if (isset($_GET['newsEdit']) || $_SESSION['adminNotAUsualUser'] != "admin") {echo "hide";} else {echo "show"; } ?> text-center justify-content-center rounded-circle pb-1 text-white'><p id="plus">+</p></div>
<div id='addTournamentField' class='addStuff bg-success collapse <?php if (isset($_GET['newsEdit'])) {echo "show";} else {echo "hide"; } ?> rounded pb-1 text-white'>
	<form method='POST'">
		<div class="form-group mt-3">
			<div class="custom-file col-sm-11 ml-1">
				<span>Кард: </span>
				<input type="text" name="card" class="bg-secondary text-light float-right"/>
			</div>
		</div>
		<div class="form-group">
			<div class="custom-file col-sm-11 ml-1">
				<label class="d-inline-block" for="fighter1">Первый боец:</label>
				<select class="row form-control col-sm-7 ml-1 bg-secondary text-light float-right" id="fighter1" name="fighter1">
					<?php 
						$query = "SELECT * FROM fighter";
						$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
						if($result)
						{
							while ($row = mysqli_fetch_array($result)) {
								echo "<option value='".$row['fighterID']."'>".$row['name']." ".$row['surname']."</option>"." ";
							}
						}
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<div class="custom-file col-sm-11 ml-1">
				<label class="d-inline-block" for="fighter2">Второй боец:</label>
				<select class="row form-control col-sm-7 ml-1 bg-secondary text-light float-right" id="fighter2" name="fighter2">
					<?php 
						$query = "SELECT * FROM fighter";
						$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
						if($result)
						{
							while ($row = mysqli_fetch_array($result)) {
								echo "<option value='".$row['fighterID']."'>".$row['name']." ".$row['surname']."</option>"." ";
							}
						}
					?>
				</select>
			</div>
		</div>
		<div class="form-group mt-3">
			<div class="custom-file col-sm-11 ml-1">
				<label class="d-inline-block" for="winner">Победитель:</label>
				<select class="row form-control col-sm-7 ml-1 bg-secondary text-light float-right" id="winner" name="winner">
					<?php 
						$query = "SELECT * FROM fighter";
						$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
						if($result)
						{
							while ($row = mysqli_fetch_array($result)) {
								echo "<option value='".$row['fighterID']."'>".$row['name']." ".$row['surname']."</option>"." ";
							}
						}
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<div class="custom-file col-sm-11 ml-1">
				<label class="d-inline-block" for="weight">Вес:</label>
				<select class="row form-control col-sm-7 ml-1 bg-secondary text-light float-right" id="weight" name="weight">
					<?php 
						$query = "SELECT * FROM typeweight";
						$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
						if($result)
						{
							while ($row = mysqli_fetch_array($result)) {
								echo "<option value='".$row['weightID']."'>".$row['typeofWeight']."</option>"." ";
							}
						}
					?>
				</select>
			</div>
		</div>
		<div class="form-group">
			<div class="custom-file col-sm-11 ml-1">
				<label class="d-inline-block" for="type">Результат:</label>
				<select class="row form-control col-sm-7 ml-1 bg-secondary text-light float-right" id="type" name="win">
					<?php 
						$query = "SELECT * FROM type_win";
						$result = mysqli_query($link, $query) or die("Ошибка " . mysqli_error($link)); 
						if($result)
						{
							while ($row = mysqli_fetch_array($result)) {
								echo "<option value='".$row['type_id']."'>".$row['name']."</option>"." ";
							}
						}
					?>
				</select>
			</div>
		</div>
		<button id="droom" type="submit" class="btn btn-secondary mr-5 float-right" name='<?php if (isset($_GET['newsEdit'])) {echo "edit";} else {echo "add"; } ?>'>
			<?php if (isset($_GET['newsEdit'])) {
				echo "Отредактировать бой";
			} else {
				echo "Добавить бой";
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
    $('#One').click(function(){
    	$('#MainCardCollapse').collapse('show');
        $('#RefilmCardCollapse').collapse('hide');
        $('#EarlyRefilmCardCollapse').collapse('hide');
    });
    $('#Two').click(function(){
    	$('#MainCardCollapse').collapse('hide');
        $('#RefilmCardCollapse').collapse('show');
        $('#EarlyRefilmCardCollapse').collapse('hide');
    });
    $('#Three').click(function(){
    	$('#MainCardCollapse').collapse('hide');
        $('#RefilmCardCollapse').collapse('hide');
        $('#EarlyRefilmCardCollapse').collapse('show');
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
		$("#addTournamentField").collapse('show');
	});
	$("#pencilT").click(function(){
		$("#add").collapse('hide');
		$("#addFightersField").collapse('show');
	});
	$("#droom").click(function(){
		$("#add").collapse('show');
		$("#addTournamentField").collapse('hide');
	});
});
</script>
</body>
</html>