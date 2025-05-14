<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-12 col-md-10 col-lg-8">

            <div class="card shadow border-0 rounded-4">
                <div class="card-body p-4 p-md-5">

                    <h3 class="text-center text-primary fw-bold mb-4">تأكيد الاشتراك بالخطة</h3>

                    <!-- معلومات الخطة -->
                    <div class="bg-light border rounded-3 p-3 p-md-4 mb-4">
                        <h4 class="mb-1 fw-semibold">الخطة: {{ get_supplier_plan_data($order->plan_id)->name }}</h4>
                        <p class="text-muted small mb-2">{{get_supplier_plan_data($order->plan_id)->description}}</p>
                        <h5 class="text-success">{{ $plan_price }} <sup>د.ج</sup> / {{ $subscriptionDuration }} يوم</h5>

                        <ul class="list-unstyled mt-3">
                            @foreach (get_supplier_plan_data($order->plan_id)->authorizations as $item)
                                <li class="mb-2 d-flex align-items-center">
                                    <i class="fa @if($item->is_enabled) fa-check-circle text-success @else fa-times-circle text-danger @endif me-2"></i>
                                    <span>{{ $item->description }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- ملخص الاشتراك -->
                    @php
                        $rest_days = $old_subscription->duration - appDiffInDays(now(), $old_subscription->subscription_start_date);
                        $subscription_rest = get_rest_off_current_supplier_plan(
                            $old_subscription->supplier_id,
                            $old_subscription->plan_id,
                            $order->plan_id,
                            $rest_days
                        );

                        // if ($old_subscription->plan_id == 1 && in_array($order->plan_id, [2, 3]))
                        //     {
                        //         // $total=$order->price;
                        //         $total=$plan_price;
                        //     }
                        //     else
                        //     {
                        //         $total=get_rest_off_current_supplier_plan($old_subscription->supplier_id, $old_subscription->plan_id, $order->plan_id, $rest_days) ;
                        //     }
                            //$total = $total - $subscription_rest;
                        //     dd($subscription_rest);
                        //$total = $order->price - $subscription_rest;
                        $total=$order->price;
                    @endphp

                    @if ($old_subscription->plan_id == 1 && in_array($order->plan_id, [2, 3]))
                        <div class="bg-white border rounded-3 p-3 mb-4">
                            <h5 class="fw-bold mb-3">ملخص الاشتراك الجديد</h5>
                            <ul class="list-unstyled">
                                <li>المدة المتبقية: <span class="fw-bold text-muted">مدى الحياة</span></li>
                                <li>المبلغ المطلوب: <span class="fw-bold text-primary">{{ $total }} د.ج</span></li>
                            </ul>
                        </div>
                    @elseif ($old_subscription->plan_id == 2 && $order->plan_id == 3)
                        <div class="bg-white border rounded-3 p-3 mb-4">
                            <h5 class="fw-bold mb-3">ملخص الاشتراك الجديد</h5>
                            <ul class="list-unstyled">
                                <li>المدة المتبقية: <span class="fw-bold">{{ $rest_days }} يوم</span></li>
                                <li>القيمة المتبقية: <span class="fw-bold text-success">{{ $subscription_rest }} د.ج</span></li>
                                <li>المبلغ المطلوب: <span class="fw-bold text-primary">{{ $total<0 ? 0 : $total }} د.ج</span></li>
                            </ul>
                        </div>
                    @endif

                    <!-- نموذج الدفع -->
                    <form action="{{route('supplier.subscription.paymethod.redirect')}}" method="POST">
                        @csrf
                        <input type="hidden" name="order_id" value="{{$order->id}}">
                        <input type="hidden" name="plan_id" value="{{$order->plan_id}}">
                        <input type="hidden" name="old_plan_id" value="{{$old_subscription->plan_id}}">
                        <input type="hidden" name="sub_plan_id" value="{{$sub_plan!==null ? $sub_plan->id : '0'}}">
                        <div class="mb-4">
                            @if ($order->price<=0)
                                <p class="text-success fw-bold text-center">بالضغط على زر تأكيد الطلب يتم الإنتقال إلى الخطة  {{ get_supplier_plan_data($order->plan_id)->name }} و شحن الرصيد بـ: {{ abs(get_plan_price_from_id_and_duration($order->plan_id, $order->duration) - $old_subscription->price) }} د.ج </p>
                                <input type="hidden" name="paymentMethod" value="system">
                            @else
                            <label for="paymentMethod" class="form-label fw-semibold">طريقة الدفع</label>
                            <select class="form-select" id="paymentMethod" name="paymentMethod" required>
                                <option value="">-- اختر طريقة الدفع --</option>
                                <option value="Chargily">Chargily</option>
                                <option value="baridimob">بريدي موب</option>
                                <option value="ccp">CCP</option>
                                <option value="wallet">المحفظة</option>
                            </select>
                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary w-100 py-2">
                            <i class="fa fa-credit-card me-2"></i> تأكيد الطلب
                        </button>
                    </form>

                    <!-- ملاحظة -->
                    <p class="text-muted small mt-4 text-center">
                        سيتم تفعيل الخطة مباشرة بعد تأكيد الدفع.
                    </p>

                </div>
            </div>

        </div>
    </div>
</div>
