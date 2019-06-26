<?php

    class DB{
        
        private $dbh;

        function __construct(){
            try{
                $this->dbh =
                new PDO("mysql:host={$_SERVER['DB_Server']};dbname={$_SERVER['DB']}", 
                        $_SERVER['DB_USER'],$_SERVER['DB_PASSWORD']);
                $this->dbh->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $e){
                //terminate script or whatever
            }// construct
        }

        /*
            selects all objects from a given table
        */
        function getAllObjects($table_name){
            try{
                // include "Item.class.php";

                $data = array();

                $stmt = $this->dbh->prepare("SELECT * FROM $table_name");
                $stmt->execute();

                $stmt->setFetchMode(PDO::FETCH_CLASS,"Item"); //makes it so that when you do a getch you get a person object instead

                while($item = $stmt->fetch()){
                    $data[] = $item;
                }
                return $data;
            }catch(PDOException $e){
                echo $e->getMessage();
                die();
            }
        }

        /*
            limit is always gonna be 5 
            $pageNum is passed in via $_GET['page']
            This value is used in an offset equation that will 
            limit the user to seeing 5 items for a given page
        */
        function getFiveObjects($pageNum){
            try{
                // include "Item.class.php";
                $offset = ($pageNum-1)*5;
                $data = array();
                $stmt = $this->dbh->prepare("SELECT * FROM Catalog LIMIT :offset ,5");
                $stmt->bindParam(":offset",$offset,PDO::PARAM_INT);
                $stmt->setFetchMode(PDO::FETCH_CLASS,"Item");
                $stmt->execute();

                while($item = $stmt->fetch()){
                    $data[] = $item;
                }
                return $data;
            }catch(PDOException $e){
                echo $e->getMessage();
                die();
            }
        }

        /*
            Depending on which table name it calls getAllObjects or getFiveObjects 
            to cast a foreach loop on all the items that were returned. It dynamically 
            creates all view using the items from the database
        */
        function DisplayItems($table_name){
            if($table_name == "Catalog"){
                $data = $this->getFiveObjects($_GET['page']);
            }else{
                $data = $this->getAllObjects($table_name); 
            }
            $bigString="";
            if(count($data)>0){
                $bigString = "<div >\n<hr>\n";
                foreach($data as $row){
                    $bigString .= "<div >\n" . 
                                        "<a href='./index.php?id={$row->getItemID()}'> 
                                        <img src = ./assets/images/{$row->getImgSrc()} alt =" . '"' ."{$row->getName()}". '"' . "></a><br/>
                                        <a href='./index.php?id={$row->getItemID()}'>{$row->getName()}</a>
                                        <h4>{$row->getDescription()}</h4><h4>Sale Price: \${$row->getSalPrice()}</h4>
                                        <h4>Regular Price: \${$row->getRegPrice()}</h4><h4>{$row->getQuantLeft()}  Left in stock</h4>
                                    </div>\n" .
                                        '<span> Quantity: 1 </span>'.

                                    '<div class="form-group">'. 
                                        '<form action="./cart.php" method="POST">' .
                                            '<input name="quantity" type="hidden" value="1" />
                                            <input name="type" type="hidden" value= "'. "{$row->getType()}" . '"/>
                                            <input name="product_id" type="hidden" value= "'. "{$row->getItemID()}" . '"/> 
                                            <button class="add-button" type="submit">Add to Cart!</button>' .
                                        '</form>'.
                                    "</div><hr>\n";
                }
                $bigString .= "</div >\n";
            }else{
                $bigString = "<h2>No items exist!</h2>";
            }
            return $bigString;
        }// get all people as table


        /*
            Similar concept to DisplayItems(), however this one is specifically made 
            for the cart.
        */
        function DisplayItemsCart($table_name){
            $data = $this->getAllObjects($table_name); //to call another metheod with a class still have to use $this
            $bigString="";
            if(count($data)>0){
                $bigString = "<div >\n<hr>\n";
                foreach($data as $row){
                    $bigString .= "<div >\n" . 
                                        "<a href='./index.php?id={$row->getItemID()}'>{$row->getName()}</a>
                                        <h4>{$row->getDescription()}</h4><h4>\${$row->getSalPrice()}</h4>
                                        <h4>\${$row->getRegPrice()}</h4><h4>{$row->getQuantLeft()}  Left in stock</h4>
                                    </div>\n" .
                                        "<span> Quantity:{$row->getQuantity()} </span>".

                                    "<hr>\n";
                }
                $bigString .= '<div class="form-group">'. 
                                        '<form action="./cart.php" method="POST">' .
                                            '<input name="clear" type="hidden" value="true" />  
                                            <button class="add-button" type="submit">Empty Cart!</button>' .
                                        '</form>'.
                                    "</div></div >\n";
            }else{
                $bigString = "<h2>Your cart is empty!</h2>";
            }
            return $bigString;
        }// get all people as table

        /*
            Dynamically grabs all the items in the cart table and adds the sum 
            up for each of the quantites * the price. 
        */
        function calcCart($table_name){
            $data = $this->getAllObjects($table_name); //to call another metheod with a class still have to use $this
            $bigString="";
            $total = 0.00;
            if(count($data)>0){
                $bigString = "<div >\n<hr>\n";
                foreach($data as $row){
                    $total += ($row->getSalPrice()*$row->getQuantity());
                }
                $bigString .= "<h2>Total Cost: \${$total} </h2>";
            }
            return $bigString;
        }


        /*
            Gets a specific item as an item class and returns all the atrributes 
            that are held to that specific item.
        */
        function getItemParameterized($id,$table){
            try{
                $data = array();
                $stmt =
                    $this->dbh->prepare("SELECT * FROM $table WHERE ItemID = :id"); //the colon here is mandatory
                //this way is slightly more effecient because we're tellign it the type and it doesn't have to do the conversion
                $stmt->bindParam(":id",$id,PDO::PARAM_INT);
                $stmt->setFetchMode(PDO::FETCH_CLASS,"Item"); //makes it so that when you do a getch you get a person object instead
                $stmt->execute();// can have colon or not it doesn't matter on this line

                $data = $stmt->fetchAll();
                return $data;

            }catch(PDOException $e){
                echo $e->getMessage();
                die();
            }
        }

        /*
            Similar to getItemParameterized, however does it specifically for cart.
        */
        function getItemCart($id){
            try{
                $data = array();
                $stmt =
                    $this->dbh->prepare("SELECT * FROM Cart WHERE ItemID = :id"); //the colon here is mandatory
                //this way is slightly more effecient because we're tellign it the type and it doesn't have to do the conversion
                $stmt->bindParam(":id",$id,PDO::PARAM_INT);
                $stmt->setFetchMode(PDO::FETCH_CLASS,"Item"); //makes it so that when you do a getch you get a person object instead
                $stmt->execute();// can have colon or not it doesn't matter on this line

                $data = $stmt->fetchAll();
                return $data;

            }catch(PDOException $e){
                echo $e->getMessage();
                die();
            }
        }

        /*
            Deletes all the valies in the cart table
        */
        function deleteCart(){
            try{
                $stmt = $this->dbh->prepare("TRUNCATE TABLE Cart");
                $stmt->execute();
            }catch(PDOEXCEPTION $e){
                    echo $e->getMessage();
                    die();
            }
        }

        /*
            Checks the quantity of the item to see if there are any left in stock 
            Then checks to see if that item is already in the cart. If not it grabs the data
            from where the item originally was and passes it into the cart table as a new item.$_COOKIE
            If it's in the table I update the appropriate values for the quantities 
        */
        function insertCart($id,$quant,$table_name,$table_from){
            $data1 = $this->getItemCart($id);
            $data2 = $this->getItemParameterized($id,$table_from);
            if($data2[0]->getQuantLeft() >0){
                if(count($data1)>0){ //&& quantityLeft > 0
                    try{
                        $data = array();
                        $stmt = $this->dbh->prepare("UPDATE Cart SET quantity = quantity + :quant WHERE itemID = :id");
                        $stmt->bindParam(":id",$id,PDO::PARAM_INT);
                        $stmt->bindParam(":quant",$quant,PDO::PARAM_INT);
                        $stmt->execute();
                        $_POST['quantity']="0";
                        $stmt = $this->dbh->prepare("UPDATE $table_from SET QuantLeft = QuantLeft - :quant WHERE itemID = :id AND QuantLeft > 0");
                        $stmt->bindParam(":id",$id,PDO::PARAM_INT);
                        $stmt->bindParam(":quant",$quant,PDO::PARAM_INT);
                        $stmt->execute();
                    }catch(PDOEXCEPTION $e){
                        echo $e->getMessage();
                        die();
                    }
                }else{
                    try{
                        include_once('Item.class.php');
                        $data = $this->getItemParameterized($id,$table_from);
                        if(count($data>0)){
                            foreach($data as $row){
                                $stmt = $this->dbh->prepare("INSERT INTO Cart
                                    (ItemID, Name, Description, SalPrice, RegPrice, Quantity, QuantLeft, ImgSrc) VALUES 
                                    (:ID, :NAME, :DESCRIPTION, :PRICE, :REGPRICE, :QUANTITY, :LEFT, :IMGSRC )");
                                $stmt->bindParam(":ID",$id,PDO::PARAM_INT);
                                $stmt->bindParam(":QUANTITY",$quant,PDO::PARAM_INT);
                                $stmt->execute(array(
                                    "ID" => $id,
                                    "NAME" => $row->getName(),
                                    "DESCRIPTION" => $row->getDescription(),
                                    "PRICE" => $row->getSalPrice(),
                                    "REGPRICE" => $row->getRegPrice(),
                                    "QUANTITY" => $quant,
                                    "LEFT" => $row->getQuantLeft(),
                                    "IMGSRC" => $row->getImgSrc()
                                ));
                            }
                        }
                        $_POST['quantity']="0";
                        return $this->dbh->lastInsertId();
                    }catch(PDOEXCEPTION $e){
                        echo $e->getMessage();
                        die();
                    }
                }
            }else{
                echo '<script language="javascript">';
                echo 'alert("Sorry, this item is out of stock")';
                echo '</script>';
            }
        }

        /*
            provides the admins with a select of all the objects that are currently on sale
            also prints out a button that will pass the id and tablename into the deleteItem function
        */
        function saleSelect(){
            $data = $this->getAllObjects("Sale_Items"); //to call another metheod with a class still have to use $this
            $bigString="";
            if(count($data)>0){
                $bigString = "<div>\n<hr>\n" .
                            '<span> Choose an item to Remove: </span>'.
                                    '<select name="quantlist">';
                foreach($data as $row){
                    $bigString .= 
                                        "<option value={$row->getItemID()}> . {$row->getName()} </option>";
                                    
                }
                $bigString .= '</select>'.
                                '<div class="form-group">'. 
                                    '<form action="./admin.php" method="POST">' .
                                        '<input name="product_id" type="hidden" value= "'. "{$row->getItemID()}" . '"/> 
                                        <button class="add-button" type="submit">Remove</button>' .
                                    '</form>'.
                                "</div><hr>\n";
            }else{
                $bigString = "<h2>No items exist!</h2>";
            }
            return $bigString;
        }
        
        /*
            Delets the item based on the id and table name that was 
            passed in
        */
        function deleteItem($id,$table_name){
            $data = $this->getAllObjects($table_name); 
            $bigString="";
            if(count($data)>2){
                try{
                    $data = array();
                    $stmt = $this->dbh->prepare("DELETE FROM Sale_Items WHERE itemID = :id");
                    $stmt->bindParam(":id",$id,PDO::PARAM_INT);
                    $stmt->execute();
                }catch(PDOEXCEPTION $e){
                    echo $e->getMessage();
                    die();
                }
            }else{
                $bigString = "<h2>Too few items on sale!</h2>";
                return $bigString;
            }
        }

        /*
            supposed to be called and pass in the values from the post that 
            form in admin.php provides 
        */
        function addItem($name,$desc,$regPrice,$salPrice,$quant,$image){
            try{
                include_once('Item.class.php');
                $data = $this->getItemParameterized($id,$table_from);
                        $stmt = $this->dbh->prepare("INSERT INTO Catalog
                            (ItemID, Name, Description, SalPrice, RegPrice, Quantity, ImgSrc) VALUES 
                            ( :NAME, :DESCRIPTION, :PRICE, :REGPRICE, :QUANTITY, :IMGSRC )");
                            $stmt->bindParam(":REGPRICE",$regPrice,PDO::PARAM_INT);
                            $stmt->bindParam(":PRICE",$salPrice,PDO::PARAM_INT);
                            $stmt->bindParam(":QUANTITY",$quant,PDO::PARAM_INT);
                            $stmt->bindParam(":DESCRIPTION",$desc,PDO::PARAM_STR);
                            $stmt->bindParam(":NAME",$name,PDO::PARAM_STR);
                            $stmt->bindParam(":IMGSRC",$image,PDO::PARAM_STR);
                        $stmt->execute(array(
                            "NAME" => $name,
                            "DESCRIPTION" => $desc,
                            "PRICE" => $salPrice,
                            "REGPRICE" => $regPrice,
                            "QUANTITY" => $quant,
                            "IMGSRC" => $image
                        ));
                return $this->dbh->lastInsertId();
            }catch(PDOEXCEPTION $e){
                echo $e->getMessage();
                die();
            }
        }
        
        /*
            Used to check to sanitize and validate the input for the photo
            that was uploaded
        */
        function uploadPhoto(){
            $target_dir = "images/";
            $target_file = $target_dir . basename($_FILES["image"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
            // Check if file already exists
            if (file_exists($target_file)) {
                echo "File already exists.";
                return;
            }
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) {
                echo "Only JPG, JPEG, PNG & GIF files are allowed.";
                return;
            }if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
                echo "The file ". basename( $_FILES["image"]["name"]). " has been uploaded.";
            } else {
                echo "There was an error uploading your file.";
            }
        }

    }
