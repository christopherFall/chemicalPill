<!-- resources/views/medicines/index.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chemical Pill</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-LN+7fdVzj6u52u30Kp6M/trliBMCMKTyK833zpbD+pXdCLuTusPj697FH4R/5mcr" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/js/bootstrap.bundle.min.js" integrity="sha384-ndDqU0Gzau9qJ1lfW4pNLlhNTkCfHzAVBReH9diLvGRem5+R9g2FzA8ZGN954O5Q" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>
<body>
    <div class="container">
        <div class="card mt-5">
            <h3 class="card-header p-3">Chemical Pill</h3>
            <div class="card-body">
                <button class="btn btn-success mb-2" id="btn-open-modal" data-bs-toggle="modal" data-bs-target="#medicineModal">Create Medicine</button>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Subtype</th>
                            <th>Side Effects</th>
                            <th width="250px">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="medicineList">
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Unified Create/Edit Medicine Modal -->
        <div class="modal fade" id="medicineModal" tabindex="-1" aria-labelledby="medicineModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="medicineModalLabel">Create Medicine</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="medicineForm">
                            <input type="hidden" id="medicine-id">
                            <div class="mt-2">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="medicineName" class="form-control">
                            </div>
                            <div class="mt-2">
                                <label for="type">Type</label>
                                <input type="text" name="type" id="medicineType" class="form-control">
                            </div>
                            <div class="mt-2">
                                <label for="subtype">Subtype</label>
                                <input type="text" name="subtype" id="medicineSubtype" class="form-control">
                            </div>
                            <div class="mt-2">
                                <label for="side_effects">Side Effects</label>
                                <textarea name="side_effects" id="medicineSideEffects" class="form-control"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveMedicineBtn">Save</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this medicine?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
            </div>
            </div>
        </div>
        </div>

        <!-- Snackbar/Toast -->
        <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
        <div id="snackbar" class="toast align-items-center text-bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
            <div class="toast-body" id="snackbarMessage">
                Success message here
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
        </div>

    </div>
</body>

<script>
    $(document).ready(function(){

        fetchMedicines();

        // Create the table rows

        function fetchMedicines(){
            $.ajax({
                type: "GET",
                url: "/medicines",
                dataType: 'json',
                success: function(response){
                    let row = "";
                    $.each(response.medicines, function(key, medicine){
                        row += `
                            <tr>
                                <td>${medicine.id}</td>
                                <td>${medicine.name}</td>
                                <td>${medicine.type}</td>
                                <td>${medicine.subtype}</td>
                                <td>${medicine.side_effects}</td>
                                <td>
                                    <button data-id="${medicine.id}" class="btn btn-primary btn-sm edit-medicine">Edit</button>
                                    <button data-id="${medicine.id}" class="btn btn-danger btn-sm delete-medicine">Delete</button>
                                </td>
                            </tr>
                        `;
                    });
                    $("#medicineList").html(row);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        // Open modal for create
        $("#btn-open-modal").click(function(){
            clearForm();
            $("#medicineModalLabel").text("Create Medicine");
            $("#saveMedicineBtn").data("action", "create");
        });

        // Open modal for edit
        $("body").on("click", ".edit-medicine", function(){
            let id = $(this).attr("data-id");
            $.ajax({
                type: "GET",
                url: "/medicines/" + id,
                dataType: 'json',
                success: function(response){
                    $("#medicine-id").val(response.medicine.id);
                    $("#medicineName").val(response.medicine.name);
                    $("#medicineType").val(response.medicine.type);
                    $("#medicineSubtype").val(response.medicine.subtype);
                    $("#medicineSideEffects").val(response.medicine.side_effects);
                    $("#medicineModalLabel").text("Edit Medicine");
                    $("#saveMedicineBtn").data("action", "edit");
                    $("#medicineModal").modal("show");
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        // Save (Create or Update)
        $("#saveMedicineBtn").click(function(){
            let action = $(this).data("action");
            let id = $("#medicine-id").val();
            let formData = {
                name: $("#medicineName").val(),
                type: $("#medicineType").val(),
                subtype: $("#medicineSubtype").val(),
                side_effects: $("#medicineSideEffects").val(),
                _token: $("meta[name='csrf-token']").attr("content")
            };

            if(action === "create"){
                $.ajax({
                    type: "POST",
                    url: "/medicines",
                    data: formData,
                    dataType: 'json',
                    success: handleResponse,
                    error: function(error) { console.log(error); }
                });
            } else {
                $.ajax({
                    type: "PUT",
                    url: "/medicines/" + id,
                    data: formData,
                    dataType: 'json',
                    success: handleResponse,
                    error: function(error) { console.log(error); }
                });
            }
        });

        let deleteId = null; // global para el id a eliminar

        // Abrir modal de confirmación al dar clic en borrar
        $("body").on("click", ".delete-medicine", function(){
            deleteId = $(this).attr("data-id");
            $("#deleteConfirmModal").modal("show");
        });

        // Confirmar borrado
        $("#confirmDeleteBtn").click(function(){
            $.ajax({
                type: "DELETE",
                url: "/medicines/" + deleteId,
                data: {_token: $("meta[name='csrf-token']").attr("content")},
                dataType: 'json',
                success: function(){
                    $("#deleteConfirmModal").modal("hide");
                    fetchMedicines();
                    showSnackbar("Medicine deleted successfully", "danger");
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        // Show snackbar
        function showSnackbar(message, type = "success"){
            let snackbar = $("#snackbar");
            $("#snackbarMessage").text(message);

            // Color type
            snackbar.removeClass("text-bg-success text-bg-danger text-bg-primary");
            if(type === "success") snackbar.addClass("text-bg-success");
            if(type === "danger") snackbar.addClass("text-bg-danger");
            if(type === "primary") snackbar.addClass("text-bg-primary");

            let toast = new bootstrap.Toast(snackbar[0]);
            toast.show();
        }

        // Helpers
        function handleResponse(response){
            $(".error-message").remove();
            if(response.errors){
                $.each(response.errors, function(key, value){
                    $("#"+key).after('<div class="text-danger error-message">'+value[0]+'</div>');
                });
            } else {
                $("#medicineModal").modal('hide');
                fetchMedicines();

                if($("#saveMedicineBtn").data("action") === "create"){
                    showSnackbar("Medicine created successfully", "success");
                } else {
                    showSnackbar("Medicine updated successfully", "primary");
                }
            }
        }

        function clearForm(){
            $("#medicineForm")[0].reset();
            $("#medicine-id").val("");
            $(".error-message").remove();
        }
    });
</script>
</html>
