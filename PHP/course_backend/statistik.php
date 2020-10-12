<?php

SESSION_START();

include("database.php"); // sertakan database.php untuk dapat menggunakan class database

$db = new Database(); // membuat objek baru dari class database agar dapat menggunakan fungsi didalamnya

$nik = (isset($_SESSION["ktp"])) ? $_SESSION["ktp"] : "";

if($nik)

{

   $result = $db->execute("SELECT * FROM user_tbl WHERE ktp = '".$nik."' AND status = 1 ");

   if(!$result)

   {

       // redirect ke halaman login, data tidak valid

       header("Location: http://localhost/course_backend/");

   }

   // abaikan jika token valid

   $kueri = "SELECT game_tbl.nama as game, MIN(user_game_data_tbl.score) as min, MAX(user_game_data_tbl.score) as max,

                               AVG(user_game_data_tbl.score) as avg FROM user_game_data_tbl, game_tbl

                               WHERE user_game_data_tbl.game_id = game_tbl.game_id AND user_game_data_tbl.ktp = '".$nik."' group by user_game_data_tbl.game_id";

   $statisticdata = $db->get($kueri);


       

 

}

else

{

   header("Location: http://localhost/course_backend/");

}

$notification = (isset($_SESSION['notification'])) ? $_SESSION['notification'] : "";

if($notification)

{

   echo $notification;

   unset($_SESSION['notification']);   

}

?>

  <h2 style="text-align: center;">Statistik</h2>

  <p style="text-align: center;"><a href="logout.php"><button>Logout</button></a></p>
    <p style="text-align: center;"><a href="home.php"><button>Home</button></a><a href="submit_score.php"><button>Submit Score</button></a><a href="statistik.php"><button>Statistik</button></a><a href="leaderboard.php"><button>Leaderboard</button></a></p>

<table border=1 style='text-align: center;margin:auto;' >

   <tr><td align="center" colspan=4>User Statistik Skor Game</td></tr>

   <tr><td>Game</td><td>Min</td><td>Max</td><td>Avg</td></tr>

   <?php

       while($row = mysqli_fetch_assoc($statisticdata))

       {

           ?>

           <tr>

               <td><?php echo $row['game']?></td>

               <td><?php echo $row['min']?></td>

               <td><?php echo $row['min']?></td>

               <td><?php echo $row['min']?></td>               

           </tr>

           <?php

       }

   ?>

</table>