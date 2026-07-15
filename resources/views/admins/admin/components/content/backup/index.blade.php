<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="mb-0">النسخ الإحتياطية</h3>

        <a href="{{ route('admin.backup.index') }}"
           class="btn btn-primary">
            تحديث
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

      @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
     <div class="card shadow-sm border-0 rounded-4">
        <div class="card-body p-0">
            <form id="bulkDeleteForm"
            action="{{ route('admin.backup.bulk-delete') }}"
            method="POST">

            @csrf
            @method('DELETE')

            <div class="m-3 d-flex gap-2">

                <button
                    type="submit"
                    form="bulkDeleteForm"
                    class="btn btn-danger"
                    onclick="return confirm('هل تريد حذف جميع الملفات المحددة؟')">

                    حذف المحدد
                </button>

            </div>

            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th width="40">
                             <input type="checkbox" id="checkAll">
                            </th>
                            <th>إسم الملف</th>
                            <th>حجم الملف</th>
                            <th>مسار الملف</th>
                            <th>تاريخ إنشاء الملف</th>
                            <th width="180">العمليات</th>
                        </tr>
                    </thead>

                    <tbody>
                         @forelse($files as $file)
                            <tr>
                                                                <td>
                                    <input
                                        type="checkbox"
                                        class="file-checkbox"
                                        name="files[]"
                                        value="{{ $file['name'] }}">
                                </td>
                                <td>
                                    <strong>{{ $file['name'] }}</strong>
                                </td>

                                <td>
                                    {{ $file['size'] }} MB
                                </td>

                                <td>
                                    {{ $file['path'] }}
                                </td>

                                <td>
                                    {{ $file['last_modified'] }}
                                </td>

                                <td>
                                     <div class="d-flex gap-2">

                                        <a href="{{ route('admin.backup.download', $file['name']) }}"
                                           class="btn btn-success btn-sm">
                                            تحميل
                                        </a>

                                        <form action="{{ route('admin.backup.delete', $file['name']) }}"
                                              method="POST"
                                              onsubmit="return confirm('هل تريد حذف الملف؟')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-danger btn-sm">
                                                حذف
                                            </button>
                                             </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5">
                                    لاتوجد ملفات إحتياطية.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            </form>

        </div>
    </div>
</div>