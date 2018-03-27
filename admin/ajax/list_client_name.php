<?php
    
    //connect with the database
    include("../../includes/config.php");
    
    //get search term
    $searchTerm = $_GET['term'];
    
    //get matched data from skills table
    if($searchTerm != '' || !isset($_GET['term'])){
        $search = " WHERE client_name LIKE '%".$searchTerm."%'";
    }else{
        $search = "";
    }

    $query = "SELECT client_name FROM client".$search;
    $result = mysqli_query($db, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row['client_name'];
    }
    
    //return json data
    echo json_encode($data);
?>