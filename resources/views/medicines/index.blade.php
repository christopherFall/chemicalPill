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

                <!-- Formulario fijo -->
                <form id="medicineForm" class="mb-4">
                    <input type="hidden" id="medicine-id">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <label for="medicineName" class="form-label">Name</label>
                            <input type="text" id="medicineName" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="medicineType" class="form-label">Type</label>
                            <input type="text" id="medicineType" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="medicineSubtype" class="form-label">Subtype</label>
                            <input type="text" id="medicineSubtype" class="form-control">
                        </div>
                        <div class="col-md-3">
                            <label for="medicineSideEffects" class="form-label">Side Effects</label>
                            <textarea id="medicineSideEffects" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="mt-3 d-flex gap-2">
                        <button type="button" class="btn btn-primary" id="saveMedicineBtn">Save</button>
                        <button type="button" class="btn btn-secondary" id="cleanBtn">Clean</button>
                        <button type="button" class="btn btn-warning" id="changeBtn" disabled>Change</button>
                        <button type="button" class="btn btn-success" id="updateMedicineBtn" disabled>Update</button>
                        <button type="button" class="btn btn-danger" id="deleteMedicineBtn" disabled>Delete</button>
                    </div>
                </form>

                <!-- Tabla -->
                    <table data-route="medicines" id="medicinesTable" class="table table-bordered table-striped table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Subtype</th>
                                <th>Side Effects</th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
            </div>
            <!-- Delete Confirmation Modal -->
            <x-delete-confirm
                modalId="deleteConfirmModal"
                title="Confirm Deletion"
                message="Are you sure you want to delete this medicine?"
                confirmBtnId="confirmDeleteBtn"
            />

            <!-- Snackbar/Toast -->
            <div class="position-fixed bottom-0 end-0 p-3" style="z-index: 9999">
                <div id="snackbar" class="toast align-items-center text-bg-success border-0" role="alert">
                    <div class="d-flex">
                        <div class="toast-body" id="snackbarMessage">Success message here</div>
                        <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                    </div>
                </div>
            </div>
        </div>
        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/jquery.dataTables.min.css">

        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>

        <script src="{{ asset('js/medicines.js') }}"></script>
    </body>
</html>
