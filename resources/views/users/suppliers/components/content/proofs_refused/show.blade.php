<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">تفاصيل إثبات الدفع المرفوض</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-3">تفاصيل الإثبات رقم: {{ $proof->id }}</h4>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <strong>المستخدم:</strong> {{ $proof->user->name ?? 'غير معروف' }}
                            <br>
                            <strong>البريد الإلكتروني للمستخدم:</strong> {{ $proof->user->email ?? 'غير معروف' }}
                        </div>
                        <div class="col-md-6">
                            <strong>المسؤول الذي رفض:</strong> {{ $proof->admin->name ?? 'غير معروف' }}
                            <br>
                            <strong>تاريخ الإرسال:</strong> {{ $proof->created_at->format('Y-m-d H:i') }}
                        </div>
                    </div>

                    <div class="mb-3">
                        <strong>سبب الرفض:</strong>
                        <p>{{ $proof->refuse_reason ?? 'لا يوجد سبب محدد' }}</p>
                    </div>

                    <div class="mb-3">
                            <strong>المرفقات:</strong>
                            <div class="mt-2">
                                    @php
                                        $fileName = basename($proof->proof_path);
                                        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
                                        $isImage = in_array(strtolower($fileExtension), ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp']);
                                    @endphp
                                    @if ($isImage)
                                        <a href="{{$proof->proof_path }}" target="_blank">
                                            <img src="{{$proof->proof_path }}" alt="Attachment Image" class="img-thumbnail d-block mb-1" style="max-width:200px; max-height:200px;">
                                        </a>
                                    @else
                                        <a href="{{$proof->proof_path }}" target="_blank" class="d-block small">
                                            📎 {{ $fileName }}
                                        </a>
                                    @endif
                            </div>
                        </div>

                    <div class="mt-4">
                        <a href="{{ route('supplier.payments_proofs_refuseds') }}" class="btn btn-secondary">العودة إلى القائمة</a>
                        {{-- Add other actions like edit, delete if needed --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!---include chat box-->
    @include('users.suppliers.components.content.proofs_refused.inc.chat_box')
</div>
