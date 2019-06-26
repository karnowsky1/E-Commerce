<?php

    class Item{
        private $ItemID;
        private $Name;
        private $Description;
        private $SalPrice;
        private $RegPrice;
        private $Quantity;
        private $QuantLeft;
        private $ImgSrc;
        private $Type;

        // function __construct($Name="TBD",$Description="TBD",$SalPrice="TBD",$RegPrice="TBD",$Quantity="TBD",$QuantLeft="TBD",$ImgSrc="TBD"){
        //     $this->Name = $Name;
        //     $this->Description = $Description;
        //     $this->SalPrice = $SalPrice;
        //     $this->RegPrice = $RegPrice;
        //     $this->Quantity = $Quantity;
        //     $this->QuantLeft = $QuantLeft;
        //     $this->ImgSrc = $ImgSrc;
        // }

        function getItemID(){
            return $this->ItemID;
        }

        function getName(){
            return $this->Name;
        }

        function getDescription(){
            return $this->Description;
        }

        function getSalPrice(){
            return $this->SalPrice;
        }

        function getRegPrice(){
            return $this->RegPrice;
        }

        function getQuantity(){
            return $this->Quantity;
        }

        function getQuantLeft(){
            return $this->QuantLeft;
        }

        function getImgSrc(){
            return $this->ImgSrc;
        }

        function getType(){
            return $this->Type;
        }



        function setName($name){
            $this->Name = $name;
        }

        function setDescription($desc){
            $this->Description = $desc;
        }

        function setSalPrice($sale){
            $this->SalPrice = $sale;
        }

        function setRegPrice($price){
            $this->RegPrice = $price;
        }

        function setQuantity($quant){
            $this->Quantity = $quant;
        }

        function setQuantLeft($quantleft){
            $this->QuantLeft = $quantleft;
        }

        function setImgSrc($src){
            $this->ImgSrc = $src;
        }

        function setType($type){
            $this->Type = $type;
        }

    }
