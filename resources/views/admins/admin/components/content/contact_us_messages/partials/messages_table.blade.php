@forelse($messages as $index => $message)
    <tr class="{{--!! get_message_status_class($message->status) !!--}}">
        <td data-label="رقم الرسالة">#{{ $index + 1 }}</td>
        <td data-label="إسم المرسل">{{ $message->name }}</td>
        <td data-label="البريد الألكتروني">{!! $message->email !!}</td>
        {{-- <td>{{ $message->items_count }} منتجات</td> --}}
        <td data-label="عنوان الرسالة">{{ $message->subject }}</td>
        <td data-label="نص الرسالة">{{ $message->message }}</td>
        <td data-label="تاريخ الرسالة">{{ $message->created_at->format('Y-m-d') }}</td>
        <td data-label="حالة الرسالة">{{ $message->is_read }}</td>
        <td>
            <button class="btn btn-sm btn-info view-message" data-message-id="{{ $message->id }}"
                onclick="view_message({{ $message->id }});">
                <i class="fas fa-eye"></i>
            </button>

            <button class="btn btn-sm btn-danger delete-message" data-message-id="{{ $message->id }}"
                onclick="delete_message({{ $message->id }});">
                <i class="fas fa-trash"></i>
            </button>

        </td>
    </tr>
@empty
    <tr>
        <td colspan="8" class="text-center">لا توجد رسائل متاحة</td>
    </tr>
@endforelse

