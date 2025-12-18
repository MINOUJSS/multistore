<div class="container my-5">
    <div class="card shadow-lg border-0">
        <div class="card-header bg-primary text-white text-center">
            🧾 متابعة النزاع رقم الطلب: <strong>{{ $dispute->order_number }}</strong>
        </div>

        <div class="card-body">
            <h5 class="mb-3">📌 تفاصيل النزاع</h5>
            <ul class="list-group mb-4">
                <li class="list-group-item"><strong>الاسم:</strong> {{ $dispute->customer_name ?? 'غير محدد' }}</li>
                <li class="list-group-item"><strong>البريد الإلكتروني:</strong>
                    {{ $dispute->customer_email ?? 'غير متوفر' }}</li>
                <li class="list-group-item"><strong>رقم الهاتف:</strong> {{ $dispute->customer_phone ?? 'غير متوفر' }}
                </li>
                <li class="list-group-item"><strong>الموضوع:</strong> {{ $dispute->subject }}</li>
                <li class="list-group-item"><strong>الوصف:</strong> {{ $dispute->description }}</li>
                <li class="list-group-item">
                    <strong>الحالة الحالية:</strong>
                    @php
                        $statuses = [
                            'open' => 'مفتوح 🟢',
                            'in_review' => 'قيد المراجعة 🟡',
                            'resolved' => 'تم الحل ✅',
                            'escalated' => 'محال للجهات المسؤولة ⚖️',
                            'rejected' => 'مرفوض ❌',
                            'closed' => 'مغلق 🔒',
                        ];
                    @endphp
                    {{ $statuses[$dispute->status] ?? 'غير معروف' }}
                </li>

                @if (!empty($dispute->attachments))
                    <li class="list-group-item">
                        <strong>📎 المرفقات:</strong><br>
                        @foreach (json_decode($dispute->attachments, true) as $file)
                            <a href="{{ asset('storage/' . $file) }}" target="_blank"
                                class="btn btn-outline-secondary btn-sm m-1">
                                عرض المرفق {{ $loop->iteration }}
                            </a>
                        @endforeach
                    </li>
                @endif
            </ul>

            {{-- <h5 class="mb-3">💬 المحادثة</h5>
            <div id="messages-container" class="border rounded p-3 bg-light mb-3" style="max-height: 400px; overflow-y: auto;">
                @forelse ($dispute->messages as $message)
                    <div class="mb-3 {{ $message->sender_type == 'customer' ? 'text-end' : 'text-start' }}">
                        <div class="d-inline-block p-2 rounded 
                            {{ $message->sender_type == 'customer' ? 'bg-primary text-white' : 'bg-secondary text-white' }}">
                            {{ $message->message }}
                        </div>
                        <div class="small text-muted mt-1">
                            {{ $message->created_at->diffForHumans() }}
                            ({{ $message->sender_type == 'customer' ? 'أنت' : 'الإدارة' }})
                        </div>
                    </div>
                @empty
                    <p class="text-center text-muted">لا توجد رسائل بعد.</p>
                @endforelse
            </div> --}}
            <h5 class="mb-3">💬 المحادثة</h5>
            <div class="position-relative">
                <div id="unreadBadge"
                    class="position-absolute top-0 start-50 translate-middle badge rounded-pill bg-danger d-none"
                    style="z-index: 10;">
                    🔔 <span id="unreadCount">0</span> رسالة جديدة
                </div>

                <div id="messages-container" class="border rounded p-3 bg-light mb-3 shadow-sm"
                    style="max-height: 400px; overflow-y: auto; scroll-behavior: smooth;">
                    @forelse ($dispute->messages as $message)
                        <div class="mb-3 {{ $message->sender_type == 'customer' ? 'text-end' : 'text-start' }}">
                            <div
                                class="d-inline-block p-2 rounded-3 shadow-sm
                    {{ $message->sender_type == 'customer' ? 'bg-primary text-white' : 'bg-secondary text-white' }}">
                                <p>{{ $message->message }}</p>
                                @if (!empty($message->attachments))
                                    <div class="mt-2">
                                        @foreach (json_decode($message->attachments, true) as $index => $file)
                                            <!---->
                                            @php
                                                $isImage = in_array(pathinfo($file, PATHINFO_EXTENSION), [
                                                    'jpg',
                                                    'jpeg',
                                                    'png',
                                                    'gif',
                                                ]);
                                                $fileUrl = asset('storage/' . $file);
                                            @endphp

                                            @if ($isImage)
                                                <a href="{{ $fileUrl }}" target="_blank">
                                                    <img src="{{ $fileUrl }}" alt="attachment" class="rounded mt-1 border" style="max-width:150px; max-height:150px; border:1px solid #ccc;">
                                                </a>
                                            @else
                                                <a href = "{{ $fileUrl }}"
                                                    target = "_blank"
                                                    class = "btn btn-outline-light btn-sm d-inline-block me-1"> 📎مرفق
                                                    {{$index + 1}} </a>
                                            @endif

                                            <!---->
                                            {{-- <a href="{{ asset('storage/' . $file) }}" target="_blank"
                                            class="btn btn-outline-secondary btn-sm m-1">
                                            عرض المرفق {{ $loop->iteration }}
                                        </a> --}}
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div class="small text-muted mt-1">
                                {{ $message->created_at->diffForHumans() }}
                                ({{ $message->sender_type == 'customer' ? 'أنت' : 'الإدارة' }})
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-muted">لا توجد رسائل بعد.</p>
                    @endforelse
                </div>
            </div>


            @if (in_array($dispute->status, ['open', 'in_review']))
                <form id="replyForm" method="POST" action="{{ route('site.dispute.reply', $dispute->access_token) }}"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="message" class="form-label">✉️ أضف ردًا جديدًا</label>
                        <textarea name="message" id="message" class="form-control" rows="3" required></textarea>
                    </div>

                    <div class="mb-3">
                        <label for="attachments" class="form-label">📎 أضف مرفقات (اختياري)</label>
                        <input type="file" name="attachments[]" id="attachments" class="form-control" multiple
                            accept=".jpg,.jpeg,.png,.pdf,.zip,.rar,.doc,.docx">
                        <small class="text-muted">يمكنك رفع عدة ملفات (الحد الأقصى 5 ملفات)</small>
                    </div>

                    <button type="submit" class="btn btn-success w-100">
                        📨 إرسال الرد
                    </button>

                </form>
            @else
                <div class="alert alert-info text-center">
                    ⚠️ هذا النزاع مغلق ولا يمكن الرد عليه.
                </div>
            @endif
        </div>
    </div>
</div>
