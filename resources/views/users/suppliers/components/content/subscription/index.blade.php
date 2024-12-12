<div class="container">
    <h1>الإشتراك</h1>
        <div class="card">
            <div class="card-body">
              <h5>الخطط</h5>
              <hr>
              @foreach ($plans as $plan)
              <div class="col-4" style="float:right;padding:2px;">
                <div class="card">
                    <div class="card-header text-center">
                        الخطة {{$plan->name}}
                        <br>
                        <b>{{$plan->price}}<sup>د.ج</sup></b><span> في الشهر</span>
                    </div>
                    <div class="card-body">
                        <hr>
                        <form action="" class="text-center">
                            <button type="submit" class="btn btn-primary">اشتراك</button>
                        </form>
                    </div>
                </div>
              </div>
              @endforeach
            </div>
          </div>
</div>