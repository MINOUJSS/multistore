        <div class="row g-3">
            <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="card bg-white text-white h-100 border-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 text-primary">
                            <i class="fa-solid fa-cart-arrow-down fa-2x me-2"></i>
                            <h5 class="card-title mb-0"> طلبات اليوم</h5>
                        </div>
                        <h2 class="card-text mb-2 text-primary">{{ $supplier->orderToDay->count() }}</h2>
                        <div class="d-flex align-items-center">
             
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="card bg-white text-success h-100 border-success">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fa-solid fa-cart-plus fa-2x me-2"></i>
                            <h5 class="card-title mb-0"> المؤكدة اليوم</h5>
                        </div>
                        <h2 class="card-text mb-2">{{ $supplier->orderConfirmedToDay->count() }}</h2>
                        <div class="d-flex align-items-center">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="card bg-white text-danger h-100 border-danger">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fa-solid fa-cart-shopping fa-2x me-2"></i>
                            <h5 class="card-title mb-0"> الملغاة اليوم</h5>
                        </div>
                        <h2 class="card-text mb-2">{{ $supplier->orderCanceledToDay->count() }}</h2>
                        <div class="d-flex align-items-center">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-3">
                <a class="text-decoration-none" href="{{route('supplier.orders-abandoned')}}">
                <div class="card bg-white text-warning h-100 border-warning">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fa-solid fa-dolly fa-2x me-2"></i>
                            <h5 class="card-title mb-0">المتروكة اليوم</h5>
                        </div>
                        <h2 class="card-text mb-2">{{ $supplier->orderAbandonedToDay->count() }}</h2>
                        <div class="d-flex align-items-center">
     
                        </div>
                    </div>
                </div>
                </a>
            </div>
        </div>