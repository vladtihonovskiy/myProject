<?php
/**
 * Created by PhpStorm.
 * User: rusla
 * Date: 31.08.2017
 * Time: 19:48
 */
require "class/DbConnect.php";
$product_type_new=0;
$Category_new=0;
$dbus=new DbConnect();
$id = null;
if ( !empty($_GET['id'])) {
    $id = $_REQUEST['id'];
}
if ( null==$id ) {
    header("Location: index.php");
}
if($_POST!=""&&isset($_POST)&&$_POST) {
    if (isset($_POST['product_type_new']) && isset($_POST['product_type_new']) && $_POST['product_type_new'] != null) {
        $product_type_new = ($dbus->Setcategory("Product_type", $_POST['product_type_new']));
    }
    if (isset($_POST['Category_new']) && $_POST['Category_new'] != null) {
        $Category_new = ($dbus->Setcategory("Category", $_POST['Category_new']));
    }
    if ($Category_new != 0 && $product_type_new != 0) {
        $dbus->Updatevalue($product_type_new, $Category_new, $_POST["product_name"], $_POST["product_discription"], $_POST["img_url"],$id);
        header('Location: successpage.php');
    } else {
        if ($Category_new != 0 && $product_type_new == 0) {
            $dbus->Updatevalue($_POST['Product_Type'], $Category_new, $_POST["product_name"], $_POST["product_discription"], $_POST["img_url"],$id);
            header('Location: successpage.php');
        }
        if ($Category_new == 0 && $product_type_new != 0) {
            $dbus->Updatevalue($product_type_new, $_POST["Category"], $_POST["product_name"], $_POST["product_discription"], $_POST["img_url"],$id);
            header('Location: successpage.php');
        }
    }
    if ($Category_new == 0 && $product_type_new == 0) {
        $dbus->Updatevalue($_POST['Product_Type'], $_POST["Category"], $_POST["product_name"], $_POST["product_discription"], $_POST["img_url"],$id);
        header('Location: successpage.php');
    }
}
$reuquestmas=$dbus->GetRequestbyid($id)[0];
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
    <link   href="assets/css/main.css" rel="stylesheet">
    <link   href="assets/css/bootstrap.min.css" rel="stylesheet">
    <script src="assets/js/bootstrap.min.js"></script>
    <title>Document</title>
</head>
<body>
<div class="container">
    <div class="topbtn">
        <a  href='index.php'>Home</a>
        <a  href='addpage.php'>Add</a>
    </div>
<form id="inputaddform"  method="post">
    <div>
        <?php if (!empty($Error)): ?>
            <span class="help-inline"><?php echo "All поля должны быть заполненны ";?></span>
        <?php endif; ?>
        <select id="Product_Type" name="Product_Type">
            <option   disabled value="Product_Type">Product_Type</option>
            <?php
            foreach ($dbus->getAllCutomType("Product_type") as $Product_type) {
                if($Product_type['id']==$reuquestmas['product_type_id']) {
                    print "<option selected value='$Product_type[id]'>$Product_type[name]</option>";
                }else
                {
                    print "<option  value='$Product_type[id]'>$Product_type[name]</option>";
                }
            }
            ?>
            <option value="Add_new_poduct">Add new poduct</option>
        </select>
        <input type="text" style="display:none" id="product_type_new" name="product_type_new" placeholder="product_type_new" value="">
        <select id="Category" name="Category" >
            <option  disabled value="Сategory">Category</option>
            <?php
            foreach ($dbus->getAllCutomType("Category") as $category) {
                if($category['id']==$reuquestmas['category_id']) {
                    print "<option selected value='$category[id]'>$category[name]</option>";
                }else
                {
                    print "<option value='$category[id]'>$category[name]</option>";
                }
            }
            ?>
            <option value="Add_new_category">Add new category</option>
        </select>
        <input type="text" style="display:none" id="Category_new" name="Category_new" placeholder="Category_new" value="">
        <input type="text" id="product_name" name="product_name" placeholder="Product Name" value="<?=$reuquestmas['name']?>">
        <input type="text" id="product_discription" name="product_discription" placeholder="Product Discription" value="<?=$reuquestmas['description']?>">
        <input type="text" id="Img_url" name="img_url" placeholder="Img Url" value="<?=$reuquestmas['image']?>">
        <button type="submit" id="register" disabled="disabled">Update</button>
    </div>
</form>
</div>
</body>
</html>


