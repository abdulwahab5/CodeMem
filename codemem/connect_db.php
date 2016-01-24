<?php

error_reporting (E_ALL ^ E_NOTICE ^ E_WARNING ^ E_DEPRECATED);
mysql_connect("localhost", "root","") or die(mysql_error());
mysql_select_db("codemem") or die(mysql_error());

?>