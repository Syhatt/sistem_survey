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

// Mendapatkan ID survei dari parameter URL
$surveyId = $_GET['survey_id'];

// Mendapatkan detail survei
$query = "SELECT * FROM surveys WHERE id = $surveyId";
$result = mysqli_query($conn, $query);
$survey = mysqli_fetch_assoc($result);

// Mendapatkan pertanyaan-pertanyaan survei
$query = "SELECT * FROM questions WHERE survey_id = $surveyId";
$result = mysqli_query($conn, $query);
$questions = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Mendapatkan jumlah respons untuk setiap skala likert
$query = "SELECT question_id, response_value, COUNT(*) AS count FROM surveyresponses WHERE survey_id = $surveyId GROUP BY question_id, response_value";
$result = mysqli_query($conn, $query);
$responses = [];
while ($row = mysqli_fetch_assoc($result)) {
    $responses[$row['question_id']][$row['response_value']] = $row['count'];
}

// Menampilkan hasil survey
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hasil Survey</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 8px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
    </style>
</head>
<body>
    <h1>Hasil Survey: <?php echo $survey['title']; ?></h1>

    <table>
        <tr>
            <th>Pertanyaan</th>
            <th>Sangat Setuju</th>
            <th>Setuju</th>
            <th>Netral</th>
            <th>Tidak Setuju</th>
            <th>Sangat Tidak Setuju</th>
        </tr>
        <?php foreach ($questions as $question) : ?>
            <tr>
                <td><?php echo $question['question_text']; ?></td>
                <td><?php echo isset($responses[$question['id']][1]) ? $responses[$question['id']][1] : 0; ?></td>
                <td><?php echo isset($responses[$question['id']][2]) ? $responses[$question['id']][2] : 0; ?></td>
                <td><?php echo isset($responses[$question['id']][3]) ? $responses[$question['id']][3] : 0; ?></td>
                <td><?php echo isset($responses[$question['id']][4]) ? $responses[$question['id']][4] : 0; ?></td>
                <td><?php echo isset($responses[$question['id']][5]) ? $responses[$question['id']][5] : 0; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <a href="../dashboard.html">Kembali ke Dashboard</a>
</body>
</html>
