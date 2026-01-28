        <div class="row g-3">
            <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="card bg-white text-white h-100 border-primary">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2 text-primary">
                            <i class="fa-solid fa-users fa-2x me-2"></i>
                            <h5 class="card-title mb-0">كل المشتركين</h5>
                        </div>
                        <h2 class="card-text mb-2 text-primary">{{$users->count() }}</h2>
                        <div class="d-flex align-items-center">
             
                        </div>
                    </div>
                </div>
            </div>
             <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="card bg-white text-success h-100 border-success">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fa-solid fa-users fa-2x me-2"></i>
                            <h5 class="card-title mb-0">الموردين</h5>
                        </div>
                        <h2 class="card-text mb-2">{{ $suppliers->count() }}</h2>
                        <div class="d-flex align-items-center">

                        </div>
                    </div>
                </div>
            </div>
            
            <div class="col-sm-12 col-md-6 col-lg-3">
                <div class="card bg-white text-danger h-100 border-danger">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fa-solid fa-users fa-2x me-2"></i>
                            <h5 class="card-title mb-0"> تجار التجزئة </h5>
                        </div>
                        <h2 class="card-text mb-2">{{ $sellers->count() }}</h2>
                        <div class="d-flex align-items-center">

                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-lg-3">
                <a class="text-decoration-none" href="#">
                <div class="card bg-white text-warning h-100 border-warning">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <i class="fa-solid fa-users fa-2x me-2"></i>
                            <h5 class="card-title mb-0">البائعين بالعمولة</h5>
                        </div>
                        <h2 class="card-text mb-2">{{ $marketers->count() }}</h2>
                        <div class="d-flex align-items-center">
     
                        </div>
                    </div>
                </div>
                </a>
            </div> 
        </div>