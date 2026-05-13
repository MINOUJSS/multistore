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
    @if(count($message->replies)==0 && $message->is_read==0)
    <div class="row mt-4">
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
                        <button type="submit" class="btn btn-primary mt-3">ارسال</button> <button type="button" class="btn btn-danger mt-3" onclick="ignoreReply({{ $message->id }})">تجاهل الرد</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @else
    @if(count($message->replies)>0)
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><b>رد الرسالة</b> </h5>
                </div>
                <div class="card-body">
                    @foreach($message->replies as $reply)
                    <h5 class="card-title"><b>تم الرد من طرف: </b> {{ get_admin_data_from_id($reply->admin_id)->name }} </h5>
                    <small>{{ $reply->created_at->diffForHumans() }}</small>
                    <p class="card-text"><b>الرد: </b>{{ $reply->reply }}</p>
                    <hr>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    @else 
    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><b>رد الرسالة</b> </h5>
                </div>
                <div class="card-body">
                    <h5 class="card-title"><b>تم تجاهل الرد </b> </h5>
                </div>
            </div>
        </div>
    </div>
    @endif
    @endif
</div>