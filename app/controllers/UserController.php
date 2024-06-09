<?php
require_once __DIR__ . '/../../config.php';
class UserController
{
    public static function userView()
    {
        include __DIR__ . '/../view/DataUserView.php';
    }
    public static function fetchUser()
    {
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        if (!$conn) {
            return [];
        }

        $query = "SELECT id, full_name, email FROM users";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            mysqli_close($conn);
            return [];
        }

        $users = mysqli_fetch_all($result, MYSQLI_ASSOC);

        mysqli_close($conn);
        return $users;
    }
    public static function createUser()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

            if (!$conn) {
                echo "Error: Unable to connect to the database.";
                return;
            }

            $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);

            $email_check_query = "SELECT * FROM users WHERE email = '$email' LIMIT 1";
            $result = mysqli_query($conn, $email_check_query);

            if (mysqli_num_rows($result) > 0) {
                echo "Error: Email already exists.";
                return;
            }

            $password_hash = password_hash($password, PASSWORD_BCRYPT);

            $insert_query = "INSERT INTO users (full_name, email, password_hash) VALUES ('$full_name', '$email', '$password_hash')";
            if (mysqli_query($conn, $insert_query)) {
                header("Location: master-user");
            } else {
                header("Location: master-user?error=empty_fields");
            }

            mysqli_close($conn);
            exit();
        }
    }
    public static function updateUserById()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

            if (!$conn) {
                echo "Error: Unable to connect to the database.";
                return;
            }

            $id = mysqli_real_escape_string($conn, $_POST['id']);
            $full_name = mysqli_real_escape_string($conn, $_POST['full_name']);
            $email = mysqli_real_escape_string($conn, $_POST['email']);
            $password = mysqli_real_escape_string($conn, $_POST['password']);

            $email_check_query = "SELECT * FROM users WHERE email = '$email' AND id != '$id' LIMIT 1";
            $result = mysqli_query($conn, $email_check_query);

            if (mysqli_num_rows($result) > 0) {
                echo "Error: Email already exists.";
                return;
            }

            $sql = "UPDATE users SET full_name = '$full_name', email = '$email'";

            if (!empty($password)) {
                $password_hash = password_hash($password, PASSWORD_BCRYPT);
                $sql .= ", password = '$password_hash'";
            }

            $sql .= " WHERE id = $id";

            if (mysqli_query($conn, $sql)) {
                header("Location: master-user");
            } else {
                header("Location: master-user?error=empty_fields");
            }

            mysqli_close($conn);
            exit();
        }
    }
    public static function deleteUserById()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

            if (!$conn) {
                echo "Error: Unable to connect to the database.";
                return;
            }

            $id = mysqli_real_escape_string($conn, $_POST['id']);

            $sql = "DELETE FROM users WHERE id = $id";

            if (mysqli_query($conn, $sql)) {
                header("Location: master-user");
            } else {
                echo "Error deleting materi: " . mysqli_error($conn);
            }
            mysqli_close($conn);
            exit();
        }
    }
}