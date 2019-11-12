<?php
    include_once '../db.php';
    $uid = ($_REQUEST['user']);

    $sql = "SELECT * FROM users WHERE id = '$uid'";
    $res = mysqli_query($db, $sql);


    $email = $username = "";

    while($row = mysqli_fetch_assoc($res)) {
        $email = $row['email'];
        $username .= $row['fname']." ".$row['lname'];
    }

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin | Bunk Manager</title>
    <meta name="author" content="name">
    <meta name="description" content="description here">
    <meta name="keywords" content="keywords,here">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css">
    <link href="https://unpkg.com/tailwindcss/dist/tailwind.min.css" rel="stylesheet"> <!--Replace with your tailwind.css once created-->
    <link href="https://afeld.github.io/emoji-css/emoji.css" rel="stylesheet"> <!--Totally optional :) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.bundle.min.js" integrity="sha256-xKeoJ50pzbUGkpQxDYHD7o7hxe0LaOGeguUidbq6vis=" crossorigin="anonymous"></script>

</head>

<body class="bg-gray-900 font-sans leading-normal tracking-normal mt-12">


    <div class="flex flex-col md:flex-row">

        <div class="bg-gray-900 shadow-lg h-16 fixed bottom-0 mt-12 md:relative md:h-screen z-10 w-full md:w-48">

            <div class="md:mt-12 md:w-48 md:fixed md:left-0 md:top-0 content-center md:content-start text-left justify-between">
                <ul class="list-reset flex flex-row md:flex-col py-0 md:py-3 px-1 md:px-2 text-center md:text-left">
                   
                    <li class="mr-3 flex-1">
                        <a href="admin-dashboard.php" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-pink-500">
                            <i class="fas fa-tasks pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-600 md:text-gray-400 block md:inline-block">Bunk Manager</span>
                        </a>
                    </li>
                    <li class="mr-3 flex-1">
                        <a href="users-dashboard.php" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-blue-600">
                            <i class="fas fa-chart-area pr-0 md:pr-3 text-blue-600"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-white md:text-white block md:inline-block">Users</span>
                        </a>
                    </li>
                    <li class="mr-3 flex-1">
                        <a href="subjects-dashboard.php" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-pink-500">
                            <i class="fas fa-tasks pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-600 md:text-gray-400 block md:inline-block">Subjects</span>
                        </a>
                    </li>
                   <li class="mr-3 flex-1">
                        <a href="../registration/logout.php" class="block py-1 md:py-3 pl-1 align-middle text-white no-underline hover:text-white border-b-2 border-gray-800 hover:border-pink-500">
                            <i class="fas  fa-sign-out-alt pr-0 md:pr-3"></i><span class="pb-1 md:pb-0 text-xs md:text-base text-gray-600 md:text-gray-400 block md:inline-block">Log Out</span>
                        </a>
                    </li>
                </ul>
            </div>


        </div>

        <div class="main-content flex-1 bg-gray-100 mt-12 md:mt-2 pb-24 md:pb-5">

             <div class="flex flex-wrap">
                <div class="w-full md xl p-3">
                    <!--Metric Card-->
                    <div class="bg-yellow-100 border-b-4 border-yellow-600 rounded-lg shadow-lg p-5">
                        <div class="flex flex-row items-center">
                            <div class="flex-shrink pr-4">
                                <div class="rounded-full p-5 bg-yellow-600"><i class="fas fa-users fa-2x fa-inverse"></i></div>
                            </div>
                            <div class="flex-1 text-right md:text-center">
                                <?php
                                        $sql = "SELECT fname,lname FROM users WHERE id =";
                                        $sql .= $uid;
                                        $fname = mysqli_fetch_assoc(mysqli_query($db, $sql))['fname'];
                                        $lname = mysqli_fetch_assoc(mysqli_query($db, $sql))['lname'];
                                    ?>
                                <h3 class="font-bold text-3xl">
                                    <?php echo $fname; ?> <?php echo $lname; ?> 
                                    <span class="text-yellow-600"></span></h3>
                            </div>
                        </div>
                    </div>
                    <!--/Metric Card-->
                </div>
            </div>

            <div class="flex flex-row flex-wrap flex-grow mt-2">
                <?php 
                    $sql = "SELECT * FROM attendance WHERE uid =";
                    $sql .= $uid;
                    $res = mysqli_query($db, $sql);
                    

                   // while($res){
                   //       echo $res['TABLE_NAME'];
                   // }
                ?>

                         <div class="bg-white w-full shadow-md rounded my-6 mx-6">
            <table class="text-left w-full border-collapse"> <!--Border collapse doesn't work on this site yet but it's available in newer tailwind versions -->
              <thead>
                <tr>
                  <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Subject</th>
                  <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Attended</th>
                  <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Bunked</th>
                    <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Attendance</th>
                    <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Action</th>

                </tr>
              </thead>
              <tbody>
                <?php 
                while($row = mysqli_fetch_assoc($res)){
                    $sid = $row['sid'];
                    $subsql = "SELECT sname FROM subjects WHERE sid =";
                    $subsql .= $sid;
                    $sname = mysqli_fetch_assoc(mysqli_query($db, $subsql))['sname'];
                    $r = '<tr class="hover:bg-grey-lighter">
                        <td class="py-4 px-6 border-b border-grey-light">';
                    $r .= $sname;
                    $attended = $row['attended'];
                    $r .= '</td>
                        <td class="py-4 px-6 border-b border-grey-light">';
                    $r .= $attended; 
                    $r .='</td>';
                    $bunked = $row['bunked'];
                    $r .= '</td>
                        <td class="py-4 px-6 border-b bordesr-grey-light">';
                    $r .= $bunked; 
                    $perc = $bunked * 100/($bunked + $attended);
                    $r .= '</td>
                        <td class="py-4 px-6 border-b border-grey-light">';
                    $r .= round($perc,2);
                    $r .= ' % </td>';

                    $attendance = round($perc, 2);

                    $r .= '<td class="py-4 px-6 border-b border-grey-light">';
                    $r .= '<a class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-full" href="../sendmail.php?email=';
                    $r .= $email;
                    $r .= '&attendance=';
                    $r .= $attendance;
                    $r .= '&username=';
                    $r .= $username;
                    $r .= '">Send Mail </a>';
                    $r .=' </td>';

                    $r .= "</tr>";

                    echo $r;
                 }
                ?>
              </tbody>
            </table>
          </div>
            </div>
        </div>
    </div>

    </div>






    <script>
        /*Toggle dropdown list*/
        function toggleDD(myDropMenu) {
            document.getElementById(myDropMenu).classList.toggle("invisible");
        }
        /*Filter dropdown options*/
        function filterDD(myDropMenu, myDropMenuSearch) {
            var input, filter, ul, li, a, i;
            input = document.getElementById(myDropMenuSearch);
            filter = input.value.toUpperCase();
            div = document.getElementById(myDropMenu);
            a = div.getElementsByTagName("a");
            for (i = 0; i < a.length; i++) {
                if (a[i].innerHTML.toUpperCase().indexOf(filter) > -1) {
                    a[i].style.display = "";
                } else {
                    a[i].style.display = "none";
                }
            }
        }
        // Close the dropdown menu if the user clicks outside of it
        window.onclick = function(event) {
            if (!event.target.matches('.drop-button') && !event.target.matches('.drop-search')) {
                var dropdowns = document.getElementsByClassName("dropdownlist");
                for (var i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (!openDropdown.classList.contains('invisible')) {
                        openDropdown.classList.add('invisible');
                    }
                }
            }
        }
    </script>


</body>

</html>