<?php
	session_start();
 
	// Check if the user is logged in, if not then redirect him to login page
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
	    header("location: ../registration/login.php");
	    exit;
	}
	
	include_once("./../db.php");


    $sql = "SELECT * FROM attendance WHERE uid =";
    $sql .= $_SESSION['userid'];
    $res = mysqli_query($db, $sql);

    $total_attended = 0;
    $total_bunked = 0;

    while($row = mysqli_fetch_assoc($res)){
        $sid = $row['sid'];
        $subsql = "SELECT sname FROM subjects WHERE sid =";
        $subsql .= $sid;
        $sname = mysqli_fetch_assoc(mysqli_query($db, $subsql))['sname'];
        $total_attended += $row['attended'];
        $total_bunked += $row['bunked'];
    }

    $attended = round(($total_attended * 100) / ($total_bunked + $total_attended), 2);
    $bunked = round(($total_bunked * 100) / ($total_bunked + $total_attended), 2);
?>
<html>
	<head>
		
		<title>Dashboard | Bunk Manager</title>
		
		<?php include_once '../includes/header.php'; ?>

		<script src="../assets/vendor/jquery-3.2.1.min.js"></script>
		<script src="../assets/js/jquery.min.js"></script>
		<script src="../assets/js/jquery.toast.min.js"></script>

		<script src="../assets/vendor/chartjs/Chart.bundle.min.js"></script>
	</head>
	<body class="animsition">
	    <div class="page-wrapper">

	    	<?php include_once '../includes/navbar-mobile.php'; ?>
	    	<?php include_once '../includes/sidebar.php'; ?>

	    	<div class="page-container">
	    		<?php include_once '../includes/navbar-desktop.php'; ?>
	    		<div class="main-content">
					
					<div class="attendance pt-5">
						<div class="row pl-5 pr-5">
							<div class="col-lg-6">
	                            <div class="au-card m-b-30">
	                                <div class="au-card-inner">
	                                    <h3 class="title-2 m-b-40">Attended: 
	                                    </h3>
	                                    <h2 class="number"><?php echo $attended; ?></h2>
	                                </div>
	                            </div>
	                        </div>
	                        <div class="col-lg-6">
	                            <div class="au-card m-b-30">
	                                <div class="au-card-inner">
	                                    <h3 class="title-2 m-b-40">Bunked: 
	                                    </h3>
	                                    <h2 class="number"><?php echo $bunked; ?></h2>
	                                </div>
	                            </div>
	                        </div>
						</div>	
					</div>

	                <div class="section__content section__content--p30">
	                    <div class="container-fluid">
	                    	<div class="row">
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

	                    		<div class="col-lg-6">
	                                <div class="au-card m-b-30">
	                                    <div class="au-card-inner">
	                                        <h3 class="title-2 m-b-40"><?php echo $row['sname']; ?></h3>
	                                        <canvas id="chart<?php echo $i; ?>" width="undefined" height="undefined"></canvas>
	                                    	<script>
	                   
						                       var c<?php echo $i; ?>= new Chart(document.getElementById("chart<?php echo $i; ?>"), {
													        type: 'doughnut',
													        data: {
													          datasets: [
													            {
													              label: "Stats",
													              data: [<?php echo $attended; ?>,<?php echo $bunked; ?>, <?php echo $row['total_lecs']?>-<?php echo ($bunked+$attended);?>],
													              backgroundColor: ["green", "red", "rgb(255, 205, 86)"],
													              hoverBackgroundColor: [
													                'green',
													                '#fa4251'
													              ],
													              borderWidth: [
													                0, 0
													              ],
													              hoverBorderColor: [
													                'transparent',
													                'transparent'
													              ]
													            }
													          ],
													          labels: ["Attended", "Bunked", "Available"],
													        },
													        options: {
													          maintainAspectRatio: false,
													          responsive: false,
													          cutoutPercentage: 55,
													          animation: {
													            animateScale: true,
													            animateRotate: true
													          },
													          legend: {
													            display: false
													          },
													          tooltips: {
													            titleFontFamily: "Poppins",
													            xPadding: 15,
													            yPadding: 10,
													            caretPadding: 0,
													            bodyFontSize: 16
													          }
													        }
													      });
						                    </script>
						                    <div class="buttons mt-4" style="display: flex; justify-content: space-around;">

						                    	<button id="bunked<?php echo $i; ?>" class="mt-4 btn btn-danger" style="flex: 1;">Bunked</button>
		    								
		    									<button id="attended<?php echo $i; ?>" class="mt-4 btn btn-success" style="flex: 1;">Attended</button>
	
						                    </div>
						                    
		    								<script>
											  	$("#attended<?php echo $i; ?>").click(function(){
											  	    c<?php echo $i; ?>.data.datasets[0].data[0]++;
											  	  	c<?php echo $i; ?>.data.datasets[0].data[2]--;
											  	  	c<?php echo $i; ?>.update();

											  	  	const id = "<?php echo $i ?>";

											  	  	$.get({
											            url: "update.php?id=" +id +"&attended=1",
											            success: function (data) {
											                $.toast({
															    heading: 'Success',
															    text: 'Attendance updated successfully',
															    icon: 'success',
															    position : 'bottom-right',
															    stack: 5
															});



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
											                $.toast({ 
																text : "Oops you bunked a lecture!", 
																heading: 'Error',
																icon: 'error',
																position : 'bottom-right',
																stack: 5
															});
											            },
											            error: function (error) {
											                console.log(error);
											            }
											        });
											  	});
											
											</script>
	                                    </div>
	                                </div>
	                            </div>
	                            <?php 
	                            		$i++;
									}
	                            ?>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </div>
	    </div>
	    <?php include_once '../includes/scripts.php'; ?>
	</body>
</html>
