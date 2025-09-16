// public/js/entities.js
$(function () {
    // Instancia modal (opcional)
    const deleteModalEl = document.getElementById('deleteConfirmModal');
    const deleteModal = deleteModalEl ? new bootstrap.Modal(deleteModalEl) : null;

    // CSRF header para todas las peticiones AJAX
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || ''
        }
    });

    let entityTable = null;

    // Ruta base desde data-route del table
    const config = {
        tableId: "#entityTable",
        formId: "#entityForm",
        idField: "#entity-id", // input hidden donde guardamos el id seleccionado
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

    // obtener routeBase dinámico (ej: "medicines")
    const routeBase = $(config.tableId).data("route");
    const apiUrl = routeBase ? `/${routeBase}` : '/';

    // util: convertir texto a snake_case (fallback para th sin data-field)
    function slugifyToField(text) {
        return text
            .trim()
            .toLowerCase()
            .replace(/[^\w\s\-]/g, '') // quitar caracteres raros
            .replace(/\s+/g, '_'); // espacios -> guion bajo
    }

    // obtener campos/keys desde thead th[data-field] o desde texto del th
    function getTableFields() {
        const fields = [];
        $(`${config.tableId} thead th`).each(function () {
            const df = $(this).data('field');
            if (df !== undefined && df !== null && df !== '') {
                fields.push(String(df));
            } else {
                fields.push(slugifyToField($(this).text()));
            }
        });
        return fields;
    }

    // construir columns para DataTables a partir de los fields
    function buildColumns(fields) {
        return fields.map(f => ({ data: f }));
    }

    // dataSrc robusto: soporta {routeBase: [...]}, {data:[...]}, [...] o primer array que encuentre
    function resolveDataSrc(json) {
        if (!json) return [];
        if (Array.isArray(json)) return json;
        if (routeBase && json[routeBase] && Array.isArray(json[routeBase])) return json[routeBase];
        if (json.data && Array.isArray(json.data)) return json.data;
        // buscar la primera propiedad que sea array
        for (const k in json) {
            if (Array.isArray(json[k])) return json[k];
        }
        return [];
    }

    // inicializa DataTable dinámicamente
    function initDataTable() {
        const fields = getTableFields();
        const columns = buildColumns(fields);

        // destruir si existiera (útil en hot-reload durante desarrollo)
        if ($.fn.DataTable.isDataTable(config.tableId)) {
            $(config.tableId).DataTable().destroy();
            $(config.tableId).find('tbody').empty();
        }

        entityTable = $(config.tableId).DataTable({
            responsive: true,
            autoWidth: false,
            ajax: {
                url: apiUrl,
                dataSrc: function (json) {
                    // loguea para debugging (puedes comentar)
                    // console.debug('AJAX response for', apiUrl, json);
                    return resolveDataSrc(json);
                }
            },
            columns: columns
        });

        // Evento de doble click en fila para seleccionar
        $(`${config.tableId} tbody`)
            .off('dblclick', 'tr')
            .on('dblclick', 'tr', function () {
                const data = entityTable.row(this).data();
                if (!data) return;

                // asigna id al hidden
                if ($(config.idField).length) {
                    // usa data.id si existe, sino busca 'id' en la fila
                    const idVal = data.id ?? data['id'] ?? '';
                    $(config.idField).val(idVal);
                }

                setFormData(data);

                $(`${config.tableId} tbody tr`).removeClass('table-active');
                $(this).addClass('table-active');

                toggleButtons({ save: false, clean: true, change: true, update: false, delete: false });
            });
    }

    // recarga la tabla sin perder paginación
    function reloadDataTable() {
        if (entityTable) entityTable.ajax.reload(null, false);
    }

    // wrapper de AJAX con manejo básico de errores (muestra errores de validación si existen)
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
                // intento de extraer errores de validación (Laravel)
                try {
                    const json = xhr.responseJSON;
                    if (json && json.errors) {
                        const firstField = Object.keys(json.errors)[0];
                        const firstMsg = json.errors[firstField][0];
                        showSnackbar(firstMsg, "danger");
                    } else if (json && json.message) {
                        showSnackbar(json.message, "danger");
                    } else {
                        showSnackbar("Server error", "danger");
                    }
                } catch (e) {
                    showSnackbar("Request error: " + e.message, "danger");
                    console.error("Caught exception:", e);
                }

                if (onError) onError(xhr);
                console.error("Error en petición:", xhr.responseText);
            }
        });
    }

    // Obtener datos del form dinámicamente usando name attrs
    function getFormData() {
        const $form = $(config.formId);
        if (!$form.length) return {};
        // serializeArray maneja inputs y select; si hay inputs repetidos hace arrays
        const arr = $form.serializeArray();
        const data = {};
        arr.forEach(item => {
            if (data[item.name] !== undefined) {
                if (!Array.isArray(data[item.name])) data[item.name] = [data[item.name]];
                data[item.name].push(item.value);
            } else {
                data[item.name] = item.value;
            }
        });
        // asegurar token por compatibilidad
        const token = $("meta[name='csrf-token']").attr('content');
        if (token && !data._token) data._token = token;
        return data;
    }

    // Pone datos en el form buscando inputs/textarea/select por name
    function setFormData(rowData = {}) {
        const $form = $(config.formId);
        if (!$form.length) return;
        $form.find('[name]').each(function () {
            const $el = $(this);
            const name = $el.attr('name');
            if (rowData[name] === undefined) {
                // si no existe dato en rowData, limpiar
                if ($el.is(':checkbox')) $el.prop('checked', false);
                else $el.val('');
                return;
            }
            const val = rowData[name];
            // checkbox
            if ($el.is(':checkbox')) {
                if (Array.isArray(val)) {
                    $el.prop('checked', val.includes($el.val()));
                } else {
                    // si el backend devuelve boolean o '1'/'0'
                    const truthy = (val === true || val === '1' || val === 1);
                    // si checkbox value no es 1/true evaluate inclusión
                    if ($el.val() === '1' || $el.val() === 'true') {
                        $el.prop('checked', truthy);
                    } else {
                        $el.prop('checked', String(val) === String($el.val()));
                    }
                }
            } else if ($el.is('select[multiple]')) {
                $el.val(val);
            } else {
                $el.val(val);
            }
        });
    }

    // Limpia form y estado
    function clearForm() {
        const $form = $(config.formId);
        if ($form.length && $form[0].reset) $form[0].reset();
        if ($(config.idField).length) $(config.idField).val('');
        toggleButtons({ save: true, clean: true, change: false, update: false, delete: false });
    }

    // Botones on/off
    function toggleButtons(state) {
        Object.keys(config.btns).forEach(key => {
            if (key in state) {
                $(config.btns[key]).prop('disabled', !state[key]);
            }
        });
    }

    // Toast simple usando Bootstrap Toast
    function showSnackbar(message, className) {
        const snackbar = $("#snackbar");
        if (!snackbar.length) {
            alert(message);
            return;
        }
        $("#snackbarMessage").text(message);
        snackbar.removeClass("text-bg-success text-bg-danger text-bg-primary text-bg-warning text-bg-info");
        snackbar.addClass(`text-bg-${className}`);
        new bootstrap.Toast(snackbar[0]).show();
    }

    // Handlers de botones (Save / Change / Update / Delete / Confirm Delete / Clean)
    // SAVE
    $(config.btns.save).on('click', function () {
        const payload = getFormData();
        sendRequest(apiUrl, "POST", payload, function () {
            showSnackbar(config.messages.created, "success");
            clearForm();
            reloadDataTable();
        });
    });

    // CHANGE (prepara update/delete)
    $(config.btns.change).on('click', function () {
        toggleButtons({ save: false, clean: true, change: false, update: true, delete: true });
    });

    // UPDATE
    $(config.btns.update).on('click', function () {
        const id = $(config.idField).val();
        if (!id) {
            showSnackbar(config.messages.select, "danger");
            return;
        }
        const payload = getFormData();
        sendRequest(`${apiUrl}/${id}`, "PUT", payload, function () {
            showSnackbar(config.messages.updated, "primary");
            clearForm();
            reloadDataTable();
        });
    });

    // DELETE (abre modal)
    $(config.btns.delete).on('click', function () {
        const id = $(config.idField).val();
        if (!id) {
            showSnackbar(config.messages.select, "danger");
            return;
        }
        if (deleteModal) deleteModal.show();
    });

    // CONFIRM DELETE
    $(config.btns.confirmDelete).on('click', function () {
        const id = $(config.idField).val();
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

    // init
    initDataTable();
    clearForm();
});
