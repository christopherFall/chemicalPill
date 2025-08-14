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
            <h3 class="card-header p-3">Checmical Pill</h3>
            <div class="card-body">
                <button class="btn btn-success mb-2" data-bs-toggle="modal" data-bs-target="#createMedicine">Create Medicine</button>
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

        <!-- Create Medicine Modal -->
        <div class="modal fade" id="createMedicine" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Create Medicine</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
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
                                <textarea type="text" name="side_effects" id="medicineSideEffects" class="form-control"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary create-medicine">Submit</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Medicine Modal -->
        <div class="modal fade" id="editMedicine" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Update Medicine</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <input type="hidden" id="medicine-id">
                            <div class="mt-2">
                                <label for="name">Name</label>
                                <input type="text" name="name" id="medicineName-edit" class="form-control">
                            </div>
                            <div class="mt-2">
                                <label for="type">Type</label>
                                <input type="text" name="type" id="medicineType-edit" class="form-control">
                            </div>
                            <div class="mt-2">
                                <label for="subtype">Subtype</label>
                                <input type="text" name="subtype" id="medicineSubtype-edit" class="form-control">
                            </div>
                            <div class="mt-2">
                                <label for="side_effects">Side Effects</label>
                                <textarea type="text" name="side_effects" id="medicineSideEffects-edit" class="form-control"></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary update-medicine">Update</button>
                    </div>
                </div>
            </div>
        </div>

    </div>
</body>

<script>
    $(document).ready(function(){

        fetchMedicines();

        function fetchMedicines(){
            $.ajax({
                type: "GET",
                url: "/medicines",
                dataType: 'json',
                success: function(response){
                    console.log(response);
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

        };

        $("body").on("click", ".delete-medicine", function(){
            let id = $(this).attr("data-id");

            if(confirm("Are you sure you want to delete this medicine?")){
                $.ajax({
                    type: "DELETE",
                    url: "/medicines/" + id,
                    data: {_token: $("meta[name='csrf-token']").attr("content")},
                    dataType: 'json',
                    success: function(response){
                        fetchMedicines();
                    },
                    error: function(error) {
                        console.log(error);
                    }
                });
            }
        });

        // Edit GET Request

        $("body").on("click", ".edit-medicine", function(){
            let id = $(this).attr("data-id");
            $.ajax({
                type: "GET",
                url: "/medicines/" + id,
                dataType: 'json',
                success: function(response){
                    console.log(response);
                    $("#medicine-id").val(response.medicine.id);
                    $("#medicineName-edit").val(response.medicine.name);
                    $("#medicineType-edit").val(response.medicine.type);
                    $("#medicineSubtype-edit").val(response.medicine.subtype);
                    $("#medicineSideEffects-edit").val(response.medicine.side_effects);
                    $("#editMedicine").modal("show");
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        // Update Medicine

        $(".update-medicine").click(function(){
            let formData = {
                name: $("#medicineName-edit").val(),
                type: $("#medicineType-edit").val(),
                subtype: $("#medicineSubtype-edit").val(),
                side_effects: $("#medicineSideEffects-edit").val(),
                _token: $("meta[name='csrf-token']").attr("content")
            };

            $.ajax({
                type: "PUT",
                url: "/medicines/" + $("#medicine-id").val(),
                data: formData,
                dataType: 'json',
                success: function(response){
                    if(response.errors){
                        $.each(response.errors, function(key, value){
                            $("#"+key+"-edit").after('<div class="text-danger error-message">'+value[0]+'</div>');
                        })
                    } else {
                        $("#editMedicine").modal('hide');
                        fetchMedicines();
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        // Create Medicine

        $(".create-medicine").click(function(){
            let formData = {
                name: $("#medicineName").val(),
                type: $("#medicineType").val(),
                subtype: $("#medicineSubtype").val(),
                side_effects: $("#medicineSideEffects").val(),
                _token: $("meta[name='csrf-token']").attr("content")
            };

            $.ajax({
                type: "POST",
                url: "/medicines",
                data: formData,
                dataType: 'json',
                success: function(response){
                    if(response.errors){
                        $.each(response.errors, function(key, value){
                            $("#"+key).after('<div class="text-danger error-message">'+value[0]+'</div>');
                        })
                    } else {
                        $("#createMedicine").modal('hide');
                        fetchMedicines();
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });
    });
</script>
</html>
