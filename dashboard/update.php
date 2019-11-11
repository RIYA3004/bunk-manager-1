<?php
session_start();

if(isset($_GET['id']) && isset($_GET['attended']) && !empty($_GET['id']))
{
    $userid = $_SESSION["userid"];
    $sid = $_GET['id'];
    include('../db.php');

    // First check whether attendance exists for the student
    $sql = "SELECT COUNT(*) as count FROM attendance WHERE uid = '$userid' AND sid = '$sid'";
    $result = mysqli_query($db, $sql);
    $data = mysqli_fetch_assoc($result);

    if ($data['count'] == 0) 
    {
        $sql = "INSERT INTO attendance (uid, sid) VALUES ('$userid', '$sid')";
        
        if (mysqli_query($db, $sql))
        {   
            echo "Record inserted successfully";
        } 
        else 
        {
            echo "Error inserting record: " . mysqli_error($db);
        } 
    } 
    else {
        // There exists a record for the student in attendance
        $attended = $_GET['attended'];

        if ($attended==1)
        {
            $update = "UPDATE attendance SET attended=attended+1 WHERE sid=";
            $update .= $sid;
            $update .= " AND uid=";
            $update .= $userid;
        }    
        else{
            $update = "UPDATE attendance SET bunked=bunked+1 WHERE sid=";
            $update .= $sid;
            $update .= " AND uid=";
            $update .= $userid;
        }
        if (mysqli_query($db, $update))
        {   
            echo "Record updated successfully";
        } 
        else 
        {
            echo "Error updating record: " . mysqli_error($db);
        } 
    }

    
}
?>