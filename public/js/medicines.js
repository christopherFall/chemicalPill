$(function () {
    // Instancia del modal Bootstrap 5
    const deleteModalEl = document.getElementById('deleteConfirmModal');
    const deleteModal = deleteModalEl ? new bootstrap.Modal(deleteModalEl) : null;

    var medicinesTable = null;

    initDataTable();
    clearForm();

    // Función genérica AJAX
    function sendRequest(url, method, data = {}, onSuccess = null, onError = null) {
        $.ajax({
            url: url,
            method: method,
            data: data,
            dataType: "json",
            success: function (response) {
                if (onSuccess) onSuccess(response);
            },
            error: function (xhr) {
                if (onError) onError(xhr);
                console.error("Error en petición:", xhr.responseText);
            }
        });
    }

    // DataTable
    function initDataTable() {
        medicinesTable = $('#medicinesTable').DataTable({
            ajax: {
                url: '/medicines',
                dataSrc: 'medicines' // Laravel debe devolver { medicines: [...] }
            },
            columns: [
                { data: 'id' },
                { data: 'name' },
                { data: 'type' },
                { data: 'subtype' },
                { data: 'side_effects' }
            ]
        });

        // Registrar eventos DESPUÉS de crear la tabla
        $('#medicinesTable tbody')
            .off('dblclick', 'tr')
            .on('dblclick', 'tr', function () {
                var data = medicinesTable.row(this).data();
                if (!data) return;

                $('#medicine-id').val(data.id);
                $('#medicineName').val(data.name);
                $('#medicineType').val(data.type);
                $('#medicineSubtype').val(data.subtype);
                $('#medicineSideEffects').val(data.side_effects);

                $('#medicinesTable tbody tr').removeClass('table-active');
                $(this).addClass('table-active');

                toggleButtons({ save: false, clean: true, change: true, update: false, delete: false });
            });
    }

    function reloadDataTable() {
        if (medicinesTable) {
            medicinesTable.ajax.reload(null, false); // recarga sin perder paginación
        }
    }

    // SAVE → Crear
    $("#saveMedicineBtn").on('click', function () {
        sendRequest("/medicines", "POST", getFormData(), function () {
            showSnackbar("Medicine created successfully", "success");
            clearForm();
            reloadDataTable();
        });
    });

    // CHANGE → habilitar Update/Delete
    $("#changeBtn").on('click', function () {
        toggleButtons({ save: false, clean: true, change: false, update: true, delete: true });
    });

    // UPDATE → Guardar cambios
    $("#updateMedicineBtn").on('click', function () {
        let id = $("#medicine-id").val();
        if (!id) {
            showSnackbar("Select a record first", "danger");
            return;
        }
        sendRequest("/medicines/" + id, "PUT", getFormData(), function () {
            showSnackbar("Medicine updated successfully", "primary");
            clearForm();
            reloadDataTable();
        });
    });

    // DELETE → Confirmación modal
    $("#deleteMedicineBtn").on('click', function () {
        let id = $("#medicine-id").val();
        if (!id) {
            showSnackbar("Select a record first", "danger");
            return;
        }
        if (deleteModal) deleteModal.show();
    });

    $("#confirmDeleteBtn").on('click', function () {
        let id = $("#medicine-id").val();
        if (!id) return;

        sendRequest("/medicines/" + id, "DELETE", { _token: $("meta[name='csrf-token']").attr("content") }, function () {
            if (deleteModal) deleteModal.hide();
            showSnackbar("Medicine deleted successfully", "danger");
            clearForm();
            reloadDataTable();
        });
    });

    // CLEAN → Reiniciar formulario
    $("#cleanBtn").on('click', function () {
        clearForm();
        $('#medicinesTable tbody tr').removeClass('table-active');
    });

    // Helpers
    function getFormData() {
        return {
            name: $("#medicineName").val(),
            type: $("#medicineType").val(),
            subtype: $("#medicineSubtype").val(),
            side_effects: $("#medicineSideEffects").val(),
            _token: $("meta[name='csrf-token']").attr("content"),
        };
    }

    function clearForm() {
        $("#medicineForm")[0].reset();
        $("#medicine-id").val("");
        toggleButtons({ save: true, clean: true, change: false, update: false, delete: false });
    }

    function toggleButtons(state) {
        $("#saveMedicineBtn").prop("disabled", !state.save);
        $("#cleanBtn").prop("disabled", !state.clean);
        $("#changeBtn").prop("disabled", !state.change);
        $("#updateMedicineBtn").prop("disabled", !state.update);
        $("#deleteMedicineBtn").prop("disabled", !state.delete);
    }

    function showSnackbar(message, className) {
        let snackbar = $("#snackbar");
        $("#snackbarMessage").text(message);
        snackbar.removeClass("text-bg-success text-bg-danger text-bg-primary");
        snackbar.addClass(`text-bg-${className}`);
        new bootstrap.Toast(snackbar[0]).show();
    }
});
