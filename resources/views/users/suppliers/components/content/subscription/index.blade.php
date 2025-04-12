{{-- <div class="container">
    <h1>الإشتراك</h1>
        <div class="card">
            <div class="card-body">
              <h5>الخطط</h5>
              <hr>
              @foreach ($plans as $plan)
              <div class="col-4" style="float:right;padding:2px;">
                <div class="card">
                    <div class="card-header text-center">
                        الخطة {{$plan->name}}
                        <br>
                        <b>{{$plan->price}}<sup>د.ج</sup></b><span> في الشهر</span>
                    </div>
                    <div class="card-body">
                        <hr>
                        <form action="" class="text-center">
                            <button type="submit" class="btn btn-primary">اشتراك</button>
                        </form>
                    </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
</div> --}}
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
                        $features = $plan->features;
                    @endphp
                    <div class="col-md-4 col-sm-6 mb-3">
                        <div class="card shadow-sm {{ $isActive ? 'active-plan' : '' }}">
                            <div class="card-header text-center bg-primary text-white">
                                <h5 class="mb-1">الخطة {{ $plan->name }}</h5>
                                <b class="fs-4">{{ $plan->price }}<sup>د.ج</sup></b>
                                <span class="text-muted">/ الشهر</span>
                            </div>
                            <div class="card-body">
                                <ul class="list-group list-group-flush mb-3">
                                    @foreach ($features as $feature)
                                        <li class="list-group-item">
                                            @if ($feature['available'])
                                                <i class="fas fa-check-circle text-success"></i> {{ $feature['name'] }}
                                            @else
                                                <i class="fas fa-times-circle text-danger"></i> {{ $feature['name'] }} <span class="text-muted">(غير متاح)</span>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                                <form action="" method="POST" class="text-center">
                                    @csrf
                                    <button type="submit" class="btn btn-success w-100" {{ $isActive ? 'Disabled' : '' }}>اشترك الآن</button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</div>



