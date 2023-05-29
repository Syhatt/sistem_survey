<?php
// Koneksi ke basis data
$host = "localhost";
$username = "root";
$password = "";
$dbname = "sistem_survey";

$conn = mysqli_connect($host, $username, $password, $dbname);
if (!$conn) {
    die("Koneksi ke basis data gagal: " . mysqli_connect_error());
}

// Mendapatkan nilai auto increment untuk id
$query = "SELECT AUTO_INCREMENT FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_NAME = 'Surveys' AND TABLE_SCHEMA = 'sistem_survey'";
$result = mysqli_query($conn, $query);
$row = mysqli_fetch_assoc($result);
$nextId = $row['AUTO_INCREMENT'];

// Memeriksa apakah ada data yang dikirimkan dari form survey
if (isset($_POST['submit'])) {
  $surveyTitle = $_POST['survey_title'];

  // Memasukkan data survey ke dalam tabel Surveys
  $query = "INSERT INTO Surveys (id, title, created_at) VALUES ('$nextId', '$surveyTitle', NOW())";
  mysqli_query($conn, $query);

  // Mengambil ID survey yang baru ditambahkan
  $surveyId = mysqli_insert_id($conn);

  // Redirect atau melakukan tindakan lain sesuai kebutuhan
  // ...

  // Contoh: Redirect ke halaman sukses
  header("Location: sukses.php");
  exit();
}

?>
