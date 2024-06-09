<?php
require_once __DIR__ . '/../../config.php';
class DashboardController
{
    public static function dashboardView()
    {
        include __DIR__ . '/../view/DashboardView.php';
    }
    public static function fetchDataUser()
    {
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        if (!$conn) {
            echo json_encode(['success' => false, 'message' => 'Unable to connect to the database.']);
            exit();
        }

        $sqlUsers = "SELECT COUNT(*) AS userCount FROM users";
        $resultUsers = mysqli_query($conn, $sqlUsers);
        $userCount = mysqli_fetch_assoc($resultUsers)['userCount'];
        mysqli_close($conn);

        return $userCount;
    }
    public static function fetchDataMateri()
    {
        $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

        if (!$conn) {
            echo json_encode(['success' => false, 'message' => 'Unable to connect to the database.']);
            exit();
        }

        $sqlMateri = "SELECT COUNT(*) AS materiCount FROM materi";
        $resultMateri = mysqli_query($conn, $sqlMateri);
        $materiCount = mysqli_fetch_assoc($resultMateri)['materiCount'];

        mysqli_close($conn);

        return $materiCount;
    }
}