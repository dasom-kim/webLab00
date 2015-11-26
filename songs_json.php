<?php
$SONGS_FILE = "songs_shuffled.txt"; //song.txt

if (!isset($_SERVER["REQUEST_METHOD"]) || $_SERVER["REQUEST_METHOD"] != "GET") {
	header("HTTP/1.1 400 Invalid Request");
	die("ERROR 400: Invalid request - This service accepts only GET requests.");
}

$top = "";

if (isset($_REQUEST["top"])) {
	$top = preg_replace("/[^0-9]*/", "", $_REQUEST["top"]);
}

if (!file_exists($SONGS_FILE)) {
	header("HTTP/1.1 500 Server Error");
	die("ERROR 500: Server error - Unable to read input file: $SONGS_FILE");
}

function array_sort($array, $type)
{
    $new_array = array();
    $array_ing = array();
	$set = 0;

    if (count($array) > 0) {
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $key2 => $value2) {
                    if ($key2 == $type) {
                        $array_ing[$key] = $value2;
                    }
                }
            }
        }

        asort($array_ing);

        foreach ($array_ing as $key => $value) {
            $new_array[$key] = $array[$key];
        }
        
       	foreach ($new_array as $key => $value) {
            $new_array2[$set] = $new_array[$k];
			$set = $set + 1;
        }
    }

    return $new_array2;
}

header("Content-type: application/json");

print "{\n  \"songs\": [\n";

// write a code to : 
// 1. read the "songs.txt" (or "songs_shuffled.txt" for extra mark!)
// 2. search all the songs that are under the given top rank 
// 3. generate the result in JSON data format 
$lines = file($SONGS_FILE);
$data = array();
for ($i = 0; $i < count($lines); $i++) {
	list($title, $artist, $rank, $genre, $time) = explode("|", trim($lines[$i]));	
	$data[$i] = array('rank'=>$rank, 'title'=>$title, 'artist'=>$artist, 'genre'=>$genre, 'time'=>$time);
}

$newdata = array_sort($data, 'rank');

for ($i = 0; $i < count($newdata); $i++) {
	if ($newdata[$i]['rank'] <= $top) {
			$jsondata = array('rank'=>$newdata[$i]['rank'], 'title'=>$newdata[$i]['title'], 'artist'=>$newdata[$i]['artist'], 'genre'=>$newdata[$i]['genre'], 'time'=>$newdata[$i]['time']);
			if ($top > $newdata[$i]['rank']) {
				$data2 = json_encode($jsondata).",\n";
			} else {
				$data2 = json_encode($jsondata)."\n";
			}
			print $data2;
	}
}

print "  ]\n}\n";

?>
