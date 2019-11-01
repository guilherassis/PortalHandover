<?php
$categories = array('Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec');
$impression = array(12, 25, 100, 58, 63, 30, 5, 40, 91, 10, 50, 36);
$click = array(6, 12, 40, 28, 31, 15, 2, 20, 45, 5, 25, 18);

$graph_data = array('categories'=>$categories, 'impression'=>$impression, 'clicks'=>$click);

echo json_encode($graph_data);
exit;
?>