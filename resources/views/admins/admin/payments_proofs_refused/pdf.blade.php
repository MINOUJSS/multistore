<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <style>
        /* ====== إعداد الخط العربي ====== */
        @font-face {
            font-family: "Cairo";
            /* src: url("{{ base_path('resources/fonts/Cairo/Cairo-Regular.ttf') }}") format('truetype'); */
        }

        * {
            font-family: 'Cairo', serif;
            direction: rtl;
            text-align: right;
            box-sizing: border-box;
        }

        body {
            margin: 25px;
            background-color: #f8f9fa;
            color: #222;
        }

        h1,
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }

        h1 {
            font-size: 28px;
            color: #1a237e;
            border-bottom: 2px solid #1a237e;
            padding-bottom: 10px;
            margin-bottom: 40px;
        }

        h2 {
            color: #1565c0;
            margin-top: 40px;
        }

        .card {
            border: 1px solid #ccc;
            border-radius: 8px;
            margin-bottom: 20px;
            background-color: #fff;
            overflow: hidden;
        }

        .card-header {
            background-color: #1a237e;
            color: white;
            font-weight: bold;
            padding: 10px 15px;
            font-size: 16px;
        }

        .card-body {
            padding: 12px 15px;
            background-color: #fafafa;
        }

        .card-body p {
            margin: 6px 0;
            font-size: 14px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
            font-size: 13px;
        }

        th,
        td {
            border: 1px solid #bbb;
            padding: 8px;
            text-align: center;
            vertical-align: middle;
        }

        th {
            background-color: #1565c0;
            color: #fff;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f1f1f1;
        }

        .attachments img {
            display: block;
            margin: 5px auto;
            border-radius: 6px;
            border: 1px solid #ddd;
            max-width: 90%;
            height: auto;
        }

        .attachments p {
            text-align: center;
            font-size: 12px;
            margin: 4px 0;
        }

        .page-break {
            page-break-before: always;
        }

        @page {
            footer: html_myFooter;
        }
    </style>
</head>

<body>
    <h1>ملف إثبات الدفع المرفوض رقم ({{ $proof->id }})</h1>

    {{-- بيانات المورد --}}
    <div class="card">
        <div class="card-header">بيانات المورد</div>
        <div class="card-body">
            <p><strong>الاسم:</strong> {{ $proof->user->name ?? 'غير محدد' }}</p>
            <p><strong>البريد الإلكتروني:</strong> {{ $proof->user->email ?? '-' }}</p>
            <p><strong>رقم الهاتف:</strong> {{ $proof->user->phone ?? '-' }}</p>
        </div>
    </div>

    {{-- بيانات الطلب --}}
    <div class="card">
        <div class="card-header">بيانات الطلب وإثبات الدفع</div>
        <div class="card-body">
            <p><strong>رقم الطلب:</strong> {{ $proof->order_number }}</p>
            <p><strong>حالة الإثبات:</strong> 
                @switch($proof->status)
                    @case('refused') مرفوض @break
                    @case('approved') مقبول @break
                    @case('in_review') قيد المراجعة @break
                    @default غير محدد
                @endswitch
            </p>
            <p><strong>تاريخ الرفض:</strong> {{ $proof->refused_at ? $proof->refused_at->format('Y-m-d H:i') : '-' }}</p>
        </div>
    </div>

    {{-- بيانات الرفض --}}
    <div class="card">
        <div class="card-header">تفاصيل الرفض</div>
        <div class="card-body">
            <p><strong>سبب الرفض:</strong> {{ $proof->refuse_reason ?? 'غير مذكور' }}</p>
            <p><strong>ملاحظات الإدارة:</strong> {{ $proof->admin_notes ?? 'لا توجد ملاحظات إضافية' }}</p>
            <p><strong>اسم المسؤول:</strong> {{ $proof->admin->name ?? 'غير معروف' }}</p>
        </div>
    </div>

    {{-- فاصل صفحة --}}
    <div class="page-break"></div>

    {{-- مرفقات الإثبات --}}
    <h2>مرفقات إثبات الدفع</h2>
    <div class="attachments">
        @if (!empty($proof->proof_path))
            @php
                $ext = pathinfo($proof->proof_path, PATHINFO_EXTENSION);
                $storagePath = storage_path('app/public/' . str_replace('app/public/', '', $proof->proof_path));
            @endphp

            @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                @if (file_exists($storagePath))
                    <img src="data:image/{{ $ext }};base64,{{ base64_encode(file_get_contents($storagePath)) }}" alt="إثبات الدفع">
                @endif
            @else
                <p>📎 {{ basename($proof->proof_path) }}</p>
            @endif
        @else
            <p class="text-muted">لا توجد مرفقات متاحة.</p>
        @endif
    </div>

    {{-- فاصل صفحة --}}
    <div class="page-break"></div>

    {{-- جدول المحادثات --}}
    <h2>المحادثة بين الإدارة والمورد</h2>
    <table>
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="15%">المرسل</th>
                <th width="35%">نص الرسالة</th>
                <th width="30%">المرفقات</th>
                <th width="15%">التاريخ</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($messages as $index => $msg)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        @if ($msg->sender_type === 'admin')
                            الإدارة
                        @elseif ($msg->sender_type === 'supplier')
                            المورد
                        @else
                            غير محدد
                        @endif
                    </td>
                    <td>{{ $msg->message ?? '-' }}</td>
                    <td class="attachments">
                        @if (!empty($msg->attachments))
                            @foreach ($msg->attachments as $file)
                                @php
                                    $ext = pathinfo($file, PATHINFO_EXTENSION);
                                    // $storagePath = storage_path('app/public/' . str_replace('app/public/', '', $file));
                                    $storagePath = Storage::disk('general')->path($file);
                                @endphp
                                @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                    @if (file_exists($storagePath))
                                        <img src="data:image/{{ $ext }};base64,{{ base64_encode(file_get_contents($storagePath)) }}" alt="مرفق">
                                    @endif
                                @else
                                    <p>📎 {{ basename($file) }}</p>
                                @endif
                            @endforeach
                        @else
                            <p class="text-muted">لا توجد مرفقات</p>
                        @endif
                    </td>
                    <td>{{ $msg->created_at ? $msg->created_at->format('Y-m-d H:i') : '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">لا توجد رسائل في هذه المحادثة.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <htmlpagefooter name="myFooter">
        <div style="text-align: center; font-size: 12px; color: gray;">
            الصفحة {PAGENO} من {nbpg} — تم توليد التقرير بتاريخ {{ now()->format('Y-m-d H:i') }}
        </div>
    </htmlpagefooter>
</body>

</html>
