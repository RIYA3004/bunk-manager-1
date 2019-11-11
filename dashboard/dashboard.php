<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../registration/login.php");
    exit;
}
?>
<?php 
	include_once("./../db.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Dashboard | Bunk Manager</title>
<link href="../assets/css/tailwind.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js" integrity="sha256-xKeoJ50pzbUGkpQxDYHD7o7hxe0LaOGeguUidbq6vis=" crossorigin="anonymous"></script>
<script src="../assets/js/jquery.min.js"></script>
</head>
<body>
	<nav class="flex items-center justify-between flex-wrap bg-teal-500 p-6">
  <div class="flex items-center flex-shrink-0 text-white mr-6">
    <span class="font-semibold text-xl tracking-tight">Bunk Manager (<?php 
      	$sql = "SELECT fname,lname FROM users WHERE id =";
      	$sql .= $_SESSION['userid'];
      	$name = mysqli_fetch_assoc(mysqli_query($db,$sql))['fname'];
		$name .= " ";
		  $name .= mysqli_fetch_assoc(mysqli_query($db,$sql))['lname'];
		echo $name;
      ?>)</span>
  </div>
  <div class="w-full block flex-grow lg:flex lg:items-center lg:w-auto">
    <div class="text-sm lg:flex-grow">

    </div>
    <div>
      <a href="../registration/logout.php" class="inline-block text-sm px-4 py-2 leading-none border rounded text-white border-white hover:border-transparent hover:text-teal-500 hover:bg-white mt-4 lg:mt-0">Logout</a>
    </div>
  </div>
</nav>
	<div class="flex flex-row mb-4">
	<?php
        $sql = "SELECT * FROM subjects";
        $res = mysqli_query($db, $sql);


        $i = 1;
       	while ($row = mysqli_fetch_assoc($res)) 
       	{
			   $subsql = "SELECT * FROM attendance WHERE uid=";
			   $subsql .= $_SESSION['userid'];
			   $subsql .= " AND sid=";
			   $subsql .= $row['sid'];

			   $attended = mysqli_fetch_assoc(mysqli_query($db,$subsql))['attended'];
			   $bunked = mysqli_fetch_assoc(mysqli_query($db,$subsql))['bunked'];

       	
     ?>
	<div class="w-1/3 rounded-lg bg-gray-500 overflow-hidden shadow-lg m-3">
	  <div class="px-6 py-4">
	    <div class="font-bold text-xl mb-2 text-center"><?php echo $row['sname']; ?></div>
	    <div class="font-bold text-xl mb-2 text-center"><?php echo $row['total_lecs']; ?></div>
	    <div>
	    	<div class="p-5">
	    	<canvas id="chartjs-4<?php echo $i; ?>" class="chartjs" width="undefined" height="undefined"></canvas>
                   <script>
                       var c<?php echo $i; ?> = new Chart(document.getElementById("chartjs-4<?php echo $i; ?>"), {
                           "type": "doughnut",
                           "data": {
                               "labels": ["Attended", "Bunked", "Available"],
                               "datasets": [{
                                   "label": "Stats",
                                   "data": [<?php echo $attended; ?>,<?php echo $bunked; ?>, <?php echo $row['total_lecs']; ?>],
                                   "backgroundColor": ["green", "red", "rgb(255, 205, 86)"]
                               }]
                           }
                       });
                   </script>
             </div>
	    </div>
	  </div>
	  <div class="px-6 py-4 flex">
	    <button id="bunked<?php echo $i; ?>" class="w-1/2 bg-red-600 rounded-full px-8 py-2 text-lg font-semibold text-gray-100 mr-2">Bunked</span>
	    <button id="attended<?php echo $i; ?>" class="w-1/2 bg-green-600 rounded-full px-8 py-2 text-lg font-semibold text-gray-100 mr-2">Attended</span>
	  	<script>
	  	$("#attended<?php echo $i; ?>").click(function(){
	  	    c<?php echo $i; ?>.data.datasets[0].data[0]++;
	  	  	c<?php echo $i; ?>.data.datasets[0].data[2]--;
	  	  	c<?php echo $i; ?>.update();

	  	  	const id = "<?php echo $i ?>";

	  	  	$.get({
	            url: "update.php?id=" +id +"&attended=1",
	            success: function (data) {
	                alert("Attendance updated succesfully!");
	            },
	            error: function (error) {
	                console.log(error);
	            }
	        });
	  	});

	  	$("#bunked<?php echo $i; ?>").click(function(){
	  		c<?php echo $i; ?>.data.datasets[0].data[1]++;
	  	  	c<?php echo $i; ?>.data.datasets[0].data[2]--;
	  	  	c<?php echo $i; ?>.update();

	  	  	const id = "<?php echo $i ?>";

	  	  	$.get({
	            url: "update.php?id=" +id +"&attended=0",
	            success: function (data) {
	                alert("Oops you bunked a lecture!");
	            },
	            error: function (error) {
	                console.log(error);
	            }
	        });
	  	});

	  	</script>
	  </div>
	</div>
	<?php
		$i++;
	}

	// echo "<pre>";
	// print_r($_SESSION);
	// echo "</pre>";
	?>
	</div>
	
	
</body>
</html>

<?php 

?>
