<tbody>
    @if (session()->has('cart') && session()->get('cart')->totalQty > 0)

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
                {{-- {{dd($item['variation_ids'][$variation_ids[0]]);}} --}}
                @foreach ($item['attribute_ids'] as $attribute)
                    {{--  --}}
                    @if (count($variation_ids) > count($item['attribute_ids']))
                        <tr>
                            <td>
                                <div class="d-flex">
                                    <img src="{{ $item['image'] }}" alt="المنتج" class="product-img rounded ms-3">
                                    <div>
                                        <h6 class="mb-1"><a
                                                href="{{ route('tenant.product', $item['id']) }}">{{ $item['title'] }}</a>
                                        </h6>
                                        <small class="text-muted">

                                        </small>
                                    </div>
                                </div>
                            </td>

                            <td>{{ $item['price'] }} د.ج</td>


                            <td>
                                <div class="input-group input-group-sm quantity-control" style="width: 120px;"
                                    data-product-id="{{ $item['id'] }}"
                                    data-variation-id="{{ $variation_ids[$i] ?? 0 }}"
                                    data-attribute-id="{{ $attribute['attribute']['id'] ?? 0 }}">
                                    <button class="btn btn-outline-secondary decrement-btn" type="button">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    {{-- {{dd($item['variation_ids'][$variation_ids[$i]])}} --}}
                                    <input type="number" class="form-control quantity-input"
                                        value="{{ $item['variation_ids'][$variation_ids[$i]]['qty'] }}" min="1">
                                    <button class="btn btn-outline-secondary increment-btn" type="button">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </td>

                            <td class="item-total" data-product-id="{{ $item['id'] }}"
                                data-variation-id="{{ $variation_ids[$i] ?? 0 }}"
                                data-attribute-id="{{ $attribute['attribute']['id'] ?? 0 }}"
                                data-item-price="{{ $item['price'] + ($attribute['attribute']['additional_price'] ?? 0) }}">

                                {{ $item['price'] * $item['qty'] }}

                            </td>


                            <td>

                                {{-- {{dd($attribute['attribute'])}} --}}

                                @if (count($item['variation_ids']) > 1)
                                    <a href="{{ route('tenant.remove-from-cart-variation', [$item['id'], 0, 0]) }}"
                                        class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash-can"></i></a>
                                @else
                                    <a href="{{ route('tenant.remove-from-cart', $item['id']) }}"
                                        class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash-can"></i></a>
                                @endif
                            </td>
                        </tr>
                    @endif
                    {{-- product has attribute and variation  --}}
                    @if ($attribute['qty'] > 0)
                        <tr>
                            <td>
                                <div class="d-flex">
                                    <img src="{{ $item['image'] }}" alt="المنتج" class="product-img rounded ms-3">
                                    <div>
                                        <h6 class="mb-1"><a
                                                href="{{ route('tenant.product', $item['id']) }}">{{ $item['title'] }}</a>
                                        </h6>
                                        <small class="text-muted">

                                            @if (count($item['variation_ids']) > 1 &&
                                                    (!empty($attribute['attribute']) || count($attribute['attribute']) <= 1) &&
                                                    count($item['variation_ids']) > count($attribute['attribute']))
                                                اللون:
                                                @foreach ($item['variation_ids'] as $var)
                                                    @if (!empty($var['variation']))
                                                        {{ $var['qty'] }}
                                                        <span class="color-swatch"
                                                            style="background-color:{{ $var['variation']['color'] }}"></span>
                                                    @endif
                                                @endforeach
                                            @endif
                                            {{-- {{dd(session('cart'))}} --}}
                                            @if (!empty($attribute['attribute']))
                                                {{-- {{dd($variation_ids,$i)}} --}}
                                                اللون: <span class="color-swatch"
                                                    style="background-color:{{ get_supplier_product_variation_data($item['variation_ids'][$variation_ids[$i]]['variation']['id'])->color }}"></span>
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
                            </td>
                            @if (!empty($attribute['attribute']['additional_price']))
                                <td>{{ $item['price'] + $attribute['attribute']['additional_price'] }}
                                    د.ج</td>
                            @else
                                <td>{{ $item['price'] }} د.ج</td>
                            @endif

                            <td>
                                <div class="input-group input-group-sm quantity-control" style="width: 120px;"
                                    data-product-id="{{ $item['id'] }}"
                                    data-variation-id="{{ $variation_ids[$i] ?? 0 }}"
                                    data-attribute-id="{{ $attribute['attribute']['id'] ?? 0 }}">
                                    <button class="btn btn-outline-secondary decrement-btn" type="button">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    {{-- {{dd($item['variation_ids'][$variation_ids[$i]])}} --}}
                                    <input type="number" class="form-control quantity-input"
                                        @if (count($item['variation_ids']) > count($item['attribute_ids'])) value="{{ $item['qty'] }}"      
                                                                        @else
                                                                        value="{{ $attribute['qty'] }}" @endif
                                        min="1">
                                    <button class="btn btn-outline-secondary increment-btn" type="button">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </td>

                            <td class="item-total" data-product-id="{{ $item['id'] }}"
                                data-variation-id="{{ $variation_ids[$i] ?? 0 }}"
                                data-attribute-id="{{ $attribute['attribute']['id'] ?? 0 }}"
                                data-item-price="{{ $item['price'] + ($attribute['attribute']['additional_price'] ?? 0) }}">
                                @if (!empty($attribute['attribute']['additional_price']))
                                    {{ ($item['price'] + $attribute['attribute']['additional_price']) * $attribute['qty'] }}

                                    د.ج
                                @else
                                    @if (count($item['variation_ids']) > count($item['attribute_ids']))
                                        {{ $item['price'] * $item['qty'] }}
                                    @else
                                        {{ $item['price'] * $attribute['qty'] }}
                                        د.ج
                                    @endif
                                @endif
                            </td>


                            <td>

                                {{-- {{dd($attribute['attribute'])}} --}}
                                @if (!empty($attribute['attribute']))
                                    <a href="{{ route('tenant.remove-from-cart-variation', [$item['id'], $item['variation_ids'][$variation_ids[$i]]['variation']['id'], $attribute['attribute']['id']]) }}"
                                        class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash-can"></i></a>
                                @else
                                    @if (count($item['variation_ids']) > 1)
                                        <a href="{{ route('tenant.remove-from-cart-variation', [$item['id'], 0, 0]) }}"
                                            class="btn btn-sm btn-outline-danger"><i
                                                class="fa-solid fa-trash-can"></i></a>
                                    @else
                                        <a href="{{ route('tenant.remove-from-cart', $item['id']) }}"
                                            class="btn btn-sm btn-outline-danger"><i
                                                class="fa-solid fa-trash-can"></i></a>
                                    @endif
                                @endif
                            </td>
                        </tr>
                    @endif
                    @php
                        $i++;
                    @endphp
                @endforeach
            @else
                <tr>
                    <td>
                        <div class="d-flex">
                            <img src="{{ $item['image'] }}" alt="المنتج" class="product-img rounded ms-3">
                            <div>
                                <h6 class="mb-1"><a
                                        href="{{ route('tenant.product', $item['id']) }}">{{ $item['title'] }}</a>
                                </h6>
                                <small class="text-muted">

                                    {{-- @if (count($item['variation_ids']) > 1)
                                                                            @foreach ($item['variation_ids'] as $var)
                                                                                اللون: <span class="color-swatch"
                                                                                    style="background-color:{{ $var['color'] }}"></span>
                                                                            @endforeach
                                                                        @endif --}}
                                </small>
                            </div>
                        </div>
                    </td>
                    <td>{{ $item['price'] }} د.ج</td>

                    <td>
                        <div class="input-group input-group-sm quantity-control" style="width: 120px;"
                            data-product-id="{{ $item['id'] }}" data-variation-id="0" data-attribute-id="0">
                            <button class="btn btn-outline-secondary decrement-btn" type="button">
                                <i class="fas fa-minus"></i>
                            </button>
                            <input type="number" class="form-control quantity-input"
                                data-product-id="{{ $item['id'] }}" data-variation-id="0" data-attribute-id="0"
                                value="{{ $item['qty'] }}" min="1">
                            <button class="btn btn-outline-secondary increment-btn" type="button">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </td>

                    <td class="item-total" data-product-id="{{ $item['id'] }}" data-variation-id="0"
                        data-attribute-id="0" data-item-price="{{ $item['price'] }}">
                        {{ $item['price'] * $item['qty'] }} د.ج
                    </td>

                    <td>
                        <a href="{{ route('tenant.remove-from-cart', $item['id']) }}"
                            class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash-can"></i></a>
                    </td>
                </tr>
            @endif
        @endforeach
    @else
        <tr>
            <td colspan="5" class="text-center">لم يتم العثور على منتجات</td>
        </tr>
    @endif

</tbody>