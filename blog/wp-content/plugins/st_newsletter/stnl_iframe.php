<?php
require( '../../../wp-config.php' );

if(!isset($_GET['newsletter'])){
$nid = (int) $_GET['preview'];
}else{
$nid = (int) $_GET['newsletter'];
}
stnl_show_iframe($nid);
?>