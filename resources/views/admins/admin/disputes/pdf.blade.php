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
    <h1>ملف النزاع رقم ({{ $dispute->id }}) الخاص بإثبات الدفع</h1>

    {{-- بيانات الزبون --}}
    <div class="card">
        <div class="card-header">بيانات الزبون المدعي</div>
        <div class="card-body">
            <p><strong>اسم الزبون:</strong> {{ $dispute->customer_name }}</p>
            <p><strong>بريد الزبون:</strong> {{ $dispute->customer_email }}</p>
            <p><strong>رقم الزبون:</strong> {{ $dispute->customer_phone }}</p>
        </div>
    </div>

    {{-- بيانات البائع --}}
    <div class="card">
        <div class="card-header">بيانات البائع المدعى عليه</div>
        <div class="card-body">
            <p><strong>اسم البائع:</strong> {{ $user->name }}</p>
            <p><strong>بريد البائع:</strong> {{ $user->email }}</p>
            <p><strong>رقم البائع:</strong> {{ $user->phone }}</p>
        </div>
    </div>

    {{-- بيانات النزاع --}}
    <div class="card">
        <div class="card-header">بيانات النزاع</div>
        <div class="card-body">
            <p><strong>رقم الطلب:</strong> {{ $dispute->order_number }}</p>
            <p><strong>الموضوع:</strong> {{ $dispute->subject }}</p>
            <p><strong>الوصف:</strong> {{ $dispute->description }}</p>
        </div>
    </div>

    {{-- فاصل صفحة --}}
    <div class="page-break"></div>

    {{-- محتوى المحادثة --}}
    <h2>محتوى المحادثة بين الزبون والإدارة</h2>

    <table>
        <thead>
            <tr>
                <th width="5%">#</th>
                <th width="10%">المرسل</th>
                <th width="30%">نص الرسالة</th>
                <th width="40%">المرفقات</th>
                <th width="15%">الوقت</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($messages as $index => $msg)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $msg->sender_type === 'customer' ? 'الزبون' : 'الإدارة' }}</td>
                    <td>{{ $msg->message }}</td>
                    <td class="attachments">
                        @if (!empty($msg->attachments))
                            @foreach ($msg->attachments as $file)
                                @php
                                    $ext = pathinfo($file, PATHINFO_EXTENSION);
                                    $storagePath = storage_path('app/public/' . str_replace('app/public/', '', $file));
                                @endphp
                                @if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif', 'webp']))
                                    @if (file_exists($storagePath))
                                        <img src="data:image/{{ $ext }};base64,{{ base64_encode(file_get_contents($storagePath)) }}"
                                            alt="مرفق">
                                    @endif
                                @else
                                    <p>📎 {{ basename($file) }}</p>
                                @endif
                            @endforeach
                        @endif
                    </td>
                    <td>{{ $msg->created_at->format('Y-m-d H:i') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <htmlpagefooter name="myFooter">
        <div style="text-align: center; font-size: 12px; color: gray;">
            الصفحة {PAGENO} من {nbpg}
        </div>
    </htmlpagefooter>
</body>

</html>
