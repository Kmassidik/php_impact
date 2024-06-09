<?php
require_once 'app/controllers/MateriController.php';

$materis = MateriController::fetchMateri();
?>

<div class="modal fade" id="addMateriModal" tabindex="-1" aria-labelledby="addMateriModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addMateriModalLabel">Add Materi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addUserForm" method="post" action="actionMateri.php">
                    <input type="hidden" name="id" id="materiId">
                    <input type="hidden" name="action" id="formAction" value="add">
                    <div class="mb-3">
                        <label for="name_materi" class="form-label">Nama Materi</label>
                        <input type="text" class="form-control" id="name_materi" name="name_materi" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Isi Materi</label>
                        <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save Materi</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="content-wrapper-scroll">
    <div class="content-wrapper">
        <div class="row">
            <div class="col-sm-12 col-12">
                <div class="card">
                    <div class="card-header my-2">
                        <div class="card-title">Table Data Materi</div>
                        <button class="btn btn-primary d-flex align-items-center" data-bs-toggle="modal"
                            data-bs-target="#addMateriModal">
                            <i class="bi bi-file-earmark-plus-fill"></i>
                            <span class="d-none d-md-inline ms-2">Add Materi</span>
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="overflow-x: auto;">
                            <table id="basicExample" class="table custom-table">
                                <thead>
                                    <tr>
                                        <th style="width: 60px;">No</th>
                                        <th>Nama Materi</th>
                                        <th class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (!empty($materis)) {
                                        foreach ($materis as $index => $materi) {
                                            echo "<tr>";
                                            echo "<td style='font-size: 16px;'>" . ($index + 1) . "</td>";
                                            echo "<td style='font-size: 18px;' >" . htmlspecialchars_decode($materi['name_materi']) . "</td>";
                                            echo "<td class='text-center' style='width: 20rem;'>";
                                            echo "<button class='btn btn-sm btn-warning mx-1' onclick='editMateriById({$materi['id']}, \"" . htmlspecialchars(addslashes($materi['name_materi'])) . "\", \"" . htmlspecialchars(addslashes($materi['content'])) . "\")'><i class='bi bi-pencil-square'></i></button>";
                                            echo "<button class='btn btn-sm btn-danger mx-1' onclick='deleteMateri({$materi['id']})'><i class='bi bi-trash'></i></button>";
                                            echo "<button class='btn btn-sm btn-primary mx-1' onclick='toggleIsiMateri(\"" . htmlspecialchars(addslashes($materi['content'])) . "\")'><i class='bi bi-exclamation-circle'></i></button>";
                                            echo "</td>";
                                            echo "</tr>";
                                        }
                                    } else {
                                        echo "<tr><td colspan='3'>No materi data found.</td></tr>";
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

<div class="modal fade" id="showMateriModal" tabindex="-1" aria-labelledby="showMateriModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="showMateriModalLabel">Materi Content</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div id="materiContent"></div>
            </div>
        </div>
    </div>
</div>

<form id="deleteMateriForm" method="post" action="actionMateri.php">
    <input type="hidden" name="id" id="deleteMaterById">
    <input type="hidden" name="action" id="formAction" value="delete">
</form>

<script>
    function submitForm() {
        var modal = document.getElementById('addUserModal');
        var modalInstance = bootstrap.Modal.getInstance(modal);
        modalInstance.hide();
    }

    function editMateriById(id, name_materi, content) {

        document.getElementById('addMateriModalLabel').textContent = 'Edit Materi';
        document.getElementById('materiId').value = id;
        document.getElementById('name_materi').value = name_materi;
        document.getElementById('content').value = content;

        document.getElementById('formAction').value = 'update';

        var modal = new bootstrap.Modal(document.getElementById('addMateriModal'));
        modal.show();
    }

    function addMateri() {
        document.getElementById('addMateriModalLabel').textContent = 'Add Materi';

        document.getElementById('materiId').value = '';
        document.getElementById('name_materi').value = '';
        document.getElementById('content').value = '';

        document.getElementById('formAction').value = 'add';

        var modal = new bootstrap.Modal(document.getElementById('addMateriModal'));
        modal.show();
    }

    function deleteMateri(id) {

        if (confirm("Are you sure you want to delete this materi?")) {
            document.getElementById('deleteMaterById').value = id;
            document.getElementById('formAction').value = 'delete';
            document.getElementById('deleteMateriForm').submit();
        }
    }



    function toggleIsiMateri(isiMateri) {
        var materiContent = document.getElementById('materiContent');
        materiContent.textContent = isiMateri;

        var showMateriModal = new bootstrap.Modal(document.getElementById('showMateriModal'));
        showMateriModal.show();
    }
</script>