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

            function getPeopleParameterized($id){
                try{
                    $data = array();
                    $stmt =
                        $this->dbh->prepare("SELECT * FROM Sale_Items WHERE ItemID = :id"); //the colon here is mandatory
                    $stmt->execute(array("id"=>$id));// can have colon or not it doesn't matter on this line
                    while($row = $stmt->fetch()){ //retrieves the next row. If you don't do nanything it returns it as an associative array
                        $data[] = $row;
                    }
                    return $data;
                }catch(PDOException $e){
                    echo $e->getMessage();
                    die();
                }
            }

            //not gonna bind the param?
            function getPeopleParameterizedAlt($id){
                try{
                    $data = array();
                    $stmt =
                        $this->dbh->prepare("SELECT * FROM Sale_Items WHERE ItemID = :id"); //the colon here is mandatory
                    //this way is slightly more effecient because we're tellign it the type and it doesn't have to do the conversion
                    $stmt->bindParam(":id",$id,PDO::PARAM_INT);
                    $stmt->execute();// can have colon or not it doesn't matter on this line
                    while($row = $stmt->fetch()){ //retrieves the next row. If you don't do nanything it returns it as an associative array
                        $data[] = $row;
                    }
                    return $data;
                }catch(PDOException $e){
                    echo $e->getMessage();
                    die();
                }
            }

            // changing the while loop
            function getPeopleParameterizedAlt2($id){
                try{
                    $data = array();
                    $stmt =
                        $this->dbh->prepare("SELECT * FROM Sale_Items WHERE ItemID = :id"); //the colon here is mandatory
                    //this way is slightly more effecient because we're tellign it the type and it doesn't have to do the conversion
                    $stmt->bindParam(":id",$id,PDO::PARAM_INT);
                    $stmt->setFetchMode(PDO::FETCH_ASSOC);
                    $stmt->execute();// can have colon or not it doesn't matter on this line

                    $data = $stmt->fetchAll();
                    return $data;

                }catch(PDOException $e){
                    echo $e->getMessage();
                    die();
                }
            }

            function getPeopleParameterizedAlt5($id){
                try{
                    // include "Item.class.php";

                    $data = array();

                    $stmt = $this->dbh->prepare("SELECT * FROM Sale_Items WHERE ItemID = :id");
                    $stmt->bindParam(":id",$id,PDO::PARAM_INT);
                    $stmt->execute();

                    $stmt->setFetchMode(PDO::FETCH_CLASS,"Item"); //makes ut si that when you do a getch you get a person object instead

                    while($person = $stmt->fetch()){
                        $data[] = $person;
                    }
                    return $data;
                }catch(PDOException $e){
                    echo $e->getMessage();
                    die();
                }
            }

            //can worry about insert function later

            function insert($last,$first,$nick){
                try{
                    $stmt = $this->dbh->prepare("INSERT INTO people
                        (LastName, FirstName, NickName) VALUES
                        (:lastName, :firstName, :nickName)");
                    $stmt->execute(array(
                        "lastName" => $last,
                        "firstName" => $first,
                        "nickName" => $nick
                    ));

                    return $this->dbh->lastInsertId();
                }catch(PDOException $e){
                    echo $e->getMessage();
                    die();
                }
            }







            

            










            
            /////////////////////////////////////////////////////////////////////////////////////////////
            /////////////////////////////////////////////////////////////////////////////////////////////


            function getAllPeopleAsTable($table_name){
                $data = $this->getAllObjects($table_name); //to call another metheod with a class stil lhave to use $this
                $bigString="";
                if(count($data)>0){
                    $bigString = "<table border = '1'>\n
                                    <tr><th>Name</th><th>Description</th><th>Sale Price</th>
                                        <th>Reg Price</th><th>Left in stock</th><th>image</th></tr>\n";
                    foreach($data as $row){
                        $bigString .= "<tr><td><a href='./index.phpid={$row->getItemID()}'>
                                        {$row->getName()}</a></td>
                                        <td>{$row->getDescription()}</td><td>{$row->getSalPrice()}</td>
                                        <td>{$row->getRegPrice()}</td><td>{$row->getQuantLeft()}</td>
                                        <td><img src = ./assets/images/{$row->getImgSrc()}></td></tr>\n";
                    }

                }else{
                    $bigString = "<h2>No items exist!</h2>";
                }
                return $bigString;
            }// get all people as table

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

            // limit is always gonna be 5 
            // if $_POST 
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
                                            <h4>{$row->getDescription()}</h4><h4>\${$row->getSalPrice()}</h4>
                                            <h4>\${$row->getRegPrice()}</h4><h4>{$row->getQuantLeft()}  Left in stock</h4>
                                        </div>\n" .
                                            '<span> Quantity: </span>'.
                                            '<select name="quantlist">
                                                <option value="1">1</option>
                                                <option value="2">2</option>
                                                <option value="3">3</option>
                                                <option value="4">4</option>'.
                                            '</select>'.

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

            // changing the while loop
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

            function deleteCart(){
                try{
                    $stmt = $this->dbh->prepare("TRUNCATE TABLE Cart");
                    $stmt->execute();
                }catch(PDOEXCEPTION $e){
                        echo $e->getMessage();
                        die();
                }
            }

            function insertCart($id,$quant,$table_name,$table_from){
                $data1 = $this->getItemCart($id);
                if(count($data1)>0 && $data1[0]->getQuantLeft() >0){ //&& quantityLeft > 0
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
                                    (ItemID, Name, Description, SalPrice, RegPrice, Quantity, ImgSrc) VALUES 
                                    (:ID, :NAME, :DESCRIPTION, :PRICE, :REGPRICE, :QUANTITY, :IMGSRC )");
                                $stmt->bindParam(":ID",$id,PDO::PARAM_INT);
                                $stmt->bindParam(":QUANTITY",$quant,PDO::PARAM_INT);
                                $stmt->execute(array(
                                    "ID" => $id,
                                    "NAME" => $row->getName(),
                                    "DESCRIPTION" => $row->getDescription(),
                                    "PRICE" => $row->getSalPrice(),
                                    "REGPRICE" => $row->getRegPrice(),
                                    "QUANTITY" => $quant,
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
            }

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

            

            

            /////////////////////////////////////////////////////////////////////////////////////////////
            /////////////////////////////////////////////////////////////////////////////////////////////

            









    }
