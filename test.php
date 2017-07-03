<?php

$date = strtotime('2017-06-23');
$date2 = strtotime('2017-06-28');

$dayofweek = date('w', $date2);
//$result    = date('w', strtotime($date)));

echo $dayofweek;
//echo ($date2 - $date)/ (60 * 60 * 24);

?>