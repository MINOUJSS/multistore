<style>
    .is-invalid {
    border-color: #dc3545 !important;
}

.invalid-feedback {
    display: none;
    width: 100%;
    margin-top: 0.25rem;
    font-size: 0.875em;
    color: #dc3545;
}

.invalid-feedback.d-block {
    display: block;
}
</style>
<form id="form_controller" method="POST" action="{{ route('seller.order-form.update-order-form') }}">
<div class="card mb-3">
    <div class="card-header">
        <h5 class="card-title"> رسالة النموذج</h5>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label for="form_title_controller" class="form-label">رسالة توجيهية تظهر فوق إستمارة تقديم الطلب</label>
            <input type="text" class="form-control" id="form_title_controller" name="form_title_controller"
                placeholder="{{ $order_form->form_title }}">
        </div>
        <div class="mb-3">
            <label for="submit_btn" class="form-label">نص زر الشراء</label>
            <input type="text" class="form-control" id="submit_btn" name="submit_btn"
                placeholder="{{ $order_form->form_submit_button }}">
        </div>
    </div>
</div>
<!---->
<div class="card mb-3">
    <div class="card-header">
        <h5 class="card-title">معلومات العميل</h5>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label for="form_lable_customer_name_controller" class="form-label"> عنوان حقل
                {{ $order_form->lable_customer_name }}</label>
            <input type="text" class="form-control" id="form_lable_customer_name_controller"
                name="form_lable_customer_name_controller" placeholder="{{ $order_form->lable_customer_name }}">
        </div>
        <div class="mb-3">
            <label for="form_placeholder_customer_name_controller" class="form-label">الذي يظهر في حقل
                {{ $order_form->lable_customer_name }}</label>
            <input type="text" class="form-control" id="form_placeholder_customer_name_controller"
                name="form_placeholder_customer_name_controller"
                placeholder="{{ $order_form->input_placeholder_customer_name }}">
        </div>
        <div class="mb-3">
            <div class="form-check form-switch">
                <input id="form_required_customer_name_controller" name="form_required_customer_name_controller"
                    class="form-check-input" type="checkbox" {{ $order_form->customer_name_required === 'true' ? 'checked' : '' }}>
                <label class="form-check-label"
                    for="form_required_customer_name_controller">{{ $order_form->lable_customer_name }} مطلوب</label>
            </div>
        </div>
        <div class="mb-3">
            <label for="form_lable_customer_phone_controller" class="form-label"> عنوان حقل
                {{ $order_form->lable_customer_phone }}</label>
            <input type="text" class="form-control" id="form_lable_customer_phone_controller"
                name="form_lable_customer_phone_controller" placeholder="{{ $order_form->lable_customer_phone }}">
        </div>
        <div class="mb-3">
            <label for="form_placeholder_customer_phone_controller" class="form-label">النص الذي يظهر في حقل
                {{ $order_form->lable_customer_phone }}</label>
            <input type="text" class="form-control" id="form_placeholder_customer_phone_controller"
                name="form_placeholder_customer_phone_controller"
                placeholder="{{ $order_form->input_placeholder_customer_phone }}">
        </div>
    </div>
</div>
<!---->
<div class="card mb-3">
    <div class="card-header">
        <h5 class="card-title">معلومات {{ $order_form->lable_customer_address }}</h5>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label for="form_lable_customer_address_controller" class="form-label"> عنوان حقل
                {{ $order_form->lable_customer_address }}</label>
            <input type="text" class="form-control" id="form_lable_customer_address_controller"
                name="form_lable_customer_address_controller" placeholder="{{ $order_form->lable_customer_address }}">
        </div>
        <div class="mb-3">
            <label for="form_placeholder_customer_address_controller" class="form-label">الذي يظهر في حقل
                {{ $order_form->lable_customer_address }}</label>
            <input type="text" class="form-control" id="form_placeholder_customer_address_controller"
                name="form_placeholder_customer_address_controller"
                placeholder="{{ $order_form->input_placeholder_customer_address }}">
        </div>
        <div class="mb-3">
            <div class="form-check form-switch">
                <input name="form_required_customer_address_controller" class="form-check-input" type="checkbox"
                    id="form_required_customer_address_controller" {{ $order_form->customer_address_required === 'true' ? 'checked' : '' }}>
                <label class="form-check-label"
                    for="form_required_customer_address_controller">{{ $order_form->lable_customer_address }}
                    مطلوب</label>
            </div>
        </div>
        <div class="mb-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="form_required_customer_address_status_controller"
                    name="form_required_customer_address_status_controller" {{ $order_form->customer_address_visible === 'true' ? 'checked' : '' }}>
                <label class="form-check-label" for="form_required_customer_address_controller">تفعيل حقل
                    {{ $order_form->lable_customer_address }}</label>
            </div>
        </div>
    </div>
</div>
<!---->
<div class="card mb-3">
    <div class="card-header">
        <h5 class="card-title">خانة {{ $order_form->lable_customer_notes }}</h5>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label for="form_lable_customer_notes_controller" class="form-label"> عنوان حقل
                {{ $order_form->lable_customer_notes }}</label>
            <input type="text" class="form-control" id="form_lable_customer_notes_controller"
                name="form_lable_customer_notes_controller" placeholder="{{ $order_form->lable_customer_notes }}">
        </div>
        <div class="mb-3">
            <label for="form_placeholder_customer_notes_controller" class="form-label">الذي يظهر في حقل
                {{ $order_form->lable_customer_notes }}</label>
            <input type="text" class="form-control" id="form_placeholder_customer_notes_controller"
                name="form_placeholder_customer_notes_controller"
                placeholder="{{ $order_form->input_placeholder_customer_notes }}">
        </div>
        <div class="mb-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="form_required_customer_notes_controller" name="form_required_customer_notes_controller" {{ $order_form->customer_notes_required === 'true' ? 'checked' : '' }}>
                <label class="form-check-label"
                    for="form_required_customer_notes_controller">{{ $order_form->lable_customer_notes }}
                    مطلوب</label>
            </div>
        </div>
        <div class="mb-3">
            <div class="form-check form-switch">
                <input class="form-check-input" type="checkbox" id="form_required_customer_notes_status_controller"
                    name="form_required_customer_notes_status_controller" {{ $order_form->customer_notes_visible === 'true' ? 'checked' : '' }}>
                <label class="form-check-label" for="form_required_customer_address_controller">تفعيل حقل
                    {{ $order_form->lable_customer_notes }}</label>
            </div>
        </div>
    </div>
</div>
<!---->
<div class="card mb-3">
    <div class="card-header">
        <h5 class="card-title">خانة {{ $order_form->lable_product_coupon_code }}</h5>
    </div>
    <div class="card-body">
        <div class="mb-3">
            <label for="form_product_coupon_code_controller" class="form-label"> عنوان حقل
                {{ $order_form->lable_product_coupon_code }}</label>
            <input type="text" class="form-control" id="form_product_coupon_code_controller"
                name="form_product_coupon_code_controller"
                placeholder="{{ $order_form->lable_product_coupon_code }}">
        </div>
        <div class="mb-3">
            <label for="form_placeholder_coupon_code_controller" class="form-label">الذي يظهر في حقل
                {{ $order_form->lable_product_coupon_code }}</label>
            <input type="text" class="form-control" id="form_placeholder_coupon_code_controller"
                name="form_placeholder_coupon_code_controller"
                placeholder="{{ $order_form->input_placeholder_product_coupon_code }}">
        </div>
    </div>
</div>
</form>
