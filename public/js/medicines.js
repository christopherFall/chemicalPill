$(function () {
    // Instancia del modal Bootstrap 5
    const deleteModalEl = document.getElementById('deleteConfirmModal');
    const deleteModal = deleteModalEl ? new bootstrap.Modal(deleteModalEl) : null;

    let entityTable = null;

    // 🔑 Ruta base dinámica desde el data-route (ej: "medicine", "user", "product")
    const routeBase = $("#entityTable").data("route");
    const apiUrl = `/${routeBase}`;

    // Configuración dinámica (nombres de campos, ids de formularios, etc.)
    const config = {
        tableId: "#entityTable",
        formId: "#entityForm",
        idField: "#entity-id",
        fields: {
            name: "#entityName",
            type: "#entityType",
            subtype: "#entitySubtype",
            side_effects: "#entitySideEffects",
        },
        btns: {
            save: "#saveEntityBtn",
            clean: "#cleanBtn",
            change: "#changeBtn",
            update: "#updateEntityBtn",
            delete: "#deleteEntityBtn",
            confirmDelete: "#confirmDeleteBtn"
        },
        messages: {
            created: "Record created successfully",
            updated: "Record updated successfully",
            deleted: "Record deleted successfully",
            select: "Select a record first"
        }
    };

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

    // DataTable inicial
    function initDataTable() {
        entityTable = $(config.tableId).DataTable({
            ajax: {
                url: apiUrl,
                dataSrc: routeBase // la API devuelve { medicines: [] }, { users: [] } → dataSrc dinámico
            },
            columns: Object.keys(config.fields).map(key => ({ data: key }))
        });

        // Doble click para seleccionar fila
        $(`${config.tableId} tbody`)
            .off('dblclick', 'tr')
            .on('dblclick', 'tr', function () {
                let data = entityTable.row(this).data();
                if (!data) return;

                // Cargar datos al form
                $(config.idField).val(data.id);
                Object.keys(config.fields).forEach(field => {
                    $(config.fields[field]).val(data[field]);
                });

                $(`${config.tableId} tbody tr`).removeClass('table-active');
                $(this).addClass('table-active');

                toggleButtons({ save: false, clean: true, change: true, update: false, delete: false });
            });
    }

    function reloadDataTable() {
        if (entityTable) {
            entityTable.ajax.reload(null, false);
        }
    }

    // SAVE
    $(config.btns.save).on('click', function () {
        sendRequest(apiUrl, "POST", getFormData(), function () {
            showSnackbar(config.messages.created, "success");
            clearForm();
            reloadDataTable();
        });
    });

    // CHANGE
    $(config.btns.change).on('click', function () {
        toggleButtons({ save: false, clean: true, change: false, update: true, delete: true });
    });

    // UPDATE
    $(config.btns.update).on('click', function () {
        let id = $(config.idField).val();
        if (!id) {
            showSnackbar(config.messages.select, "danger");
            return;
        }
        sendRequest(`${apiUrl}/${id}`, "PUT", getFormData(), function () {
            showSnackbar(config.messages.updated, "primary");
            clearForm();
            reloadDataTable();
        });
    });

    // DELETE
    $(config.btns.delete).on('click', function () {
        let id = $(config.idField).val();
        if (!id) {
            showSnackbar(config.messages.select, "danger");
            return;
        }
        if (deleteModal) deleteModal.show();
    });

    $(config.btns.confirmDelete).on('click', function () {
        let id = $(config.idField).val();
        if (!id) return;

        sendRequest(`${apiUrl}/${id}`, "DELETE", { _token: $("meta[name='csrf-token']").attr("content") }, function () {
            if (deleteModal) deleteModal.hide();
            showSnackbar(config.messages.deleted, "danger");
            clearForm();
            reloadDataTable();
        });
    });

    // CLEAN
    $(config.btns.clean).on('click', function () {
        clearForm();
        $(`${config.tableId} tbody tr`).removeClass('table-active');
    });

    // Helpers
    function getFormData() {
        let data = { _token: $("meta[name='csrf-token']").attr("content") };
        Object.keys(config.fields).forEach(field => {
            data[field] = $(config.fields[field]).val();
        });
        return data;
    }

    function clearForm() {
        $(config.formId)[0].reset();
        $(config.idField).val("");
        toggleButtons({ save: true, clean: true, change: false, update: false, delete: false });
    }

    function toggleButtons(state) {
        Object.keys(config.btns).forEach(key => {
            $(config.btns[key]).prop("disabled", !state[key]);
        });
    }

    function showSnackbar(message, className) {
        let snackbar = $("#snackbar");
        $("#snackbarMessage").text(message);
        snackbar.removeClass("text-bg-success text-bg-danger text-bg-primary");
        snackbar.addClass(`text-bg-${className}`);
        new bootstrap.Toast(snackbar[0]).show();
    }
});
