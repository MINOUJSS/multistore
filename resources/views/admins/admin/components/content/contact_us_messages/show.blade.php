<div class="container-fluid">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0 text-gray-800">محتوى رسالة الاتصال</h1>
    </div>

    @if(session()->has('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm">
            <i class="fa-solid fa-circle-check me-1"></i>
            {{ session()->get('success') }}
            <button class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><b>رسالة من طرف : </b>{{ $message->name }}</h5>
                    <p><b>البريد الإلكتروني: </b>{{ $message->email }}</p>
                </div>
                <div class="card-body">
                    <h5 class="card-title"><b>الموضوع: </b>{{ $message->subject }}</h5>
                    <p class="card-text"><b>الرسالة: </b>{{ $message->message }}</p>
                </div>
            </div>
        </div>
    </div>
    {{-- <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><b>تم الرد من طرف: </b> </h5>
                </div>
                <div class="card-body">
                    <p class="card-text"><b>الرد: </b>{{ $message->reply }}</p>
                </div>
            </div>
        </div>
    </div> --}}
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><b>فورم الرد على الرسالة</b> </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.contact.message.reply', $message->id) }}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="reply">الرد</label>
                            <textarea class="form-control" name="reply" id="reply" rows="3"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary mt-3">ارسال</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>