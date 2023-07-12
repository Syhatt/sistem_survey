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

// Mendapatkan ID survey dari parameter URL
$surveyId = $_GET['survey_id'];

// Menghapus survey dari tabel Surveys
$query = "DELETE FROM Surveys WHERE id = $surveyId";
mysqli_query($conn, $query);

// // Menghapus pertanyaan yang terkait dengan survey dari tabel Questions
// $query = "DELETE FROM Questions WHERE survey_id = $surveyId";
// mysqli_query($conn, $query);

// Redirect ke halaman sukses atau halaman lain yang diinginkan
header("Location: sukses.php");
exit();
