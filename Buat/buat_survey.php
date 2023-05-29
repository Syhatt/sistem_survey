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
// $query = "SELECT AUTO_INCREMENT FROM information_schema.TABLES WHERE TABLE_SCHEMA = '$dbname' AND TABLE_NAME = 'Surveys'";
// $result = mysqli_query($conn, $query);
// $row = mysqli_fetch_assoc($result);
// $nextId = $row['AUTO_INCREMENT'];

// Memeriksa apakah ada data yang dikirimkan dari form survey
if (isset($_POST['submit'])) {
    $surveyTitle = $_POST['judul_survey'];

    // Memasukkan data survey ke dalam tabel Surveys
    $query = "INSERT INTO Surveys (title, created_at) VALUES ('$surveyTitle', NOW())";
    mysqli_query($conn, $query);

    // Mengambil ID survey yang baru ditambahkan
    $surveyId = mysqli_insert_id($conn);

    // Memeriksa apakah ada pertanyaan yang dikirimkan dari form
    if (isset($_POST['pertanyaan']) && is_array($_POST['pertanyaan'])) {
        $questions = $_POST['pertanyaan'];

        // Memasukkan pertanyaan ke dalam tabel Questions
        foreach ($questions as $question) {
            $questionText = mysqli_real_escape_string($conn, $question);

            $query = "INSERT INTO Questions (survey_id, question_text) VALUES ($surveyId, '$questionText')";
            mysqli_query($conn, $query);
        }
    }

    // Redirect ke halaman sukses
    header("Location: sukses.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Buat Survey</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="script.js"></script>
</head>
<body>
    <h1>Buat Survey</h1>

    <form action="" method="post" id="surveyForm">
        <label>Judul Survey:</label>
        <input type="text" name="judul_survey" required>

        <label>Pertanyaan 0:</label>
        <input type="text" name="pertanyaan[]" required>

        <div id="pertanyaanContainer"></div>

        <button type="button" onclick="tambahPertanyaan()">Tambah Pertanyaan</button>

        <input type="submit" value="Buat Survey" name = "submit"> 
    </form>
</body>
</html>
