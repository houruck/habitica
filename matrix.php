<!DOCTYPE HTML>

<html lang="hu" xml:lang="hu">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="matrix.css">

<title>Habitica Eisenhower Matrix</title>
</head>

<?php

//Read task list
include('habitica.php');

//Habitica authentication
$x-api-user=""
$x-api-key="";

$habitica = new Habitica($x-api-user, $x-api-key);
$json = $habitica->get('user');
$array=json_decode($json,true);

$tagMapping = [
    //urgent - paste tag id here
        "" => 1,
    //important - paste tag id here
	"" => 2
];

$data = [
0 => [], //Delete	not important / not urgent
1 => [], //Delegate	not important / urgent
2 => [], //Decide	important     / not urgent
3 => []  //Do		important     / urgent
];

foreach ($array["data"] as $note) {
    $index = 0;
	foreach ($note["tags"] as $tag) {
	    $index += $tagMapping[$tag];
    }
    $data[$index][] = $note;
}

//How many tasks are in the category?
function taskList($category) {
    global $data;
    $count=count($data[$category]);
	//limit it
	if ($count > 5) {
	$count = 5;
	$etc="...";
	}

    for ($x = 0; $x < $count; $x++) {
        echo "<li>";
        echo $data[$category][$x]['text'];
        echo "</li>";
	}

    if (isset($etc)) {
	echo $etc;
    }

}
?>

<body>
<div id="box">
    <div class="card">
	<div id="do" class="label">Do</div>
	    <ul>
	    <?php taskList(3); ?>
	    </ul>
    </div>

    <div class="card">
	<div id="decide" class="label">Decide</div>
	    <ul>
	    <?php taskList(2); ?>
	    </ul>
    </div>

    <div class="card">
	<div id="delegate" class="label">Delegate</div>
	    <ul>
	    <?php taskList(1); ?>
	    </ul>
    </div>

    <div class="card">
	<div id="delete" class="label">Delete</div>
	    <ul>
	    <?php taskList(0); ?>
	    </ul>
    </div>
</div>

</body>
</html>