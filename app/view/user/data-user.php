<?php
require_once 'app/controllers/UserController.php';

$data = UserController::fetchUser();
?>

<!-- Modal -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addUserModalLabel">Add User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm" method="post" action="actionUser.php">
                    <input type="hidden" name="id" id="userId">
                    <input type="hidden" name="action" id="formAction" value="add">
                    <div class="mb-3">
                        <label for="full_name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="full_name" name="full_name" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Table and other content here -->
<div class="content-wrapper-scroll">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12 col-12">
                <div class="card">
                    <div class="card-header my-2">
                        <div class="card-title">Table Data User</div>
                        <button class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal"
                            data-bs-target="#addUserModal">
                            <i class="bi bi-file-earmark-plus-fill"></i>
                            <span class="d-none d-md-inline ms-2">Add User</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="overflow-x: auto;">
                            <table id="basicExample" class="table custom-table">
                                <thead>
                                    <tr>
                                        <th style="width: 60px;">No</th>
                                        <th>Full Name</th>
                                        <th>Email</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($data)) {
                                        foreach ($data as $index => $user) {
                                            echo "<tr>";
                                            echo "<td style='font-size: 16px;'>" . ($index + 1) . "</td>";
                                            echo "<td style='font-size: 18px;'>" . htmlspecialchars_decode($user['full_name']) . "</td>";
                                            echo "<td style='font-size: 18px;'>" . htmlspecialchars_decode($user['email']) . "</td>";
                                            echo "<td class='text-center' style='width: 20rem;'>";
                                            echo "<button class='btn btn-sm btn-warning mx-1' onclick='editUserById({$user['id']}, \"" . htmlspecialchars(addslashes($user['full_name'])) . "\", \"" . htmlspecialchars(addslashes($user['email'])) . "\")'><i class='bi bi-pencil-square'></i></button>";
                                            echo "<button class='btn btn-sm btn-danger mx-1' onclick='deleteUser({$user['id']})'><i class='bi bi-trash'></i></button>";
                                            echo "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='4'>No User data found.</td></tr>";
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="app-footer">
        <span>© Arise admin 2023</span>
    </div>
</div>

<form id="deleteUserForm" method="post" action="actionUser.php">
    <input type="hidden" name="id" id="deleteUserById">
    <input type="hidden" name="action" value="delete">
</form>

<script>
    function submitForm() {
        var modal = document.getElementById('addUserModal');
        var modalInstance = bootstrap.Modal.getInstance(modal);
        modalInstance.hide();
    }

    function editUserById(id, full_name, email) {
        document.getElementById('addUserModalLabel').textContent = 'Edit User';
        document.getElementById('userId').value = id;
        document.getElementById('full_name').value = full_name;
        document.getElementById('email').value = email;
        document.getElementById('password').value = '';  
        document.getElementById('formAction').value = 'update';
        var modal = new bootstrap.Modal(document.getElementById('addUserModal'));
        modal.show();
    }

    function deleteUser(id) {
        if (confirm("Are you sure you want to delete this user?")) {
            document.getElementById('deleteUserById').value = id;
            document.getElementById('deleteUserForm').submit();
        }
    }
</script>