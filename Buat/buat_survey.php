<!DOCTYPE html>
<html>
<head>
    <title>Buat Survey</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <script src="script.js"></script>
</head>
<body>
    <h1>Buat Survey</h1>

    <form action="proses_survey.php" method="post" id="surveyForm">
        <label>Judul Survey:</label>
        <input type="text" name="judul_survey" required>

        <label>Pertanyaan 0:</label>
        <input type="text" name="pertanyaan[]" required>

        <div id="pertanyaanContainer"></div>

        <button type="button" onclick="tambahPertanyaan()">Tambah Pertanyaan</button>

        <input type="submit" value="Buat Survey">
    </form>
</body>
</html>
