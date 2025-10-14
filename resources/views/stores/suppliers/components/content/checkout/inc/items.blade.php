    @if (session()->has('cart') && session()->get('cart')->totalQty > 0)

        @foreach (session('cart')->items as $item)
            @php
                $i = 0;
                $variation_ids = [];
            @endphp
            @foreach ($item['variation_ids'] as $index => $variation)
                @php
                    $variation_ids[] = $index;
                @endphp
            @endforeach
            {{-- has normal product  --}}
            @if (count($item['variation_ids']) == 1 && count($item['attribute_ids']) == 1 && !empty($item['variation_ids'][0]))
                <div class="product-item d-flex align-items-start">
                    <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="me-3 rounded" width="60"
                        height="60">
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between">
                            <span class="fw-semibold">{{ $item['title'] }}</span>
                            <span>{{ $item['price'] }} د.ج</span>
                        </div>
                        <small class="text-muted d-block">الكمية: {{ $item['qty'] }}</small>
                        {{-- <small class="text-muted d-block">اللون: أبيض</small> --}}
                        <small class="text-muted">
                            {{-- normal --}}
                        </small>
                    </div>
                </div>
            @elseif(count($item['variation_ids']) > count($item['attribute_ids']))
                {{-- has color only  --}}
                @foreach ($item['variation_ids'] as $variation)
                    @if (!empty($variation['variation']))
                        <div class="product-item d-flex align-items-start">
                            <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="me-3 rounded"
                                width="60" height="60">
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <span class="fw-semibold">{{ $item['title'] }}</span>
                                    <span>{{ $item['price'] }} د.ج</span>
                                </div>
                                <small class="text-muted d-block">الكمية: {{ $item['qty'] }}</small>
                                {{-- <small class="text-muted d-block">اللون: أبيض</small> --}}
                                <small class="text-muted">
                                    {{-- color only --}}
                                    اللون: <span class="color-swatch"
                                                            style="background-color:{{ $variation['variation']['color'] }}"></span>
                                </small>
                            </div>
                        </div>
                    @else
                        @if ($item['attribute_ids'][0]['qty'] != 0)
                            <div class="product-item d-flex align-items-start">
                                <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="me-3 rounded"
                                    width="60" height="60">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <span class="fw-semibold">{{ $item['title'] }}</span>
                                        <span>{{ $item['price'] }} د.ج</span>
                                    </div>
                                    <small class="text-muted d-block">الكمية: {{ $item['qty'] }}</small>
                                    {{-- <small class="text-muted d-block">اللون: أبيض</small> --}}
                                    <small class="text-muted">
                                        normal from color only
                                    </small>
                                </div>
                            </div>
                        @endif
                    @endif
                @endforeach
            @elseif(count($item['variation_ids']) < count($item['attribute_ids']))
                {{-- has attribute only  --}}
                @foreach ($item['attribute_ids'] as $attribute)
                    @if (!empty($attribute['attribute']))
                        <div class="product-item d-flex align-items-start">
                            <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="me-3 rounded"
                                width="60" height="60">
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <span class="fw-semibold">{{ $item['title'] }}</span>
                                    <span>{{ $item['price']+ $attribute['attribute']['additional_price'] }} د.ج</span>
                                </div>
                                <small class="text-muted d-block">الكمية: {{ $item['qty'] }}</small>
                                {{-- <small class="text-muted d-block">اللون: أبيض</small> --}}
                                <small class="text-muted">
                                    {{-- attribute only --}}
                                    {{get_supplier_attribute_data($attribute['attribute']['attribute_id'])->name}} :
                                            {{ $attribute['attribute']['value'] }}
                                </small>
                            </div>
                        </div>
                    @else
                        @if (!empty($item['variation_ids']) && $item['variation_ids'][0]['qty'] != 0)
                            <div class="product-item d-flex align-items-start">
                                <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="me-3 rounded"
                                    width="60" height="60">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <span class="fw-semibold">{{ $item['title'] }}</span>
                                        <span>{{ $item['price'] }} د.ج</span>
                                    </div>
                                    <small class="text-muted d-block">الكمية: {{ $item['qty'] }}</small>
                                    {{-- <small class="text-muted d-block">اللون: أبيض</small> --}}
                                    <small class="text-muted">
                                        normal from attribute only
                                    </small>
                                </div>
                            </div>
                        @endif
                    @endif
                @endforeach
            @elseif(count($item['variation_ids']) == count($item['attribute_ids']))
                {{-- has attributes and varitions  --}}
                @foreach ($item['attribute_ids'] as $attribute)
                    @if (!empty($attribute['attribute']))
                        <div class="product-item d-flex align-items-start">
                            <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="me-3 rounded"
                                width="60" height="60">
                            <div class="flex-grow-1">
                                <div class="d-flex justify-content-between">
                                    <span class="fw-semibold">{{ $item['title'] }}</span>
                                    <span>{{ $item['price'] }} د.ج</span>
                                </div>
                                <small class="text-muted d-block">الكمية: {{ $item['qty'] }}</small>
                                {{-- <small class="text-muted d-block">اللون: أبيض</small> --}}
                                <small class="text-muted">
                                    {{-- has attribute and color --}}
                                    اللون: <span class="color-swatch"
                                                            style="background-color:{{ $variation['variation']['color'] }}"></span>
                                    |
                                    {{get_supplier_attribute_data($attribute['attribute']['attribute_id'])->name}} :
                                            {{ $attribute['attribute']['value'] }}
                                </small>
                            </div>
                        </div>
                        @php
                            $i++;
                        @endphp
                    @else
                        {{-- when attribute id =0 --}}
                        @if (!empty($item['variation_ids'][$variation_ids[$i]]['variation']))
                            <div class="product-item d-flex align-items-start">
                                <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="me-3 rounded"
                                    width="60" height="60">
                                <div class="flex-grow-1">
                                    <div class="d-flex justify-content-between">
                                        <span class="fw-semibold">{{ $item['title'] }}</span>
                                        <span>{{ $item['price'] }} د.ج</span>
                                    </div>
                                    <small class="text-muted d-block">الكمية: {{ $item['qty'] }}</small>
                                    {{-- <small class="text-muted d-block">اللون: أبيض</small> --}}
                                    <small class="text-muted">
                                        normal from var = attr
                                    </small>
                                </div>
                            </div>
                        @endif
                        @php
                            $i++;
                        @endphp
                    @endif
                @endforeach
            @else
                <div class="product-item d-flex align-items-start">
                    <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}" class="me-3 rounded" width="60"
                        height="60">
                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between">
                            <span class="fw-semibold">{{ $item['title'] }}</span>
                            <span>{{ $item['price'] }} د.ج</span>
                        </div>
                        <small class="text-muted d-block">الكمية: {{ $item['qty'] }}</small>
                        {{-- <small class="text-muted d-block">اللون: أبيض</small> --}}
                        <small class="text-muted">
                            لم يتم التعرف على المواصفات
                        </small>
                    </div>
                </div>
            @endif
        @endforeach
    @else
        <p colspan="5" class="text-center">لم يتم العثور على منتجات</p>

    @endif
