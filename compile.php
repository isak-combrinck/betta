<?php
include ('../src/settings.php');
include ('src/compile.php');

ini_set('max_execution_time', 0);

c_compile();

ini_set('max_execution_time', 30);
?>