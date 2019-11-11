<?php

    class DBController {

        private $hostname       =       "127.0.0.1";

        private $username       =       "root";

        private $password       =       "kotka";

        private $db             =       "geonames";

        // Creating connection

        public function connect() {
            $conn  =   new mysqli($this->hostname, $this->username, $this->password, $this->db)

            or die("Database connection error." . $conn->connect_error);

            return $conn;
        }

        // Closing connection

        public function close($conn) {

            $conn->close();
        }

    }
//<?php
//$conn = mysqli_connect("localhost", "root", "kotka", "geonames");

//if (isset($_POST["import"])) {

//    $fileName = $_FILES["file"]["tmp_name"];
//
//    if ($_FILES["file"]["size"] > 0) {
//
//        $file = fopen($fileName, "r");

////        while (($column = fgetcsv($file, 10000, ",")) !== FALSE) {
//            $sqlInsert = "SELECT * FROM  countryInfo";
//            $result = mysqli_query($conn, $sqlInsert);
//      print_r($result);
//      print_r(11111);
//            if (! empty($result)) {
//                $type = "success";
//                $message = "CSV Data Imported into the Database";
//            } else {
//                $type = "error";
//                $message = "Problem in Importing CSV Data";
//            }
//        }
//    }
//}