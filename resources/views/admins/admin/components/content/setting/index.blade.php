<div class="container">
    <h1>الاعدادات</h1>
    <div class="card">
        <div class="card-body">
          <!--tabs-->
          <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item" role="presentation">
              <button class="nav-link active" id="google-analitics-tab" data-bs-toggle="tab" data-bs-target="#google-analitics" type="button" role="tab" aria-controls="google analitics" aria-selected="true">google analitics</button>
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
                <form action="" method="POST">
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
                </form>
            </div>
            <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">...</div>
            <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">...</div>
          </div>
          <!--end tabs-->
        </div>
      </div>
</div>