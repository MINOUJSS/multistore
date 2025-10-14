                        @if (session()->has('cart') && session()->get('cart')->totalPrice != null)
                            @foreach (session('cart')->items as $item)
                                @if (count($item['variation_ids']) >= 1)
                                    @php
                                        $i = 0;
                                        $variation_ids = [];
                                    @endphp
                                    @foreach ($item['variation_ids'] as $index => $variation)
                                        @php
                                            $variation_ids[] = $index;
                                        @endphp
                                    @endforeach
                                    {{-- {{dd($variation_ids[1]['variation']['id']);}} --}}
                                    @foreach ($item['attribute_ids'] as $attribute)
                                        <div class="product-item d-flex align-items-start">
                                            <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}"
                                                class="me-3 rounded" width="60" height="60">
                                            <div class="flex-grow-1">
                                                <div class="d-flex justify-content-between">
                                                    <span class="fw-semibold">{{ $item['title'] }}</span>
                                                    @if (!empty($attribute['attribute']['additional_price']))
                                                        <span>{{ number_format(($item['price'] + $attribute['attribute']['additional_price']) * $attribute['qty'], 2) }}
                                                            د.ج</span>
                                                    @else
                                                        <span>{{ $item['price'] * $attribute['qty'] }} د.ج</span>
                                                    @endif
                                                </div>
                                                <small class="text-muted d-block">الكمية:
                                                    {{ $attribute['qty'] }}</small>
                                                {{-- <small class="text-muted d-block">اللون: أبيض</small> --}}
                                                <small class="text-muted">
                                                    @if (!empty($attribute['attribute']))
                                                        اللون: <span class="color-swatch"
                                                            style="background-color:{{ get_supplier_product_variation_data($item['variation_ids'][$variation_ids[$i]]['variation']['id'])->color }}">C</span>
                                                    @endif

                                                    @if (!empty($attribute['attribute']))
                                                        | المقاس:
                                                        {{ get_supplier_product_variation_data($item['variation_ids'][$variation_ids[$i]]['variation']['id'])->size }}
                                                    @endif
                                                    @if (!empty($attribute['attribute']))
                                                        | الوزن:
                                                        {{ get_supplier_product_variation_data($item['variation_ids'][$variation_ids[$i]]['variation']['id'])->weight }}
                                                    @endif
                                                </small>
                                            </div>
                                        </div>
                                        @php
                                            $i++;
                                        @endphp
                                    @endforeach
                                @else
                                    <div class="product-item d-flex align-items-start">
                                        <img src="{{ $item['image'] }}" alt="{{ $item['title'] }}"
                                            class="me-3 rounded" width="60" height="60">
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between">
                                                <span class="fw-semibold">{{ $item['title'] }}</span>
                                                <span>{{ $item['price'] }} د.ج</span>
                                            </div>
                                            <small class="text-muted d-block">الكمية: {{ $item['qty'] }}</small>
                                            {{-- <small class="text-muted d-block">اللون: أبيض</small> --}}
                                            <small class="text-muted">
                                                {{-- @if ($item['color'] != null)
                                                        اللون: <span class="color-swatch" style="background-color:{{$item['color']}}"></span>
                                                        @endif
                                                        
                                                        @if ($item['size'] != null)
                                                        | المقاس: {{$item['size']}} 
                                                        @endif
                                                        @if ($item['weight'] != null)
                                                        | الوزن: {{$item['weight']}}
                                                        @endif --}}
                                            </small>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                        @endif