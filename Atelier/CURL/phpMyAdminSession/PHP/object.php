<?php
// Object instanciation
include("class/phpMyAdminSqlDump.class.php");

$PMASD = new phpMyAdminSqlDump();
$sqldata = $PMASD->getDump();
header("Content-Type: text/sql");
header('Content-Disposition: attachment; filename="data_'.date("Y_m_j").'.sql"');
echo $sqldata;
?>