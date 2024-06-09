<?php

require_once __DIR__ . '/../../config.php';

class MateriController
{
    public static function materiView()
    {
        include __DIR__ . '/../view/MateriView.php';
    }
    public static function fetchMateri()
    {
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        if (!$conn) {
            echo "Error: Unable to connect to the database.";
            return;
        }

        $sql = "SELECT * FROM materi";

        $result = mysqli_query($conn, $sql);

        if (!$result) {
            echo "Error: Unable to fetch materi records.";
            mysqli_close($conn);
            return;
        }

        $materiRecords = array();

        while ($row = mysqli_fetch_assoc($result)) {
            $materiRecords[] = $row;
        }

        mysqli_free_result($result);

        mysqli_close($conn);

        return $materiRecords;
    }
    public static function createMateri()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

            if (!$conn) {
                echo "Error: Unable to connect to the database.";
                return;
            }

            $namaMateri = mysqli_real_escape_string($conn, $_POST['name_materi']);
            $isiMateri = mysqli_real_escape_string($conn, $_POST['content']);

            $sql = "INSERT INTO materi (name_materi, content) VALUES ('$namaMateri', '$isiMateri')";

            if (mysqli_query($conn, $sql)) {
                header("Location: master-materi");
            } else {
                header("Location: master-materi?error=empty_fields");
            }
            mysqli_close($conn);
            exit();
        }
    }
    public static function updateMateriById()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

            if (!$conn) {
                echo "Error: Unable to connect to the database.";
                return;
            }

            $id = mysqli_real_escape_string($conn, $_POST['id']);
            $name_materi = mysqli_real_escape_string($conn, $_POST['name_materi']);
            $content = mysqli_real_escape_string($conn, $_POST['content']);

            $sql = "UPDATE materi SET name_materi = '$name_materi', content = '$content' WHERE id = $id";

            if (mysqli_query($conn, $sql)) {
                header("Location: master-materi");
            } else {
                header("Location: master-materi?error=update_failed");
            }

            mysqli_close($conn);
            exit();
        }
    }
    public static function deleteMateriById()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

            if (!$conn) {
                echo "Error: Unable to connect to the database.";
                return;
            }

            $id = mysqli_real_escape_string($conn, $_POST['id']);

            $sql = "DELETE FROM materi WHERE id = $id";

            if (mysqli_query($conn, $sql)) {
                header("Location: master-materi");
            } else {
                echo "Error deleting materi: " . mysqli_error($conn);
            }
            mysqli_close($conn);
            exit();
        }
    }
}
