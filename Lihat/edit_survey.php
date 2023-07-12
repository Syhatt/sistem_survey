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

// Memeriksa apakah ada data yang dikirimkan dari form edit survey
if (isset($_POST['submit'])) {
    $surveyTitle = $_POST['judul_survey'];

    // Mengupdate judul survey pada tabel Surveys
    $query = "UPDATE Surveys SET title = '$surveyTitle' WHERE id = $surveyId";
    mysqli_query($conn, $query);

    // Memeriksa apakah ada pertanyaan yang dikirimkan dari form
    if (isset($_POST['pertanyaan']) && is_array($_POST['pertanyaan'])) {
        $questions = $_POST['pertanyaan'];

        // Menghapus semua pertanyaan terkait survey dari tabel Questions
        $query = "DELETE FROM Questions WHERE survey_id = $surveyId";
        mysqli_query($conn, $query);

        // Memasukkan pertanyaan yang baru ke dalam tabel Questions
        foreach ($questions as $question) {
            $questionText = mysqli_real_escape_string($conn, $question);

            $query = "INSERT INTO Questions (survey_id, question_text) VALUES ('$surveyId', '$questionText')";
            mysqli_query($conn, $query);
        }
    }

    // Redirect ke halaman sukses
    header("Location: sukses.php");
    exit();
}

// Mendapatkan detail survey yang akan diedit
$query = "SELECT * FROM Surveys WHERE id = $surveyId";
$result = mysqli_query($conn, $query);
$survey = mysqli_fetch_assoc($result);

// Mendapatkan pertanyaan-pertanyaan terkait survey
$query = "SELECT * FROM Questions WHERE survey_id = $surveyId";
$result = mysqli_query($conn, $query);
$questions = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html>

<head>
    <title>Edit Survey</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h1 {
            color: #333;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .button-container {
            margin-top: 10px;
        }

        .button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .button:hover {
            background-color: #45a049;
        }
    </style>
</head>

<body>
    <h1>Edit Survey</h1>

    <form action="" method="post" id="editSurveyForm">
        <label>Judul Survey:</label>
        <input type="text" name="judul_survey" value="<?php echo $survey['title']; ?>" required>

        <label>Pertanyaan:</label>
        <?php foreach ($questions as $index => $question) : ?>
            <input type="text" name="pertanyaan[]" value="<?php echo $question['question_text']; ?>" required>
            <?php if ($index < count($questions) - 1) : ?>
                <br>
            <?php endif; ?>
        <?php endforeach; ?>

        <button type="button" onclick="tambahPertanyaan()">Tambah Pertanyaan</button>
        <button type="button" onclick="hapusPertanyaan()">Hapus Pertanyaan</button>

        <input type="submit" value="Simpan Perubahan" name="submit">
    </form>

    <script>
        function tambahPertanyaan() {
            var pertanyaanCount = document.getElementsByName("pertanyaan[]").length + 1;

            var label = document.createElement("label");
            label.innerHTML = "Pertanyaan " + pertanyaanCount + ":";

            var input = document.createElement("input");
            input.type = "text";
            input.name = "pertanyaan[]";
            input.required = true;

            var container = document.getElementById("editSurveyForm");
            container.insertBefore(label, container.lastChild);
            container.insertBefore(input, container.lastChild);
        }

        function hapusPertanyaan() {
            var container = document.getElementById("editSurveyForm");
            var pertanyaanElements = document.getElementsByName("pertanyaan[]");
            if (pertanyaanElements.length > 1) {
                container.removeChild(pertanyaanElements[pertanyaanElements.length - 1].previousSibling); // Hapus label pertanyaan
                container.removeChild(pertanyaanElements[pertanyaanElements.length - 1]); // Hapus input pertanyaan
            }
        }
    </script>
</body>

</html>