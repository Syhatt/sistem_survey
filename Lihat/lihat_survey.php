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

// Mendapatkan skala Likert
$query = "SELECT * FROM likertscale";
$result = mysqli_query($conn, $query);
$likertScale = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Mendapatkan jawaban-jawaban survei
$query = "SELECT * FROM SurveyResponses WHERE survey_id = $surveyId";
$result = mysqli_query($conn, $query);
$responses = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Menampilkan hasil survei
?>

<!DOCTYPE html>
<html>
<head>
    <title>Hasil Survey</title>
</head>
<body>
    <h1>Hasil Survey: <?php echo $survey['title']; ?></h1>

    <h2>Pertanyaan-pertanyaan:</h2>
    <ul>
        <?php foreach ($questions as $question) : ?>
            <li><?php echo $question['question_text']; ?></li>
        <?php endforeach; ?>
    </ul>

    <h2>Jawaban-jawaban:</h2>
    <ul>
        <?php foreach ($responses as $response) : ?>
            <li>
                <?php
                    $questionId = $response['question_id'];
                    $query = "SELECT question_text FROM Questions WHERE id = $questionId";
                    $result = mysqli_query($conn, $query);
                    $question = mysqli_fetch_assoc($result);
                    $responseValue = $response['response_value'];
                    $likertDescription = '';
                    foreach ($likertScale as $likert) {
                        if ($likert['scale_value'] == $responseValue) {
                            $likertDescription = $likert['description'];
                            break;
                        }
                    }
                    echo $question['question_text'] . ': ' . $likertDescription;
                ?>
            </li>
        <?php endforeach; ?>
    </ul>

    <a href="../dashboard.html">Kembali ke Dashboard</a>
</body>
</html>
