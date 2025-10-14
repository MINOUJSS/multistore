        <div class="row g-3 mt-2">
            <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="card bg-white text-white h-100 border-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 text-primary">
                            <i class="fa-solid fa-cart-arrow-down fa-2x me-2"></i>
                            <h5 class="card-title mb-0"> طلبات هذا الأسبوع</h5>
                        </div>
                        <h2 class="card-text mb-2 text-primary">{{ $supplier->ordersThisWeek->count() }}</h2>
                        <div class="d-flex align-items-center">
                            @if ($isWeekAllIncrease)
                                <i class="fa-solid fa-arrow-up text-success me-1"></i>
                                <small class="text-success">{{ $percentageAllWeekChange }} % عن الأسبوع الماضي</small>
                            @else
                                <i class="fa-solid fa-arrow-down text-danger me-1"></i>
                                <small class="text-danger">{{ $percentageAllWeekChange }} % عن الأسبوع الماضي</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="card bg-white text-success h-100 border-success">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fa-solid fa-cart-plus fa-2x me-2"></i>
                            <h5 class="card-title mb-0"> المؤكدة هذا الأسبوع</h5>
                        </div>
                        <h2 class="card-text mb-2">{{ $supplier->ordersConfirmedThisWeek->count() }}</h2>
                        <div class="d-flex align-items-center">
                            @if ($isWeekDeliveredIncrease)
                                <i class="fa-solid fa-arrow-up text-success me-1"></i>
                                <small class="text-success">{{ $percentageDeliveredWeekChange }} % عن الأسبوع الماضي</small>
                            @else
                                <i class="fa-solid fa-arrow-down text-danger me-1"></i>
                                <small class="text-danger">{{ $percentageDeliveredWeekChange }} % عن الأسبوع الماضي</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="card bg-white text-danger h-100 border-danger">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fa-solid fa-cart-shopping fa-2x me-2"></i>
                            <h5 class="card-title mb-0"> الملغاة هذا الأسبوع</h5>
                        </div>
                        <h2 class="card-text mb-2">{{ $supplier->ordersCanceledThisWeek->count() }}</h2>
                        <div class="d-flex align-items-center">
                            @if ($isWeekCanceledIncrease)
                                <i class="fa-solid fa-arrow-up text-danger me-1"></i>
                                <small class="text-danger">{{ $PercentageCanceledWeekChange }} % عن الأسبوع الماضي</small>
                            @else
                                <i class="fa-solid fa-arrow-down text-success me-1"></i>
                                <small class="text-success">{{ $PercentageCanceledWeekChange }} % عن الأسبوع الماضي</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="card bg-white text-primary h-100 border-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fa-solid fa-dolly fa-2x me-2"></i>
                            <h5 class="card-title mb-0">المكتملة هذا الأسبوع</h5>
                        </div>
                        <h2 class="card-text mb-2">{{ $supplier->ordersdeliveredThisWeek->count() }}</h2>
                        <div class="d-flex align-items-center">
                            @if ($isWeekConfirmedIncrease)
                                <i class="fa-solid fa-arrow-up text-success me-1"></i>
                                <small class="text-success">{{ $percentageConfirmedWeekChange }} % عن الأسبوع الماضي</small>
                            @else
                                <i class="fa-solid fa-arrow-down text-danger me-1"></i>
                                <small class="text-danger">{{ $percentageConfirmedWeekChange }} % عن الأسبوع الماضي</small>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>