<tbody>
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
                <tr>
                    <td>
                        <div class="d-flex">
                            <img src="{{ $item['image'] }}" alt="المنتج" class="product-img rounded ms-3">
                            <div>
                                <h6 class="mb-1"><a
                                        href="{{ route('tenant.product', $item['id']) }}">{{ $item['title'] }}</a>
                                </h6>
                                <small class="text-muted">
                                    {{-- normal --}}

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
                            {{-- {{dd($item['variation_ids'][$variation_ids[$i]])}} --}}
                            <input type="number" class="form-control quantity-input"
                                value="{{ $item['variation_ids'][0]['qty'] }}" min="{{ supplier_product_min_qty($item['id']) }}">
                            <button class="btn btn-outline-secondary increment-btn" type="button">
                                <i class="fas fa-plus"></i>
                            </button>
                        </div>
                    </td>

                    <td class="item-total" data-product-id="{{ $item['id'] }}" data-variation-id="0"
                            data-attribute-id="0" data-item-price="{{ $item['price'] }}">
                            {{ number_format($item['price'] * $item['qty'], 2) }} د.ج    
                    </td>


                    <td>
                        {{-- {{dd($attribute['attribute'])}} --}}
                        <a href="{{ route('tenant.remove-from-cart-variation', [$item['id'], 0, 0]) }}"
                            class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash-can"></i></a>
                    </td>
                </tr>
            @elseif(count($item['variation_ids']) > count($item['attribute_ids']))
                {{-- has color only  --}}
                @foreach ($item['variation_ids'] as $variation)
                    @if (!empty($variation['variation']))
                        <tr>
                            <td>
                                <div class="d-flex">
                                    <img src="{{ $item['image'] }}" alt="المنتج" class="product-img rounded ms-3">
                                    <div>
                                        <h6 class="mb-1"><a
                                                href="{{ route('tenant.product', $item['id']) }}">{{ $item['title'] }}</a>
                                        </h6>
                                        <small class="text-muted">
                                            {{-- color only --}}
                                            اللون: <span class="color-swatch"
                                                            style="background-color:{{ $variation['variation']['color'] }}"></span>
                                        </small>
                                    </div>
                                </div>
                            </td>

                            <td>{{ number_format($item['price'],2) }} د.ج</td>


                            <td>
                                <div class="input-group input-group-sm quantity-control" style="width: 120px;"
                                    data-product-id="{{ $item['id'] }}" data-variation-id="{{ $variation['id'] }}" data-attribute-id="0">
                                    <button class="btn btn-outline-secondary decrement-btn" type="button">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    {{-- {{dd($item['variation_ids'],$variation)}} --}}
                                    <input type="number" class="form-control quantity-input"
                                        value="{{ $variation['qty'] }}" min="{{supplier_product_min_qty($item['id'])}}">
                                    <button class="btn btn-outline-secondary increment-btn" type="button">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </td>

                            <td class="item-total" data-product-id="{{ $item['id'] }}" data-variation-id="{{ $variation['id'] }}"
                                data-attribute-id="0" data-item-price="{{ $item['price'] }}">

                                {{ number_format($item['price'] * $variation['qty'],2) }} د.ج

                            </td>


                            <td>
                                {{-- {{dd($attribute['attribute'])}} --}}
                                <a href="{{ route('tenant.remove-from-cart-variation', [$item['id'], $variation['id'], 0]) }}"
                                    class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash-can"></i></a>
                            </td>
                        </tr>
                    @else
                        @if ($item['attribute_ids'][0]['qty'] != 0)
                            <tr>
                                <td>
                                    <div class="d-flex">
                                        <img src="{{ $item['image'] }}" alt="المنتج"
                                            class="product-img rounded ms-3">
                                        <div>
                                            <h6 class="mb-1"><a
                                                    href="{{ route('tenant.product', $item['id']) }}">{{ $item['title'] }}</a>
                                            </h6>
                                            <small class="text-muted">
                                                normal form color only
                                            </small>
                                        </div>
                                    </div>
                                </td>

                                <td>{{ $item['price'] }} د.ج</td>


                                <td>
                                    <div class="input-group input-group-sm quantity-control" style="width: 120px;"
                                        data-product-id="{{ $item['id'] }}" data-variation-id="{{ $variation['id'] }}"
                                        data-attribute-id="0">
                                        <button class="btn btn-outline-secondary decrement-btn" type="button">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        <input type="number" class="form-control quantity-input"
                                            value="{{ $variation['qty'] }}" min="1">
                                        <button class="btn btn-outline-secondary increment-btn" type="button">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </td>

                                <td class="item-total" data-product-id="{{ $item['id'] }}" data-variation-id="0"
                                    data-attribute-id="0" data-item-price="{{ $item['price'] }}">

                                    {{ $item['price'] * $variation['qty'] }}

                                </td>


                                <td>
                                    {{-- {{dd($attribute['attribute'])}} --}}
                                    <a href="{{ route('tenant.remove-from-cart-variation', [$item['id'], $variation['id'], 0]) }}"
                                        class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash-can"></i></a>
                                </td>
                            </tr>
                        @endif
                    @endif
                @endforeach
            @elseif(count($item['variation_ids']) < count($item['attribute_ids']))
                {{-- has attribute only  --}}
                @foreach ($item['attribute_ids'] as $attribute)
                    @if (!empty($attribute['attribute']))
                        <tr>
                            <td>
                                <div class="d-flex">
                                    <img src="{{ $item['image'] }}" alt="المنتج" class="product-img rounded ms-3">
                                    <div>
                                        <h6 class="mb-1"><a
                                                href="{{ route('tenant.product', $item['id']) }}">{{ $item['title'] }}</a>
                                        </h6>
                                        <small class="text-muted">
                                            {{-- attribute only --}}
                                            {{get_supplier_attribute_data($attribute['attribute']['attribute_id'])->name}} :
                                            {{ $attribute['attribute']['value'] }}
                                        </small>
                                    </div>
                                </div>
                            </td>

                            <td>{{ number_format($item['price'] + $attribute['attribute']['additional_price'],2) }} د.ج</td>


                            <td>
                                <div class="input-group input-group-sm quantity-control" style="width: 120px;"
                                    data-product-id="{{ $item['id'] }}" data-variation-id="0"
                                    data-attribute-id="{{ $attribute['id'] }}">
                                    <button class="btn btn-outline-secondary decrement-btn" type="button">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    {{-- {{dd($item['variation_ids'][$variation_ids[$i]])}} --}}
                                    <input type="number" class="form-control quantity-input"
                                        value="{{ $attribute['qty'] }}" min="{{supplier_product_min_qty($item['id'])}}">
                                    <button class="btn btn-outline-secondary increment-btn" type="button">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </td>

                            <td class="item-total" data-product-id="{{ $item['id'] }}" data-variation-id="0"
                                data-attribute-id="{{ $attribute['attribute']['id'] }}"
                                data-item-price="{{ $item['price'] + $attribute['attribute']['additional_price'] }}">

                                {{ number_format(($item['price'] + $attribute['attribute']['additional_price']) * $attribute['qty'],2) }} د.ج

                            </td>


                            <td>
                                {{-- {{dd($attribute['attribute'])}} --}}
                                <a href="{{ route('tenant.remove-from-cart-variation', [$item['id'], 0, $attribute['id']]) }}"
                                    class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash-can"></i></a>
                            </td>
                        </tr>
                    @else
                        @if (!empty($item['variation_ids']) && $item['variation_ids'][0]['qty'] != 0)
                            <tr>
                                <td>
                                    <div class="d-flex">
                                        <img src="{{ $item['image'] }}" alt="المنتج"
                                            class="product-img rounded ms-3">
                                        <div>
                                            <h6 class="mb-1"><a
                                                    href="{{ route('tenant.product', $item['id']) }}">{{ $item['title'] }}</a>
                                            </h6>
                                            <small class="text-muted">
                                                normal from attrinute only
                                            </small>
                                        </div>
                                    </div>
                                </td>

                                <td>{{ $item['price'] }} د.ج</td>


                                <td>
                                    <div class="input-group input-group-sm quantity-control" style="width: 120px;"
                                        data-product-id="{{ $item['id'] }}" data-variation-id="0"
                                        data-attribute-id="{{ $attribute['id'] }}">
                                        <button class="btn btn-outline-secondary decrement-btn" type="button">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        {{-- {{dd($item['variation_ids'][$variation_ids[$i]])}} --}}
                                        <input type="number" class="form-control quantity-input"
                                            value="{{ $attribute['qty'] }}" min="1">
                                        <button class="btn btn-outline-secondary increment-btn" type="button">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </td>

                                <td class="item-total" data-product-id="{{ $item['id'] }}" data-variation-id="0"
                                    data-attribute-id="{{ $attribute['id'] }}"
                                    data-item-price="{{ $item['price'] }}">

                                    {{ $item['price'] * $attribute['qty'] }}

                                </td>


                                <td>
                                    {{-- {{dd($attribute['attribute'])}} --}}
                                    <a href="{{ route('tenant.remove-from-cart-variation', [$item['id'], 0, $attribute['id']]) }}"
                                        class="btn btn-sm btn-outline-danger"><i
                                            class="fa-solid fa-trash-can"></i></a>
                                </td>
                            </tr>
                        @endif
                    @endif
                @endforeach
            @elseif(count($item['variation_ids']) == count($item['attribute_ids']))
                {{-- has attributes and varitions  --}}
                @foreach ($item['attribute_ids'] as $attribute)
                    @if (!empty($attribute['attribute']))
                        <tr>
                            <td>
                                <div class="d-flex">
                                    <img src="{{ $item['image'] }}" alt="المنتج" class="product-img rounded ms-3">
                                    <div>
                                        <h6 class="mb-1"><a
                                                href="{{ route('tenant.product', $item['id']) }}">{{ $item['title'] }}</a>
                                        </h6>
                                        <small class="text-muted">


                                            {{-- has attributes and colors
                                            |varition_id:{{ $item['variation_ids'][$variation_ids[$i]]['id'] }}|attr_id:{{ $attribute['id'] }} --}}
                                    
                                    
                                            اللون: <span class="color-swatch"
                                                            style="background-color:{{ $variation['variation']['color'] }}"></span>
                                       

                                
                                            | {{get_supplier_attribute_data($attribute['attribute']['attribute_id'])->name}} :
                                            {{ $attribute['attribute']['value'] }}
                                      
                                        </small>
                                    </div>
                                </div>
                            </td>
                            @if (!empty($attribute['attribute']['additional_price']))
                                <td>{{ number_format($item['price'] + $attribute['attribute']['additional_price'],2) }}
                                    د.ج</td>
                            @else
                                <td>{{ number_format($item['price'],2) }} د.ج</td>
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
                                        min="{{supplier_product_min_qty($item['id'])}}">
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
                                    {{ number_format(($item['price'] + $attribute['attribute']['additional_price']) * $attribute['qty'],2) }}

                                    د.ج
                                @else
                                    @if (count($item['variation_ids']) > count($item['attribute_ids']))
                                        {{ number_format($item['price'] * $item['qty'],2) }}
                                    @else
                                        {{ number_format($item['price'] * $attribute['qty'],2) }}
                                        د.ج
                                    @endif
                                @endif
                            </td>


                            <td>

                                {{-- {{dd($attribute['attribute'])}} --}}
                                {{-- @if (!empty($attribute['attribute'])) --}}
                                <a href="{{ route('tenant.remove-from-cart-variation', [$item['id'], $item['variation_ids'][$variation_ids[$i]]['variation']['id'], $attribute['attribute']['id']]) }}"
                                    class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash-can"></i></a>
                                {{-- @else
                                @if (count($item['variation_ids']) > 1)
                                    <a href="{{ route('tenant.remove-from-cart-variation', [$item['id'], 0, 0]) }}"
                                        class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash-can"></i></a>
                                @else
                                    <a href="{{ route('tenant.remove-from-cart', $item['id']) }}"
                                        class="btn btn-sm btn-outline-danger"><i class="fa-solid fa-trash-can"></i></a>
                                @endif
                            @endif --}}
                            </td>
                        </tr>
                        @php
                            $i++;
                        @endphp
                    @else
                        {{-- when attribute id =0 --}}
                        @if (!empty($item['variation_ids'][$variation_ids[$i]]['variation']))
                            <tr>
                                <td>
                                    <div class="d-flex">
                                        <img src="{{ $item['image'] }}" alt="المنتج"
                                            class="product-img rounded ms-3">
                                        <div>
                                            <h6 class="mb-1"><a
                                                    href="{{ route('tenant.product', $item['id']) }}">{{ $item['title'] }}</a>
                                            </h6>
                                            <small class="text-muted">
                                                normal from
                                                var=attr|variation_id:{{ $item['variation_ids'][$variation_ids[$i]]['id'] }}
                                            </small>
                                        </div>
                                    </div>
                                </td>

                                <td>{{ $item['price'] }} د.ج</td>


                                <td>
                                    <div class="input-group input-group-sm quantity-control" style="width: 120px;"
                                        data-product-id="{{ $item['id'] }}" data-variation-id="0"
                                        data-attribute-id="0">
                                        <button class="btn btn-outline-secondary decrement-btn" type="button">
                                            <i class="fas fa-minus"></i>
                                        </button>
                                        {{-- {{dd($item['variation_ids'][$variation_ids[$i]])}} --}}
                                        <input type="number" class="form-control quantity-input"
                                            value="{{ $item['variation_ids'][0]['qty'] }}" min="1">
                                        <button class="btn btn-outline-secondary increment-btn" type="button">
                                            <i class="fas fa-plus"></i>
                                        </button>
                                    </div>
                                </td>

                                <td class="item-total" data-product-id="{{ $item['id'] }}" data-variation-id="0"
                                    data-attribute-id="0" data-item-price="{{ $item['price'] }}">

                                    {{ $item['price'] * $attribute['qty'] }}

                                </td>


                                <td>
                                    {{-- {{dd($attribute['attribute'])}} --}}
                                    <a href="{{ route('tenant.remove-from-cart-variation', [$item['id'], 0, 0]) }}"
                                        class="btn btn-sm btn-outline-danger"><i
                                            class="fa-solid fa-trash-can"></i></a>
                                </td>
                            </tr>
                        @endif
                        @php
                            $i++;
                        @endphp
                    @endif
                @endforeach
                {{-- @php
                    $i++;
                @endphp --}}
            @else
                <tr>
                    <td colspan="5" class="text-center">لم يتم التعرف على الحدث</td>
                </tr>
            @endif
        @endforeach
    @else
        <tr>
            <td colspan="5" class="text-center">لم يتم العثور على منتجات</td>
        </tr>
    @endif

</tbody>
