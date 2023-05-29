-- Membuat basis data untuk sistem survey
CREATE DATABASE sistem_survey;

-- Menggunakan basis data yang baru dibuat
USE sistem_survey;

-- Tabel untuk menyimpan survei
CREATE TABLE Surveys (
  id INT PRIMARY KEY,
  title VARCHAR(255) NOT NULL,
  created_at DATETIME NOT NULL
);

-- Tabel untuk menyimpan pertanyaan survei
CREATE TABLE Questions (
  id INT PRIMARY KEY,
  survey_id INT,
  question_text TEXT NOT NULL,
  FOREIGN KEY (survey_id) REFERENCES Surveys(id)
);

-- Tabel untuk menyimpan skala Likert
CREATE TABLE LikertScale (
  id INT PRIMARY KEY,
  scale_value INT NOT NULL,
  description VARCHAR(255) NOT NULL
);

-- Tabel untuk menyimpan jawaban survei
CREATE TABLE SurveyResponses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  survey_id INT,
  question_id INT,
  respondent_name VARCHAR(255) NOT NULL,
  response_value INT,
  response_date DATETIME,
  FOREIGN KEY (survey_id) REFERENCES Surveys(id),
  FOREIGN KEY (question_id) REFERENCES Questions(id)
);
