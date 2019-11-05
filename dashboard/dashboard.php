<?php 
	include_once("./../db.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1">
<title>Dashborad | Bunk Manager</title>
<link href="../assets/css/tailwind.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js" integrity="sha256-xKeoJ50pzbUGkpQxDYHD7o7hxe0LaOGeguUidbq6vis=" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
</head>
<body>
	<div class="flex flex-row mb-4">
	<?php
        $sql = "SELECT * FROM subject";
        $res = mysqli_query($db, $sql);


        $i = 1;
       	while ($row = mysqli_fetch_assoc($res)) 
       	{

       	
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
                                   "data": [<?php echo $row['attended']; ?>,<?php echo $row['bunked']; ?>, <?php echo $row['total_lecs']; ?>],
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

	  	  	var xmlhttp = new XMLHttpRequest();
		    xmlhttp.onreadystatechange = function() {
		        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
		        {
		            alert("Attendance updated succesfully!");
		        }
		    };
		    xmlhttp.open("GET", "update.php?id=" +id +"&attended=1" , true);
		    xmlhttp.send();

	  	});
	  	$("#bunked<?php echo $i; ?>").click(function(){
	  		c<?php echo $i; ?>.data.datasets[0].data[1]++;
	  	  	c<?php echo $i; ?>.data.datasets[0].data[2]--;
	  	  	c<?php echo $i; ?>.update();

	  	  	const id = "<?php echo $i ?>";

	  	  	var xmlhttp = new XMLHttpRequest();
		    xmlhttp.onreadystatechange = function() {
		        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) 
		        {
		            alert("Oops you bunked a lecture!");
		        }
		    };
		    xmlhttp.open("GET", "update.php?id=" +id +"&attended=0" , true);
		    xmlhttp.send();

	  	});
	  	</script>
	  </div>
	</div>
	<?php
		$i++;
	}
	?>
	</div>
	
	
</body>
</html>

<?php 

?>
