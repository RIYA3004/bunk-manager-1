<?php 
if(isset($_GET['id']) && isset($_GET['attended']) && !empty($_GET['id']))
{
    $userid = $_SESSION['userid'];
    $sid = $_GET['id'];
    include('../db.php');

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
else{

}
    mysqli_close($db);
?>