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

function array_sort($array, $on, $order=SORT_ASC)
{
    $new_array = array();
    $sortable_array = array();
	$set = 0;

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            }
        }

        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
            break;
            case SORT_DESC:
                arsort($sortable_array);
            break;
        }

        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
        
       	foreach ($new_array as $k => $v) {
            $new_array2[$set] = $new_array[$k];
			$set = $set + 1;
        }
    }

    return $new_array2;
}

header("Content-type: application/xml");

print "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
print "<songs>\n";


$lines = file($SONGS_FILE);
$data = array();
for ($i = 0; $i < count($lines); $i++) {
	list($title, $artist, $rank, $genre, $time) = explode("|", trim($lines[$i]));
	$data[$i] = array('rank'=>$rank, 'title'=>$title, 'artist'=>$artist, 'genre'=>$genre, 'time'=>$time);
}

$newdata = array_sort($data, 'rank', SORT_ASC);

for ($i = 0; $i < count($newdata); $i++) {
	if ($newdata[$i]['rank'] <= $top) {
		$rank = $newdata[$i]['rank'];
		$title = $newdata[$i]['title'];
		$artist = $newdata[$i]['artist'];
		$genre = $newdata[$i]['genre'];
		$time = $newdata[$i]['time'];
		print "\t<song rank=\"$rank\">\n";
		print "\t\t<title>$title</title>\n";
		print "\t\t<artist>$artist</artist>\n";
		print "\t\t<genre>$genre</genre>\n";
		print "\t\t<time>$time</time>\n";
		print "\t</song>\n";
	}
}

print "</songs>";

?>
