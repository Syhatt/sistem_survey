<!DOCTYPE html>
<html>
<head>
    <title>Jawab Survey</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <?php
    // Mendapatkan ID survey dari parameter URL
    $surveyId = $_GET['survey_id'];

    // Koneksi ke database
    $servername ="localhost";
    $username = "root";
    $password = "";
    $dbname = "sistem_survey";

    // Membuat koneksi
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Memeriksa koneksi
    if (!$conn) {
        die("Koneksi gagal: " . mysqli_connect_error());
    }

    // Mendapatkan data survey berdasarkan ID
    $query = "SELECT * FROM Surveys WHERE id = '$surveyId'";
    $result = mysqli_query($conn, $query);
    $survey = mysqli_fetch_assoc($result);

    // Memeriksa apakah survey ditemukan
    if (!$survey) {
        die("Survey tidak ditemukan");
    }

    // Memeriksa apakah ada data yang dikirimkan dari form
    if (isset($_POST['submit'])) {
        $respondentName = $_POST['respondent_name'];

        // Memproses jawaban survei
        foreach ($_POST['answer'] as $questionId => $responseValue) {
            $query = "INSERT INTO SurveyResponses (survey_id, question_id, respondent_name, response_value, response_date) VALUES ('$surveyId', '$questionId', '$respondentName', '$responseValue', NOW())";
            mysqli_query($conn, $query);
        }

        // Redirect atau melakukan tindakan lain sesuai kebutuhan
        // ...

        // Contoh: Redirect ke halaman sukses
        header("Location: sukses.php");
        exit();
    }
    ?>

    <h1>Jawab Survey: <?php echo $survey['title']; ?></h1>

    <form class="survey-form" method="POST">
        <label for="respondent_name">Nama Responden:</label>
        <input type="text" id="respondent_name" name="respondent_name" required>

        <?php
        // Mendapatkan pertanyaan survei berdasarkan ID survey
        $query = "SELECT * FROM Questions WHERE survey_id = '$surveyId'";
        $result = mysqli_query($conn, $query);

        while ($question = mysqli_fetch_assoc($result)) {
            echo '<label for="answer_' . $question['id'] . '">' . $question['question_text'] . '</label>';
            echo '<input type="radio" id="answer_' . $question['id'] . '" name="answer[' . $question['id'] . ']" value="1" required> Sangat Setuju';
            echo '<input type="radio" id="answer_' . $question['id'] . '" name="answer[' . $question['id'] . ']" value="2"> Setuju';
            echo '<input type="radio" id="answer_' . $question['id'] . '" name="answer[' . $question['id'] . ']" value="3"> Netral';
            echo '<input type="radio" id="answer_' . $question['id'] . '" name="answer[' . $question['id'] . ']" value="4"> Tidak Setuju';
            echo '<input type="radio" id="answer_' . $question['id'] . '" name="answer[' . $question['id'] . ']" value="5"> Sangat Tidak Setuju';
        }
        ?>

        <div class="submit-button">
            <button type="submit" name="submit">Submit</button>
        </div>
    </form>
</body>
</html>
