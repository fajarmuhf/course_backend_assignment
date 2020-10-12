<?php

SESSION_START();

include("database.php"); // sertakan database.php untuk dapat menggunakan class database

$db = new Database(); // membuat objek baru dari class database agar dapat menggunakan fungsi didalamnya

$nik = (isset($_SESSION['ktp'])) ? $_SESSION['ktp'] : "";


if($nik)

{

   $result = $db->execute("SELECT * FROM user_tbl WHERE ktp = '".$nik."' AND status = 1 ");

   if(!$result)

   {

       // redirect ke halaman login, data tidak valid

       header("Location: http://localhost/course_backend/");

   }

   // abaikan jika token valid

   $userdata = $db->get("SELECT user_tbl.ktp as ktp, user_tbl.nama_depan as nama_depan, user_tbl.nama_belakang as nama_belakang,

                       user_tbl.alamat as alamat, user_tbl.kode_pos as kode_pos, kota_tbl.nama_kota as nama_kota,

                       provinsi_tbl.nama_provinsi as nama_provinsi

                       from user_tbl,kota_tbl, provinsi_tbl WHERE user_tbl.ktp = '".$nik."' AND

                       user_tbl.kota_id = kota_tbl.kota_id AND kota_tbl.provinsi_id = provinsi_tbl.provinsi_id");               

   $userdata = mysqli_fetch_assoc($userdata);                       

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


  <h2 style="text-align: center;">Home</h2>
  <p style="text-align: center;"><a href="logout.php"><button>Logout</button></a></p>
  <p style="text-align: center;"><a href="home.php"><button>Home</button></a><a href="submit_score.php"><button>Submit Score</button></a><a href="statistik.php"><button>Statistik</button></a><a href="leaderboard.php"><button>Leaderboard</button></a></p>

<table border=1 style='text-align: center;margin:auto;' >

   <tr><td align="center" colspan=5>Profile</td></tr>

   <tr><td>KTP</td><td colspan=4><?php echo $userdata['ktp'];?></td></tr>

   <tr><td>Nama</td><td colspan=4><?php echo $userdata['nama_depan']." ".$userdata['nama_belakang'];?></td></tr>

   <tr><td>alamat</td><td colspan=4><?php echo $userdata['alamat'].". Kode Pos: ".$userdata['kode_pos'];?></td></tr>

   <tr><td>Kota</td><td colspan=4><?php echo $userdata['nama_kota'];?></td></tr>   

   <tr><td>Provinsi</td><td colspan=4><?php echo $userdata['nama_provinsi'];?></td></tr>

</table>