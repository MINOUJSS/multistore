@if($products->count()>=1)
@foreach ($products as $product)
<tr>
    <td><img src="{{asset($product->image)}}" alt="Product" width="50"></td>
    <td>{{$product->name}}</td>
    <td>{{get_seller_product_category($product->id)}}</td>
    <td>{{get_seller_product_price($product->id)}}</td>
    <td>{{$product->cost}}</td>
    <td>{{$product->qty}}</td>
    <td>{{$product->minimum_order_qty}}</td>
    <td>{{seller_p_has_free_shipping($product->id)}}</td>
    <td><span class="badge bg-success">{{$product->status}}</span></td>
    <td>
        <button value="{{$product->id}}" class="btn btn-sm btn-info editproduct" data-bs-toggle="modal" data-bs-target="#editModal">
            <i class="fas fa-edit"></i>
        </button>
        <button class="btn btn-sm btn-danger delete-product" value="{{$product->id}}" data-id="{{$product->id}}">
            <i class="fas fa-trash"></i>
        </button>
    </td>
</tr>
@endforeach    
@else
<tr><td colspan="10" class="text-center">لم يتم العثور على أي منتج</td></tr> 
@endif