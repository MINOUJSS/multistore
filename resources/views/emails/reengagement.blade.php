<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $emailSubject }}</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f4f6f9;
            margin: 0;
            padding: 0;
            direction: rtl;
            text-align: right;
            color: #333333;
        }
        .email-container {
            max-width: 600px;
            margin: 30px auto;
            background: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
            border: 1px solid #e1e8ed;
        }
        .email-header {
            background: linear-gradient(135deg, #1e293b, #0f172a);
            padding: 25px;
            text-align: center;
            color: #ffffff;
        }
        .email-header h2 {
            margin: 0;
            font-size: 22px;
            font-weight: 700;
        }
        .email-body {
            padding: 30px 25px;
            line-height: 1.8;
            font-size: 15px;
            color: #475569;
        }
        .email-body p {
            margin-bottom: 15px;
        }
        .email-footer {
            background-color: #f8fafc;
            padding: 20px;
            text-align: center;
            font-size: 13px;
            color: #94a3b8;
            border-top: 1px solid #e2e8f0;
        }
        .btn-action {
            display: inline-block;
            background-color: #2563eb;
            color: #ffffff !important;
            padding: 12px 30px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            margin-top: 20px;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.2);
        }
    </style>
</head>
<body>
    <div class="email-container">
        <div class="email-header">
            <h2>{{ get_platform_data('platform_name')->value ?? 'منصتنا الرقمية' }}</h2>
        </div>
        <div class="email-body">
            {!! nl2br($emailBody) !!}
        </div>
        <div class="email-footer">
            <p>تم إرسال هذا البريد الإلكتروني رسمياً من منصة {{ get_platform_data('platform_name')->value ?? '' }}.</p>
            <p>&copy; {{ date('Y') }} جميع الحقوق محفوظة.</p>
        </div>
    </div>
</body>
</html>
