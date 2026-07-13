<div class="container">
    <h1>الاعدادات</h1>
    @if (session()->has('success'))
        <div class="alert alert-success">
            {{ session()->get('success') }}
            <button type="button" class="btn-close left" data-bs-dismiss="alert" aria-label="Close"
                style="float: left;"></button>
        </div>
    @endif
    <div class="card">
        <div class="card-body">
          <!--tabs-->
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="google-analitics-tab" data-bs-toggle="tab" data-bs-target="#google-analitics" type="button" role="tab" aria-controls="google analitics" aria-selected="true">Platform Settings</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false">Profile</button>
            </li>
            <li class="nav-item" role="presentation">
              <button class="nav-link" id="contact-tab" data-bs-toggle="tab" data-bs-target="#contact" type="button" role="tab" aria-controls="contact" aria-selected="false">Contact</button>
            </li>
          </ul>
          <div class="tab-content" id="myTabContent">
            <div class="tab-pane fade show active" id="google-analitics" role="tabpanel" aria-labelledby="google-analitics-tab">
                {{-- <form action="{{route('admin.update_google_analytics')}}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="google-analitics" class="form-label">الكود</label>
                        <textarea name="google_analitics" class="form-control" id="" cols="30" rows="10">
                          {{get_platform_data('google_analitics')->value}}
                        </textarea>
                        <label for="google-analitics" class="form-label">حالة الكود</label>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="mySwitch" name="activation" value="yes" checked>
                            <label class="form-check-label" for="mySwitch">مفعل</label>
                        </div>
                        <hr>
                        <input type="submit" value="حفظ" class="btn btn-primary">
                    </div>
                </form> --}}
                <form action="{{ route('admin.settings.update') }}" method="POST">
    @csrf

    @foreach($settings as $setting)

        <div class="card shadow-sm mb-4">

            <div class="card-header">
                <strong>{{ ucwords(str_replace('_',' ', $setting->key)) }}</strong>
            </div>

            <div class="card-body">

                {{-- Key --}}
                <input type="hidden"
                       name="settings[{{ $setting->id }}][key]"
                       value="{{ $setting->key }}">

                {{-- Value --}}
                <div class="mb-3">

                    <label class="form-label">
                        القيمة
                    </label>

                    @if($setting->type == 'text')

                        <textarea
                            class="form-control"
                            rows="8"
                            name="settings[{{ $setting->id }}][value]">{{ $setting->value }}</textarea>

                    @elseif($setting->type == 'boolean')

                        <select
                            class="form-select"
                            name="settings[{{ $setting->id }}][value]">

                            <option value="1"
                                {{ $setting->value ? 'selected' : '' }}>
                                نعم
                            </option>

                            <option value="0"
                                {{ !$setting->value ? 'selected' : '' }}>
                                لا
                            </option>

                        </select>

                    @else

                        <input
                            type="text"
                            class="form-control"
                            name="settings[{{ $setting->id }}][value]"
                            value="{{ $setting->value }}">

                    @endif

                </div>

                {{-- Description --}}
                <div class="mb-3">

                    <label class="form-label">
                        الوصف
                    </label>

                    <textarea
                        class="form-control"
                        rows="2"
                        name="settings[{{ $setting->id }}][description]">{{ $setting->description }}</textarea>

                </div>

                {{-- Status --}}
                <div class="form-check form-switch">

                    <input
                        class="form-check-input"
                        type="checkbox"
                        value="active"
                        name="settings[{{ $setting->id }}][status]"
                        {{ $setting->status=='active' ? 'checked' : '' }}>

                    <label class="form-check-label">
                        مفعل
                    </label>

                </div>

            </div>

        </div>

    @endforeach

    <button class="btn btn-primary">
        حفظ جميع الإعدادات
    </button>

</form>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
          </div>
          <!--end tabs-->
        </div>
      </div>
</div>