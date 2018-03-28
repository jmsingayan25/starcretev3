<?php
    
    //connect with the database
    include("../../includes/config.php");
    
    //get search term
    $searchTerm = $_GET['term'];
    
    //get matched data from skills table
    if($searchTerm != '' || !isset($_GET['term'])){
        $search = " WHERE item_no LIKE '%".$searchTerm."%'";
    }else{
        $search = "";
    }

    $query = "SELECT item_no FROM batch_list".$search;
    $result = mysqli_query($db, $query);
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = $row['item_no'];
    }
    
    //return json data
    echo json_encode($data);
?>