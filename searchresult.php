<?php
  session_start();
  $db = mysql_connect ("localhost","ou204","cs215bb");
  if(!$db)
  {
    exit ("Error - Could not connect to MySQL");
  }
  mysql_select_db("ou204",$db);
  
  $q = "select * from items order by item_id desc limit 10";
  $result = mysql_query($q,$db);
  
  if(isset($_POST["submitted"]))
  {  
 $type = $_POST["type"];
   $_SESSION["type"] = $type;
   header("location:http://www2.cs.uregina.ca/~xiong20h/Gp372/catergory.php");
   exit();
  }
?>

<?php
	If(isset($_POST["sub"]))
    {
	$item_id = htmlspecialchars($_POST["sub"]);

	$user_id = $_SESSION["uid"];

	$db = mysql_connect("localhost", "ou204", "cs215bb");
	  if (!$db) 
	  {
	    exit ("Error - Could not connect to MySQL");
	  }
	mysql_select_db("ou204", $db);
	$sql = "INSERT INTO cart (uid, iid) VALUES ($user_id, $item_id)";

	$result1 = mysql_query($sql,$db); 
	mysql_close($db);
     }
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" href="style.css" type="text/css"> 
<title>Bat</title>
</head>
<body>
<div class="container">

  <div class="header">
    <table width="100%">
    <tr>
      <td><a href="http://www2.cs.uregina.ca/~xiong20h/Gp372/index.php"><img class="batlogo" src="logo.jpg" alt="logo"/></a></td>
      <td width="80%" align="right">

        <?php
	 if(isset($_POST["Login"]))
          {
              $myusername=$_POST["username"]; 
              $mypassword=$_POST["password"];
              $db = mysql_connect("localhost","ou204","cs215bb");
              if(!$db)
              {
               die("Could not connect");
              
              }
              mysql_select_db("ou204",$db);

              $qa =  "select user_id,username FROM user WHERE username = '$myusername' and password = '$mypassword'";
              $resulta = mysql_query($qa,$db);
              $row8 = mysql_fetch_assoc($resulta);
              $_SESSION["uid"] = $row8["user_id"];

              $sql="SELECT user_id FROM user WHERE username='$myusername' and password='$mypassword'";
              $result=mysql_query($sql,$db);
              $row=mysql_fetch_array($result,MYSQL_ASSOC);
              $count=mysql_num_rows($result);

              if($count==1)
              {
                session_register("myusername");
                $_SESSION["login_user"]=$myusername; 
	echo "Welcome back!  " . $myusername . '<a href="http://www2.cs.uregina.ca/~xiong20h/Gp372/logout.php"> Log out</a>';
	header("Location: http://www2.cs.uregina.ca/~xiong20h/Gp372/index.php");
              }
              else 
              {
	 include('form.php');
	 header("Location: http://www2.cs.uregina.ca/~xiong20h/Gp372/index.php");
	     echo "Username or password is invalid!"; 
	     
              }
          } 
	 else if(isset($_SESSION["login_user"]))
	 {
	 echo "Welcome back!  " . $_SESSION["login_user"] . "  " 
	  . '<a href="http://www2.cs.uregina.ca/~xiong20h/Gp372/cart.php">Cart</a>' . "  " .
	  '<a href="http://www2.cs.uregina.ca/~xiong20h/Gp372/logout.php"> Log out</a>';
	 }
	 else
	 {
	 include('form.php');
	 }
	?>
      
      </td>
    </tr>
    </table>
  </div>
  
  <div class="menu">
  <table width="100%" align="center" id="roll">
  <tr>
    <form name="myform" action="searchresult.php" method="post">
   
    <input type = "hidden" name = "submitted" value = "1" />
    <input type = "submit" name="type" value = "Games" />
    <input type = "submit" name="type" value = "Books" />
    <input type = "submit" name="type"  value = "Computers" />
    <input type = "submit" name="type" value = "Cameras" />
    
    </form>
  </tr>
  </table>
  </div>
  
  <div class="content">
  <table style="width:100%">
    
    <?php
		
		$con = mysql_connect("localhost","ou204","cs215bb");
		if (!$con)
		{
			die('Could not connect: ' . mysql_error());
		}
		mysql_select_db("ou204", $con);
		echo "<h1>Results for <font color = 'blue' >". $_POST["search"] ." </font> </h1>";
		
	
		if(isset($_POST["query"]))
	{		
			if ( $_POST["search"] != NULL)
			{
			$search = $_POST["search"];
			$sql = "SELECT * FROM items WHERE name = '$search'";
			
			}
			else
			{
			$sql = "SELECT * FROM items";
				
			}
			$result = mysql_query($sql,$con);
			$i = 1;
			
			
			$row = mysql_fetch_array($result);
			
			
			while($row = mysql_fetch_array($result))
			//$row = mysql_fetch_array($result);
  			{
  				
  				if($i == 1 && $row['name'] == NULL)
  				{
  					echo "<p>Sorry, we couldn't find any results.</p>";
					echo "<p><font size=4>Search Tips</font></p>";
					echo "<ul>";
					echo "<li> Try using fewer or less specific keywords.</li>";
					echo "<li> Double check your spelling.</li>";
					echo "</ul>";
					break;
  				}
  				else
  				{
  		?>

	
	      <p>
	      <tr style="width:100%">
	      <td>
	       <a href = "http://www2.cs.uregina.ca/~ou204/cs372/item.php"></a>
	       
	       <img class = "profile" src = <?=$row["pic"]?> alt = "item picture" />
	       <?=$row["name"]?></a>
	       <td>
	       
	       $<?=$row["price"]?>
       </td>
       </td>
       <td style="text-align:right">
          <form method = "post" action = "index.php">
	     <input type = "hidden" name= "sub" value = "<?=$row["item_id"]?>" />
	     <input type = "submit" name = "add" value = "Add to Cart" />       
          </form>
       </td>
       </tr>
	       </p>
	       
	      
  		<?php 			  

  				}
  				$i = $i + 1;
			}

		mysql_close($con);
	}
	?>
		
	<br />
	<br />
     
  </table>
  </div>
  
  <hr>
  
  <div class="footer">
    Copyright @ 2014 Bat | All rights reserved.<br>
    This is a fictitious business website created for the purposes of a university Group Project.<br>
  </div>
  
</div>
</body>
</html>


