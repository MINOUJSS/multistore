<div class="container">
    <h1 class="text-center mb-4">المشتركين</h1>
    <div class="row">
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">الموردين</h5>
                    <p class="card-text">عرض طلبات اشتراك الموردين</p>
                    <a href="{{ route('admin.payments.suppliers.subscribes_payments') }}" class="btn btn-primary">عرض</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">البائعين</h5>
                    <p class="card-text">عرض طلبات اشتراك البائعين</p>
                    <a href="{{ route('admin.payments.sellers.subscribes_payments') }}" class="btn btn-primary">عرض</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-body">
                    <h5 class="card-title">الشركاء</h5>
                    <p class="card-text">عرض طلبات اشتراك الشركاء</p>
                    <a href="{{-- route('admin.subscribes.affiliates.index') --}}" class="btn btn-primary">عرض</a>
                </div>
            </div>
        </div>
    </div>
</div>
