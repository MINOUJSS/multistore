<style>
/* ================= BENEFITS PAGE RESPONSIVE ================= */
@media (max-width: 991.98px) {

    /* Container spacing */
    .container-fluid {
        padding-left: 12px;
        padding-right: 12px;
    }

    /* Page title */
    h1.h3 {
        font-size: 1.25rem;
        text-align: center;
    }

    /* Card spacing */
    .card {
        margin-bottom: 15px;
    }

    /* Card header layout */
    .card-header {
        flex-direction: column;
        align-items: flex-start !important;
        gap: 10px;
    }

    .card-header h6 {
        font-size: 1rem;
    }

    .card-header .btn {
        width: 100%;
    }

    /* Tables */
    .table-responsive {
        width: 80vw !important;
        overflow-x: auto;
        -webkit-overflow-scrolling: touch;
    }

    .table {
        min-width: 700px;
        font-size: 0.85rem;
    }

    .table th,
    .table td {
        white-space: nowrap;
        vertical-align: middle;
    }

    /* Action buttons inside table */
    .table .btn-circle {
        width: 32px;
        height: 32px;
        padding: 0;
        font-size: 0.75rem;
    }

    /* Status form (switch + button) */
    form.row {
        gap: 15px;
    }

    form.row .col-md-6 {
        width: 100%;
        text-align: center !important;
    }

    form.row .btn {
        width: 100%;
    }
}

/* ================= MODALS RESPONSIVE ================= */
@media (max-width: 575.98px) {

    .modal-dialog {
        max-width: 95%;
        margin: 1rem auto;
    }

    .modal-header h5 {
        font-size: 1rem;
    }

    .modal-body {
        padding: 1rem;
    }

    .modal-footer {
        flex-direction: column;
        gap: 10px;
    }

    .modal-footer .btn {
        width: 100%;
    }
}

</style>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card mb-3 mt-3">
                <div class="card-body d-flex justify-content-between">
                    <h1 class="h3 mb-0 text-gray-800">نموذج إستمارة الطلب</h1>
                    <button id="saveOrderForm" type="submit" class="btn btn-primary"><i class="fas fa-save me-2"></i>حفظ</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <!-- قسم التحكم -->
        <div class="col-md-6">
                    @include('users.sellers.components.content.pages.sections.order_form.partials.order_form_control')
        </div>
        
        <!-- قسم العرض الحي -->
        <div class="col-md-6">
            <div id="livePreviewContainer">
                <div class="card">
                    <div class="card-body">
                         @include('users.sellers.components.content.pages.sections.order_form.partials.order_form')
                    </div>
                </div>
               
            </div>
        </div>
    </div>
</div>