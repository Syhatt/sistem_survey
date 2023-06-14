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
    <title>Daftar Survey</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <h1>Daftar Survey</h1>
    <table>
        <tr>
            <th>No.</th>
            <th>ID Survey</th>
            <th>Judul Survey</th>
            <th>Tindakan</th>
        </tr>
        <?php $no = 1; ?>
        <?php foreach($daftarSurvey as $survey) : ?>
            <tr>
                <td><?= $no++; ?></td>
                <td><?= $survey["id"]; ?></td>
                <td><?= $survey["title"]; ?></td>
                <td>
                    <a href="lihat_survey.php?survey_id=<?= $survey["id"]; ?>">Lihat</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
