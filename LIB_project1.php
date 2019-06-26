<?php

    require_once("DBPDO.class.php");
    $db = new DB();

    /*
       Passes specific attributes to create a small banner head to the users liking  
    */
    function createHeader($text, $size="2em", $backColor="#003b64", $color="white"){
        echo '<div class = "header" style = "background-color:' .  "{$backColor}; color: 
        {$color};" . " font-size: {$size}" . '; ">' . "<p> $text </p>" . "</div>";
    }

    /*
      Checks that the productid was passed in from the buy button
      Calls the insertCart() function and passes in the POST values from the 
      buy button 
    */
    function insertC(){
        global $db; 
        if(isset($_POST['product_id']) && isset($_POST['quantity']) && isset($_POST['type'])) {
            // echo "IN THE FIRST FUNCTION CALL POST IS {$_POST['quantity']}<br/>";
            $db->insertCart($_POST['product_id'], $_POST['quantity'], "Cart", $_POST['type']);
            $_POST['quantity']="0";
        }
    }

    /*
        This method is called every time cart.php is loaded
        If the empty cart button is pressed it sets $_POST[clear] = true 
        and reloads the page. The delete Check then calls the deleteCart()
        and sets the $_POST[clear] = false
    */
    function deleteCheck(){
        global $db;
        if(isset($_POST['clear'])){
            if($_POST['clear']=="true"){
                $db->deleteCart();
                $_POST['clear'] = "false";
            }
        }
    }

    /*
        calls the deleteItem() function if productID is passed in from 
        the select that allows admins to delete an item    
    */
    function deleteSale(){
        global $db;
        if(isset($_POST['product_id'])){
            $db->deleteItem($_POST['product_id'],'Sale_Items');
        }
    }

    /*
        Loads the beginner displat for admin.php 
    */
    function displayAdmin(){
        $bigString = "";
        $bigString .= '<div class="form-group">'. 
                            '<form action="./cart.php" method="POST">' .
                                '<input name="clear" type="hidden" value="true" />  
                                <button class="add-button" type="submit">Empty Cart!</button>' .
                            '</form>'.
                        "</div >\n";          
    }

    /*
        Sets the $_GET[page]=1 if it isn't already set 
    */
    function pageNumCheck(){
        if(!isset($_GET['page'])){
            $_GET['page']=1;
        }
    }

    // function displayPageNum(){

    // }

    /*
       Checks all the values of that were passed in from the admin form
       Then calls the addItem function
    */
    function adminSanitizer(){
        global $db;
        var_dump($_POST);
        if(isset($_POST['name']) || isset($_POST['description']) || isset($_POST['price']) ||
        isset($_POST['quantity']) || isset($_POST['salesPrice']) || isset($_POST['password'])){
            $count = 0;

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
            // if(!isset($_POST['image'])){
            //     echo "<h2>An image is required for new items.</h2>";
            //     $count++;
            // }
            // if($_POST['password']!= "password"){
            //     echo "<h2>Invalid Password.</h2>";
            //     $count++;
            // }
            echo $count;

            if(isset($_POST['name']) && isset($_POST['description']) && isset($_POST['price']) &&
            isset($_POST['quantity']) && isset($_POST['salesPrice'])){
            
                //if($count == 0){
                    echo "<h2>DO YOU KNOW THE WAY?</h2>";
                    echo '<script language="javascript">';
                    echo 'alert("message successfully sent")';
                    echo '</script>';
                    $db->addItem($_POST['name'],$_POST['description'],$_POST['price'],$_POST['salesPrice'],$_POST['quantity'],$_POST['image']);
                //}
                // week6 fileUploadDOne
            }   
        }
    }


?>