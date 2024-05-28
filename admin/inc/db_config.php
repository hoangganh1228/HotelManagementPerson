<?php
    $hname = 'localhost';
    $unname = 'root';
    $pass = '';
    $db = 'hoangganh';

    $con = mysqli_connect($hname, $unname, $pass, $db);

    if(!$con) {
        die("Cannot Connect to Database".mysqli_connect_error());
    }

    function filteration($data) {
        foreach($data as $key => $value) {
            $value = trim($value);
            $value = stripslashes($value);
            $value= htmlspecialchars($value);
            $value = strip_tags($value);

            $data[$key] = $value;
        }
        return $data;
    }

    function selectAll($table) {
        $con = $GLOBALS['con'];
        $res = mysqli_query($con, "SELECT * FROM $table");
        return $res;
    }

    function select($sql, $values, $datatypes) {
        $con = $GLOBALS['con'];  //connect MySQL from global con variable
        if($stmt = mysqli_prepare($con, $sql)) { //prepare SQL statements executed, return an object called 
            mysqli_stmt_bind_param($stmt, $datatypes, ...$values); //bind values in SQL staements
            if(mysqli_stmt_execute($stmt)) { //execute SQL statement prepared
                $res = mysqli_stmt_get_result($stmt);
                mysqli_stmt_close($stmt);
                
                return $res;
            }
            else {
                mysqli_stmt_close($stmt);
                die("Query cannot be executed - Select");
            }
        } else {
            die("Query cannot be prepared - Select");
        }
    }

    function update($sql, $values, $datatypes) {
        $con = $GLOBALS['con'];  //connect MySQL from global con variable
        if($stmt = mysqli_prepare($con, $sql)) { //prepare SQL statements executed, return an object called 
            mysqli_stmt_bind_param($stmt, $datatypes, ...$values); //bind values in SQL staements
            if(mysqli_stmt_execute($stmt)) { //execute SQL statement prepared
                $res = mysqli_stmt_affected_rows($stmt);
                mysqli_stmt_close($stmt);
 
                return $res;
            }
            else {
                mysqli_stmt_close($stmt);
                die("Query cannot be executed - Update");
            }
        } else {
            die("Query cannot be prepared - Update");
        }
    }

    function insert($sql, $values, $datatypes) {
        $con = $GLOBALS['con'];  //connect MySQL from global con variable
        if($stmt = mysqli_prepare($con, $sql)) { //prepare SQL statements executed, return an object called 
            mysqli_stmt_bind_param($stmt, $datatypes, ...$values); //bind values in SQL staements
            if(mysqli_stmt_execute($stmt)) { //execute SQL statement prepared
                $res = mysqli_stmt_affected_rows($stmt);
                mysqli_stmt_close($stmt);
 
                return $res;
            }
            else {
                mysqli_stmt_close($stmt);
                die("Query cannot be executed - Insert");
            }
        } else {
            die("Query cannot be prepared - Insert");
        }
    }

    function delete($sql, $values, $datatypes) {
        $con = $GLOBALS['con'];  //connect MySQL from global con variable
        if($stmt = mysqli_prepare($con, $sql)) { //prepare SQL statements executed, return an object called 
            mysqli_stmt_bind_param($stmt, $datatypes, ...$values); //bind values in SQL staements
            if(mysqli_stmt_execute($stmt)) { //execute SQL statement prepared
                $res = mysqli_stmt_affected_rows($stmt);
                mysqli_stmt_close($stmt);
                return $res;
            }
            else {
                mysqli_stmt_close($stmt);
                die("Query cannot be executed - Delete");
            }
        } else {
            die("Query cannot be prepared - Delete");
        }
    }
?>