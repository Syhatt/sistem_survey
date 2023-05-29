<?php 
// Koneksi ke database
$servername ="localhost";
$username = "root";
$password = "";
$dbname = "sistem_survey";

// Membuat koneksi
$conn = mysqli_connect($servername, $username, $password, $dbname);

$result = mysqli_query($conn, "SELECT * FROM Surveys");
$daftarSurvey = [];

while ($row = mysqli_fetch_assoc($result)) {
    $daftarSurvey[] = $row;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <h1>Daftar Survey</h1>
    <?php foreach($daftarSurvey as $survey) : ?>
        <a href="lihat_survey.php?survey_id=<?= $survey["id"]; ?>"><?= $survey["title"]; ?></a>
    <?php endforeach; ?>
</body>
</html>