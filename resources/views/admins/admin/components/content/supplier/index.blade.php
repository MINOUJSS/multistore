<div class="container">
    <h1>الموردون</h1>
<div class="messages">
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
        </div>
    @endif
</div>
<div class="card">
    <div class="card-header">
      جدول الموردون
    </div>
    <div class="card-body">
      {{-- start table  --}}
      <div class="table-responsive">
      <table class="table table-sm">
        <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">الإسم الكامل</th>
            <th scope="col">البريد الإلكتروني</th>
            <th scope="col">رقم الهاتف</th>
            <th scope="col">إسم المتجر</th>
            <th scope="col">الحالة</th>
            <th scope="col">التقييم</th>
            <th scope="col">عدد المنتجات</th>
            <th scope="col">تاريخ التسجيل</th>
            <th scope="col">عدد الطلبيات</th>
            <th scope="col">تاريخ نهاية الإشتراك</th>
            <th scope="col">العمليات</th>
          </tr>
          @if ($suppliers->count() > 0)
          @foreach ($suppliers as $index =>$supplier)
          <tr>
            <th scope="row">{{$index+1}}</th>
            <td>{{$supplier->full_name}}</td>
            <td>{{$supplier->email}}</td>
            <td>{{$supplier->phone}}</td>
            <td>{{get_supplier_store_name($supplier->tenant->id)}}</td>
            <td>{{get_supplier_status($supplier->tenant->id)}}</td>
            <td>التقييم</td>
            <td>عدد المنتجات</td>
            <td>{{$supplier->created_at->format('d-m-Y')}}</td>
            <td>عدد الطلبات</td>
            <td>تاريخ نهاية الإشتراك</td>
            <td>
              <div class="btn-group" role="group">
                <button id="btnGroupDrop1" type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                  العمليات
                </button>
                <ul class="dropdown-menu" aria-labelledby="btnGroupDrop1">
                  <li><a class="dropdown-item" href="#">تفعيل الحساب</a></li>
                  <li>
                    <form action="{{route('admin.supplier.destroy', $supplier->id)}}" method="POST">
                      @csrf
                      @method('DELETE')
                      <button type="submit" class="dropdown-item text-danger"><i class="fa-solid fa-trash"></i> حذف الحساب</button>
                    </form>
                  </li>
                </ul>
              </div>
            </td>
          </tr>
          @endforeach
          @else
            <th>
              <td>لا يوجد موردين</td>
            </th> 
          @endif       
        </thead>
        <tbody>
      </table>
      {{-- end table  --}}
      </div>
    </div>
  </div>
</div>