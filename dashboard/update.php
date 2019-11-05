<?php 
if(isset($_GET['id']) && isset($_GET['attended']) && !empty($_GET['id']))
{
    $id = $_GET['id'];
    include('../db.php');

    if ($attended==1)
        $update = "UPDATE subject SET attended=attended+1 WHERE sid = '".$id."'";
    else
        $update = "UPDATE subject SET bunked=bunked+1 WHERE sid = '".$id."'";

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