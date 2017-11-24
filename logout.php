<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>log out</title>
</head>
<?php
session_start();
if(session_destroy())
{
header("Location: http://www2.cs.uregina.ca/~xiong20h/Gp372/index.php");
}
?>
<body>
</body>
</html>