<div class="container py-4">

    <!-- عنوان الصفحة -->
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center mb-4">
        <h4 class="mb-3 mb-md-0 text-primary fw-bold">
            <i class="fa-solid fa-folder-open me-2 text-warning"></i>
            أرشيف ملفات النزاعات (PDF)
        </h4>

        <!-- مربع البحث -->
        <form method="GET" action="{{-- route('admin.disputes.archive') --}}" class="d-flex w-100 w-md-auto" role="search">
            <input 
                type="text" 
                name="search" 
                class="form-control form-control-sm me-2 shadow-sm" 
                placeholder="🔍 ابحث عن رقم النزاع أو المورد..." 
                value="{{ request('search') }}"
            >
            <button class="btn btn-sm btn-primary shadow-sm">
                <i class="fa-solid fa-magnifying-glass"></i> بحث
            </button>
        </form>
    </div>

    <!-- حالة لا يوجد بيانات -->
    @if ($archives->isEmpty())
        <div class="alert alert-info text-center shadow-sm">
            <i class="fa-solid fa-circle-info"></i> لا توجد ملفات أرشيف حاليًا.
        </div>
    @else

        <!-- جدول الأرشيف -->
        <div class="card shadow-sm border-0">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table align-middle table-hover mb-0">
                        <thead class="table-light text-center">
                            <tr>
                                <th>#</th>
                                <th>اسم الملف</th>
                                <th>رقم النزاع</th>
                                <th>معرف البائع</th>
                                <th>اسم الزبون</th>
                                <th>رقم هاتف الزبون</th>
                                <th>البريد الألكتروني للزبون</th>
                                <th>تاريخ الإنشاء</th>
                                <th>العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($archives as $archive)
                                <tr class="text-center">
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-truncate" style="max-width: 200px;">
                                        <i class="fa-solid fa-file-pdf text-danger me-1"></i>
                                        {{ $archive->file_name }}
                                    </td>
                                    <td><span class="badge bg-secondary">{{ $archive->dispute_id ?? '-' }}</span></td>
                                    <td>{{ $archive->seller_id ?? 'غير معروف' }}</td>
                                    <td>{{ $archive->customer_name ?? 'غير معروف' }}</td>
                                    <td>{{ $archive->customer_phone ?? 'غير معروف' }}</td>
                                    <td>{{ $archive->customer_email ?? 'غير معروف' }}</td>
                                    <td>{{ $archive->created_at->format('Y-m-d H:i') }}</td>
                                    <td>
                                        <div class="d-flex justify-content-center flex-wrap gap-1">
                                            <a href="{{ asset('storage/app/' . $archive->file_path) }}" target="_blank" 
                                                class="btn btn-sm btn-outline-info">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.payment_proof.dispute.archive.download', $archive->id) }}" 
                                                class="btn btn-sm btn-outline-success">
                                                <i class="fa-solid fa-download"></i>
                                            </a>
                                            <form method="POST" 
                                                  action="{{ route('admin.payment_proof.dispute.archive.destroy', $archive->id) }}" 
                                                  class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" 
                                                    onclick="return confirm('⚠️ هل أنت متأكد من حذف هذا الملف؟')" 
                                                    class="btn btn-sm btn-outline-danger">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- ترقيم الصفحات -->
            <div class="card-footer text-center">
                {{ $archives->links('pagination::bootstrap-5') }}
            </div>
        </div>
    @endif
</div>