<div class="container mt-4">
    <h1 class="text-center mb-4">الاشتراك</h1>
    <div class="card">
        <div class="card-body">
            <h5 class="fw-bold text-center">الخطط المتاحة</h5>
            <div class="row mt-3">
                @foreach ($plans as $plan)
                    @php
                        // تحديد ما إذا كانت هذه الخطة هي المفعلة حالياً
                        $isActive = $plan->id == get_supplier_subscription_data(get_supplier_data(auth()->user()->tenant_id)->id)->plan_id; // تحديد الباقة الأولى كـ "مفعلة"
                        
                        // مميزات الخطة مع حالة التوافر
                        $authorizations = $plan->Authorizations;
                        $pricing=$plan->pricing;
                    @endphp
                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="card shadow-sm {{ $isActive ? 'active-plan' : '' }}">
                            <div class="card-header text-center bg-primary text-white">
                                <h5 class="mb-1">الخطة {{ $plan->name }}</h5>
                                <form action="{{route('supplier.subscription.order.plan',$plan->id)}}" method="POST" class="text-center">
                                    @csrf
                                @if ($pricing->count() > 0)
                                    <b class="fs-4">{{ $plan->price }}<sup>د.ج</sup></b>
                                    <span class="text-muted">/ الشهر</span>
                                <div style="{{$plan->id==get_supplier_data(auth()->user()->tenant_id)->plan_subscription->plan_id || get_supplier_data(auth()->user()->tenant_id)->plan_subscription->plan_id==3? 'display:none;' : ''}}">
                                    <hr>
                                    <h4>عروض الخطة</h4>
                                    <ul class="list-group">
                                        <li class="list-group-item d-flex align-items-center justify-content-between subscription-option">
                                            <label class="mb-0 w-100 cursor-pointer">
                                                <input type="radio" name="sub_plan_id" value="0" checked class="form-check-input me-2">
                                                <span>{{ $plan->price }}<sup> د.ج</sup> / 30 يوم</span>
                                            </label>
                                        </li>
                                        @foreach ($pricing as $price)
                                            <li class="list-group-item d-flex align-items-center justify-content-between subscription-option">
                                                <label class="mb-0 w-100 cursor-pointer">
                                                    <input type="radio" name="sub_plan_id" value="{{ $price->id }}" class="form-check-input me-2">
                                                    <span>{{ $price->price }}<sup> د.ج</sup> / {{ $price->duration }} يوم</span>
                                                </label>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                                    
                                @else
                                <b class="fs-4">{{ $plan->price }}<sup>د.ج</sup></b>
                                <span class="text-muted">/ الشهر</span>
                                @endif
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush mb-3">
                                    @foreach ($authorizations as $authorization)
                                        <li class="list-group-item">
                                            @if ($authorization['is_enabled'])
                                                <i class="fas fa-check-circle text-success"></i> {{ $authorization['description'] }}
                                            @else
                                                <i class="fas fa-times-circle text-danger"></i> {{ $authorization['description'] }} <span class="text-muted">(غير متاح)</span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                                {{-- <form action="{{route('supplier.subscription.order.plan',$plan->id)}}" method="POST" class="text-center">
                                    @csrf --}}
                                    <button type="submit" class="btn btn-success w-100" {{ $isActive ? 'Disabled' : '' }} {{$plan->id==1 || $plan->id==get_supplier_data(auth()->user()->tenant_id)->plan_subscription->plan_id || get_supplier_data(auth()->user()->tenant_id)->plan_subscription->plan_id==3? 'hidden' : ''}}>قم بالترقية الآن</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>



