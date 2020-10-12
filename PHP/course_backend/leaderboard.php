<?php
	session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<title>Submit Score User</title>
</head>
<body>
	<h2 style="text-align: center;">Leaderboard User</h2>
	  <p style="text-align: center;"><a href="logout.php"><button>Logout</button></a></p>
	  <p style="text-align: center;"><a href="home.php"><button>Home</button></a><a href="submit_score.php"><button>Submit Score</button></a><a href="statistik.php"><button>Statistik</button></a><a href="leaderboard.php"><button>Leaderboard</button></a></p>
	<p style="text-align: center;"><select id='game_id' onchange='window.location="?game_id="+document.getElementById("game_id").value+"&level="+document.getElementById("level").value;'>
		<?php
				include("database.php"); // sertakan database.php untuk dapat menggunakan class database

				$db = new Database(); // membuat objek baru dari class database agar dapat menggunakan fungsi didalamnya

				$getdata = $db->get("SELECT game_id,nama,tipe_leaderboard,status FROM game_tbl WHERE 1");

				while($row = mysqli_fetch_assoc($getdata)) {
					echo "<option value='".$row['game_id']."'>".$row['nama']."</option>";
				}
		?>
	</select>
	</p>
	<p style="text-align: center;">
	<select id='level' onchange='window.location="?game_id="+document.getElementById("game_id").value+"&level="+document.getElementById("level").value;'>
		<option value=1>1</option>
		<option value=2>2</option>
	</select>
	<?php
		if(isset($_GET["level"]) && isset($_GET["game_id"])){
			echo "<script>document.getElementById('level').value = '".$_GET["level"]."';document.getElementById('game_id').value = '".$_GET["game_id"]."';</script>";
		}
	?>
	</p>
	<table style='text-align: center;margin:auto;' border=1>
		<tr>
			<th>No</th>
			<th>Nama</th>
			<th>Score</th>
		</tr>
			<?php

				if(!isset($_SESSION["game_id"]) && !isset($_SESSION["level"])){
					$_SESSION["game_id"] = 1;
					$_SESSION["level"] = 1;	
				}
				if(isset($_GET["level"]) && isset($_GET["game_id"])){
					$_SESSION["game_id"] = $_GET["game_id"];
					$_SESSION["level"] = $_GET["level"];
				}


				$db = new Database(); // membuat objek baru dari class database agar dapat menggunakan fungsi didalamnya

				$getdata = $db->get("SELECT COUNT(*) FROM user_game_data_tbl WHERE game_id = ".$_SESSION["game_id"]." AND level = ".$_SESSION["level"]." ORDER BY score DESC");

				while($row = mysqli_fetch_assoc($getdata)) {
					$jumlahrow = $row["COUNT(*)"];
				}				

				$kueri = "SELECT user_tbl.nama_depan as nama_depan, user_tbl.nama_belakang as nama_belakang, max(user_game_data_tbl.score) as score FROM user_tbl, user_game_data_tbl WHERE user_tbl.ktp = user_game_data_tbl.ktp AND user_game_data_tbl.game_id = ".$_SESSION['game_id']." AND user_game_data_tbl.level = ".$_SESSION["level"]." GROUP BY user_tbl.ktp ORDER BY score DESC";
				
				$getdata = $db->get($kueri);


				if($jumlahrow > 0){
					   $no = 0;
					while($row = mysqli_fetch_assoc($getdata)) {
						$no++;
						echo "<tr>";
						echo "<td>".$no."</td>";
						echo "<td>".$row['nama_depan']." ".$row['nama_belakang']."</td>";
						echo "<td>".$row["score"]."</td>";
						echo "</tr>";
					}
				}
			?>
	</table>
</body>
</html>