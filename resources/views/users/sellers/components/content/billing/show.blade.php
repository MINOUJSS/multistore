    <style>
        body {
            background: #f8fafc;
            font-family: 'Cairo', sans-serif;
        }

        .invoice-box {
            background: #fff;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0,0,0,.05);
        }

        .invoice-header {
            border-bottom: 2px solid #eee;
            margin-bottom: 20px;
            padding-bottom: 15px;
        }

        .invoice-title {
            font-weight: bold;
            font-size: 24px;
        }

        .status-paid {
            color: #16a34a;
            font-weight: bold;
        }

        .status-pending {
            color: #f59e0b;
        }

        .table th {
            background: #f1f5f9;
        }

        .total-box {
            background: #f8fafc;
            padding: 15px;
            border-radius: 10px;
            font-weight: bold;
        }

        @media print {
            body {
                background: #fff;
            }

            .invoice-box {
                box-shadow: none;
                border: none;
            }
        }
    </style>
<div class="container my-5">
    <div class="invoice-box">

        <!-- Header -->
        <div class="invoice-header d-flex justify-content-between">
            <div>
                <div class="invoice-title">فاتورة</div>
                <div>رقم الفاتورة: {{ $data['invoice_number'] }}</div>
                <div>التاريخ: {{ $data['invoice_date'] }}</div>
            </div>

            <div class="text-end">
                <div>
                    الحالة:
                    <span class="{{ $data['status'] == 'paid' ? 'status-paid' : 'status-pending' }}">
                        {{ $data['status'] }}
                    </span>
                </div>
                <div>طريقة الدفع: {{ $data['payment_method'] }}</div>
            </div>
        </div>

        <!-- Table -->
        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center">
                <thead>
                    <tr>
                        <th>الوصف</th>
                        <th>الكمية</th>
                        <th>سعر الوحدة</th>
                        <th>الإجمالي</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($data['details'] as $item)
                        <tr>
                            <td>{{ $item['item_name'] }}</td>
                            <td>{{ $item['quantity'] }}</td>
                            <td>{{ number_format($item['unit_price'], 2) }}</td>
                            <td>
                                {{ number_format($item['quantity'] * $item['unit_price'], 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Total -->
        <div class="d-flex justify-content-end">
            <div class="total-box">
                الإجمالي: {{ number_format($data['total_amount'], 2) }} دج
            </div>
        </div>

    </div>
</div>