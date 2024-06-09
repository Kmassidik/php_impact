<?php
require_once 'app/controllers/AuthController.php';

AuthController::checkToken();
?>
<div class="page-header">
    <div class="toggle-sidebar" id="toggle-sidebar"><i class="bi bi-list"></i></div>
    <ol class="breadcrumb d-md-flex d-none">
        <li class="breadcrumb-item">
            <i class="bi bi-house"></i>
            <a href="index.html">Home</a>
        </li>
        <li class="breadcrumb-item breadcrumb-active" aria-current="page" id="breadcrumb"></li>
    </ol>
    <div class="header-actions-container">
        <ul class="header-actions">
            <li class="dropdown">
                <a href="#" id="userSettings" class="user-settings" data-toggle="dropdown" aria-haspopup="true">
                    <span class="user-name d-none d-md-block" id="userFullName"></span>
                    <span class="avatar">
                        <img src="https://picsum.photos/200" alt="Admin Templates">
                        <span class="status online"></span>
                    </span>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="userSettings">
                    <div class="header-profile-actions">
                        <a href="profile.html">Profile</a>
                        <a href="account-settings.html">Settings</a>
                        <a href="#" onclick="logout()">Logout</a>
                    </div>
                </div>
            </li>
        </ul>
    </div>

</div>
<script>
    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }

    function logout() {
        document.cookie = "token=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        document.cookie = "full_name=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/;";
        window.location.href = 'login';
    }

    window.onload = function () {
        const fullName = getCookie('full_name');
        const token = getCookie('token');

        if (!fullName || !token) {
            logout();
        } else {
            document.getElementById("userFullName").innerText = fullName;
        }

        let url = window.location.href;
        let lastSegment = url.split('/').pop();
        let breadcrumbText = lastSegment.replace(/-/g, ' ').replace(/\b\w/g, function (char) {
            return char.toUpperCase();
        });
        let breadcrumbElement = document.getElementById('breadcrumb');
        breadcrumbElement.textContent = breadcrumbText;
    };
</script>