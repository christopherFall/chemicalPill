@props([
    'modalId' => 'deleteConfirmModal',
    'title' => 'Confirm Deletion',
    'message' => 'Are you sure you want to delete this item?',
    'confirmBtnId' => 'confirmDeleteBtn',
])

<div class="modal fade" id="{{ $modalId }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                {{ $message }}
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="{{ $confirmBtnId }}">Delete</button>
            </div>
        </div>
    </div>
</div>
