<?php
    
    //connect with the database
    include("../../includes/config.php");
    
    //get search term
    $searchTerm = $_GET['term'];
    
    //get matched data from skills table
    if($searchTerm != '' || !isset($_GET['term'])){

        $explode_term = explode(",", $searchTerm);
        for($i = 0; $i < count($explode_term); $i++){
            $search = " WHERE client_name LIKE '%".$explode_term[$i]."%' OR address LIKE '%".$explode_term[$i]."%'";
        }
    }else{
        $search = "";
    }

    $query = "SELECT client_name, address FROM client".$search;
    $result = mysqli_query($db, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $client['name'][] = $row['client_name'];
        $client['address'][] = $row['address'];

        $data = array_merge($client['name'],$client['address']);
    }
    
    //return json data
    echo json_encode($data);
?>