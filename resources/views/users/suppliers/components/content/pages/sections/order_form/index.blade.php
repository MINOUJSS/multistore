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
                    @include('users.suppliers.components.content.pages.sections.order_form.partials.order_form_control')
        </div>
        
        <!-- قسم العرض الحي -->
        <div class="col-md-6">
            <div id="livePreviewContainer">
                <div class="card">
                    <div class="card-body">
                         @include('users.suppliers.components.content.pages.sections.order_form.partials.order_form')
                    </div>
                </div>
               
            </div>
        </div>
    </div>
</div>