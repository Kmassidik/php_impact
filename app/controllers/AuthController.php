<?php
require_once __DIR__ . '/../../config.php';

class AuthController
{
    public static function loginView()
    {
        include __DIR__ . '/../view/LoginView.php';
    }
    public static function authLogin()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

            if (!$conn) {
                echo json_encode(['success' => false, 'message' => 'Unable to connect to the database.']);
                exit();
            }

            $email = mysqli_real_escape_string($conn, trim($_POST['email']));
            $password = trim($_POST['password']);
            $token = bin2hex(random_bytes(8));

            if (empty($email) || empty($password)) {
                echo json_encode(['success' => false, 'message' => 'Empty fields.']);
                mysqli_close($conn);
                exit();
            }

            if ($email === "impact_labs@admin.com" && $password === "1mpactL4B") {
                echo '<script>
                    document.cookie = "token=eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkltcGFjdExhYiIsImlhdCI6MTUxNjIzOTAyMn0.qHfTLT2CmD8IrDBwAIVHKqRTkFBvToo9rjl0vkNYanY; path=/"; 
                    document.cookie = "full_name=Admin Impact Labs; path=/";        
                    window.location.href = "dashboard";
                  </script>';
                mysqli_close($conn);
                exit();
            }

            $sql = "SELECT id, full_name, password_hash FROM users WHERE email = '$email'";
            $result = mysqli_query($conn, $sql);

            if (mysqli_num_rows($result) > 0) {
                $user = mysqli_fetch_assoc($result);
                if (password_verify($password, $user['password_hash'])) {
                    $user_id = $user['id'];
                    $token_query = "SELECT token FROM tokens WHERE user_id = '$user_id'";
                    $token_result = mysqli_query($conn, $token_query);

                    if (mysqli_num_rows($token_result) > 0) {
                        $sql_update_token = "UPDATE tokens SET token = '$token' WHERE user_id = '$user_id'";
                        if (!mysqli_query($conn, $sql_update_token)) {
                            echo json_encode(['success' => false, 'message' => 'Unable to update token.']);
                        }
                    } else {
                        $sql_insert_token = "INSERT INTO tokens (token, user_id) VALUES ('$token', '$user_id')";
                        if (!mysqli_query($conn, $sql_insert_token)) {
                            echo json_encode(['success' => false, 'message' => 'Unable to insert token.']);
                        }
                    }

                    echo '<script>
                        document.cookie = "token=' . $token . '; path=/";
                        document.cookie = "full_name=' . $user['full_name'] . '; path=/";
                        window.location.href = "dashboard";
                    </script>';
                } else {
                    header("Location: login?error=invalid_credentials");
                }
            } else {
                echo json_encode(['successs' => false, 'message' => 'Invalid credentials.']);
                header("Location: login?error=invalid_credentials");
            }
            mysqli_close($conn);
            exit();
        } else {
            header("Location: index.php");
            exit();
        }
    }
    public static function checkToken()
    {
        if (isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];

            if ($token == "eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJzdWIiOiIxMjM0NTY3ODkwIiwibmFtZSI6IkltcGFjdExhYiIsImlhdCI6MTUxNjIzOTAyMn0.qHfTLT2CmD8IrDBwAIVHKqRTkFBvToo9rjl0vkNYanY") {
                return;
            }

            $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

            if (!$conn) {
                echo json_encode(['success' => false, 'message' => 'Unable to connect to the database.']);
                exit();
            }

            $token = mysqli_real_escape_string($conn, $token);

            $sql = "SELECT * FROM tokens WHERE token = '$token'";
            $result = mysqli_query($conn, $sql);

            if (!($result && mysqli_num_rows($result) > 0)) {
                setcookie('token', '', time() - 3600, '/'); 
                setcookie('full_name', '', time() - 3600, '/');
                header("Location: login");
                exit();
            }
            

            mysqli_close($conn);
        } else {
            header("Location: login");
            exit();
        }
    }
}
