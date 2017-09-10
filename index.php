<?php
/**
 * Created by PhpStorm.
 * User: rusla
 * Date: 09.09.2017
 * Time: 23:38
 */

require "class/DbConnect.php";
$dbus=new DbConnect();
$bdempty=false;
$resultsearch=false;
if($_POST!=""&&isset($_POST)&&$_POST&&$_POST['searchval']!="")
{
    $allproduct = $dbus->Search($_POST['searchval']);
    if( empty ($allproduct))
        $resultsearch=true;
}else {
    $allproduct = $dbus->getAllCutomType('Product');
    if( empty ($allproduct))
        $bdempty=true;
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="assets/js/main.js"></script>
    <link   href="assets/css/bootstrap.min.css" rel="stylesheet">
    <link   href="assets/css/main.css" rel="stylesheet">
    <script src="assets/js/bootstrap.min.js"></script>
    <title>Document</title>
</head>
<body>
<div class="container">
    <div class="topbtn">
        <a  href='index.php'>Home</a>
        <a  href='addpage.php'>Add</a>
    </div>
    <form action="" method="post">
        <input type="text" name="searchval" placeholder="Search by Name">
        <input type="submit" name="submit" value="Search">
    </form>

    <div class="row">

            <?php
            if($resultsearch==true) {
                print '<h1> Nothing found</h1>';
            }
            if($bdempty==true) {
                print '<h1> Bd dont have product</h1>';
            }
            foreach ($allproduct as $row) {
                print"<div class='productwrap'>
                         <div class='firstinput'>
                             <p>Product type ".($dbus->GetCategoryname("Product_type",$row['product_type_id'])[0]['name'])." </p>
                             <p>Category ".($dbus->GetCategoryname("Category",$row['category_id'])[0]['name'])." </p>
                             <p>Name ".$row['name']." </p>
                           
                        </div>
                        <div class='descriptionwrap'>
                              <p>Discription ".$row['description']." </p>
                        </div>
                        <div class='imgwrap'>
                              <img src='$row[image]' alt=''>
                        </div>
                        <a  href='\updatepage.php?id=".$row['id']."'>Update</a>
                     </div>";
            }
            ?>
    </div>
</div> <!-- /container -->
</body>
</html>