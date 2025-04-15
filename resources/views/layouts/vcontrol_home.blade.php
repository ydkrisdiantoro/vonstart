
@extends('layouts.vcontrol_index')

@section('title')
    @yield('add-title')

    {{ env('APP_NAME') }}
@endsection

@section('extra-css')
@yield('add-css')
@endsection

@section('body')

<!-- Modal Delete -->
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h5 class="modal-title" id="confirmDeleteModalLabel">Confirmation</h5>
                <p>Did you really want to delete this item?</p>
                <div class="bg-light rounded p-2 mb-3">
                    <span id="deleteModalMessage"></span>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle-fill"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteButton">
                        <i class="bi bi-trash-fill"></i> Delete
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End of Modal Delete -->

<!-- Modal Universal Alert -->
<div class="modal fade" id="confirmAlertModal" tabindex="-1" aria-labelledby="confirmAlertModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-body">
                <h5 class="modal-title" id="confirmAlertModalLabel">Confirmation</h5>
                <div class="bg-light rounded p-2 mb-3">
                    <div id="alertModalMessage"></div>
                </div>
                <div class="d-flex justify-content-between">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="bi bi-x-circle-fill"></i> Cancel
                    </button>
                    <button type="button" class="btn btn-danger" id="confirmAlertButton">
                        <i class="bi bi-check-fill"></i> Confirm
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End of Modal Universal Alert -->

@endsection

@section('extra-js')

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let deleteLink = null;
        const deleteElements = document.querySelectorAll('.delete');

        deleteElements.forEach(element => {
            element.addEventListener('click', function(event) {
                event.preventDefault();
                deleteLink = this;
                const message = this.getAttribute('data-message');
                document.getElementById('deleteModalMessage').textContent = message;
                const deleteModal = new bootstrap.Modal(document.getElementById('confirmDeleteModal'));
                deleteModal.show();
            });
        });

        document.getElementById('confirmDeleteButton').addEventListener('click', function() {
            if (deleteLink) {
                window.location.href = deleteLink.href; // Lanjutkan ke URL yang disimpan di 'href'
            }
        });
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let alertLink = null;
        const alertElements = document.querySelectorAll('.show-alert');

        alertElements.forEach(element => {
            element.addEventListener('click', function(event) {
                event.preventDefault();
                alertLink = this;
                const message = this.getAttribute('data-message');
                const buttonClass = this.getAttribute('data-button-class');
                const buttonIcon = this.getAttribute('data-button-icon');
                const buttonText = this.getAttribute('data-button-text');
                document.getElementById('alertModalMessage').innerHTML = message;
                document.getElementById('confirmAlertButton').className = buttonClass;
                document.getElementById('confirmAlertButton').innerHTML = `<i class="${buttonIcon}"></i> ${buttonText}`;
                const alertModal = new bootstrap.Modal(document.getElementById('confirmAlertModal'));
                alertModal.show();
            });
        });

        document.getElementById('confirmAlertButton').addEventListener('click', function() {
            if (alertLink) {
                window.location.href = alertLink.href; // Lanjutkan ke URL yang disimpan di 'href'
            }
        });
    });
</script>

@yield('add-js')
@endsection
