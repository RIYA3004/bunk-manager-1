<?php
    include_once '../db.php';
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
                                <h5 class="font-bold uppercase text-gray-600">Total Users</h5>
                                <?php
                                        $sql = "SELECT COUNT(*) as user_count FROM users WHERE is_admin=0";
                                        $res = mysqli_fetch_assoc(mysqli_query($db, $sql))['user_count'];
                                    ?>
                                <h3 class="font-bold text-3xl">
                                    <?php echo $res; ?>
                                    <span class="text-yellow-600"></span></h3>
                            </div>
                        </div>
                    </div>
                    <!--/Metric Card-->
                </div>
            </div>


            <div class="flex flex-row flex-wrap flex-grow mt-2">
                <?php 
                    $sql = "SELECT * FROM users WHERE is_admin=0";
                    $res = mysqli_query($db, $sql);
                    
                    




                   // while($res){
                   //       echo $res['TABLE_NAME'];
                   // }
                ?>

                         <div class="bg-white w-full shadow-md rounded my-6 mx-6">
            <table class="text-left w-full border-collapse"> <!--Border collapse doesn't work on this site yet but it's available in newer tailwind versions -->
              <thead>
                <tr>
                  <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">ID</th>
                  <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Username</th>
                  <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Name</th>
                  <th class="py-4 px-6 bg-grey-lightest font-bold uppercase text-sm text-grey-dark border-b border-grey-light">Action</th>
                </tr>
              </thead>
              <tbody>
                <?php 
                
                while($row = mysqli_fetch_assoc($res)){
                    $id = $row['id'];
                    $r = '<tr class="hover:bg-grey-lighter">
                        <td class="py-4 px-6 border-b border-grey-light">';
                    $r .= $id;
                    $name = $row['username'];
                    $r .= '</td>
                        <td class="py-4 px-6 border-b border-grey-light">';
                    $r .= $name; 
                    $r .='</td>';
                    $full_name = $row['fname'];
                    $full_name .= " ";
                    $full_name .= $row['lname'];
                    $r .= '</td>
                        <td class="py-4 px-6 border-b border-grey-light">';
                    $r .= $full_name; 
                    $r .='</td>';
                        $r .= '</td>
                        <td class="py-4 px-6 border-b border-grey-light">
                        <a href="attendance.php?user=';
                    $r .= $id;
                    $r .='" class="text-grey-lighter font-bold py-1 px-3 rounded text-xs bg-blue hover:bg-blue-dark">View</a>
                        </td>
                        </tr>';
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