<?php

    require_once("DBPDO.class.php");

    $db = new DB();

    function createHeader($text, $size="3em", $backColor="#003b64", $color="white"){
        echo '<div class = "header" style = "background-color:' .  "{$backColor}; color: 
        {$color}" . '; ">' . "<p> $text </p>" . "</div>";
    }

    function insertC(){
        global $db; 
        if(isset($_POST['product_id']) && isset($_POST['quantity']) && isset($_POST['type'])) {
            // echo "IN THE FIRST FUNCTION CALL POST IS {$_POST['quantity']}<br/>";
            $db->insertCart($_POST['product_id'], $_POST['quantity'], "Cart", $_POST['type']);
            $_POST['quantity']="0";
        }else{
            echo "DO YOU KNOW THE WAY?";
        }
    }

    function deleteCheck(){
        global $db;
        if(isset($_POST['clear'])){
            if($_POST['clear']=="true"){
                $db->deleteCart();
                $_POST['clear'] = "false";
            }
        }
    }

    function deleteSale(){
        global $db;
        if(isset($_POST['product_id'])){
            $db->deleteItem($_POST['product_id'],'Sale_Items');
        }
    }

    function displayAdmin(){
        $bigString = "";
        $bigString .= '<div class="form-group">'. 
                            '<form action="./cart.php" method="POST">' .
                                '<input name="clear" type="hidden" value="true" />  
                                <button class="add-button" type="submit">Empty Cart!</button>' .
                            '</form>'.
                        "</div >\n";          
    }
    function pageNumCheck(){
        if(!isset($_GET['page'])){
            $_GET['page']=1;
        }
    }
    function displayPageNum(){

    }

    function adminSanitizer(){
        global $db;
        if(isset($_POST['name']) || isset($_POST['description']) || isset($_POST['price']) ||
        isset($_POST['quantity']) || isset($_POST['salesPrice']) || isset($_POST['iamge']) || isset($_POST['password'])){
            $count = 0;
            die("here");
            if(!ctype_alnum($_POST['name']) || !count($_POST['name'])>50){
                echo "<h2>Name is required, must be Alphanumeric and < 50 characters long.</h2>";
                $count++;
            }
            if(!ctype_alnum($_POST['description']) || !count($_POST['description'])>250){
                echo "<h2>Description is required, must be Alphanumeric with punctuation and < 250 characters long.</h2>";
                $count++;
            }
            if(!is_float($_POST['price']) || $_POST['price']<=0){
                echo "<h2>Price is required and must be a number > 0 with a max of 2 decimal places.</h2>";
                $count++;
            }
            if($_POST['quantity']<1){
                echo "<h2>Quantity is required and must be an integer > 0.</h2>";
                $count++;
            }
            if(!is_float($_POST['price']) || $_POST['price']<=0){
                echo "<h2>SalesPrice is required and must be a number > 0 with a max of 2 decimal places.</h2>";
                $count++;
            }
            if(!isset($_POST['image'])){
                echo "<h2>An image is required for new items.</h2>";
                $count++;
            }
            if($_POST['password']!= "password"){
                echo "<h2>Invalid Password.</h2>";
                $count++;
            }
            die($count);
            if($count == 0){
                echo "<h2>DO YOU KNOW THE WAY?</h2>";
                echo '<script language="javascript">';
                echo 'alert("message successfully sent")';
                echo '</script>';
                $db->addItem($_POST['name'],$_POST['description'],$_POST['price'],$_POST['salesPrice'],$_POST['quantity'],$_POST['image']);
            }
            // week6 fileUploadDOne
        }
    }


?>