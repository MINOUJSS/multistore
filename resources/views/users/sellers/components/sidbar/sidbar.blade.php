<!-- Start Sid Bar  -->
<style>
/* Modernized Seller Sidebar CSS */
.app-sidebar, .offcanvas-body {
    background: #a40c72 !important; /* Preserved primary color */
    box-shadow: -4px 0 25px rgba(0, 0, 0, 0.15);
}

.logo-box {
    padding: 1.25rem 1rem 0.5rem 1rem;
}

.logo-avatar-wrapper {
    position: relative;
    display: inline-block;
    padding: 4px;
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(8px);
    border-radius: 50%;
    border: 1px solid rgba(255, 255, 255, 0.25);
    box-shadow: 0 8px 16px rgba(0,0,0,0.12);
}

.logo-image {
    border-radius: 50%;
    object-fit: cover;
    border: 2px solid #ffffff;
}

.verified-badge {
    position: absolute;
    bottom: 2px;
    left: 2px;
    background: #10b981;
    color: #ffffff;
    width: 22px;
    height: 22px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 2px solid #a40c72;
    font-size: 11px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
}

.user-tenant-badge {
    background: rgba(255, 255, 255, 0.15);
    backdrop-filter: blur(6px);
    color: #ffffff;
    border: 1px solid rgba(255, 255, 255, 0.2);
    border-radius: 20px;
    padding: 3px 14px;
    font-size: 0.8rem;
    font-weight: 600;
    letter-spacing: 0.5px;
    display: inline-block;
}

.store-visit-btn {
    background: linear-gradient(135deg, rgba(255, 255, 255, 0.22) 0%, rgba(255, 255, 255, 0.1) 100%) !important;
    border: 1px solid rgba(255, 255, 255, 0.3) !important;
    color: #ffffff !important;
    backdrop-filter: blur(10px);
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}

.store-visit-btn:hover {
    background: rgba(255, 255, 255, 0.3) !important;
    color: #ffffff !important;
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(0,0,0,0.18);
}

.menu .item {
    margin: 4px 10px;
    border-radius: 10px;
    transition: all 0.25s ease;
    background: transparent !important;
}

.menu .item a {
    padding: 10px 14px;
    display: flex;
    align-items: center;
    gap: 10px;
    color: rgba(255, 255, 255, 0.9);
    font-weight: 500;
    font-size: 0.92rem;
    text-decoration: none;
    border-radius: 10px;
    transition: all 0.25s ease;
}

.menu .item a i:not(.dropdown) {
    width: 24px;
    text-align: center;
    font-size: 1.05rem;
    opacity: 0.9;
}

.menu .item a:hover {
    background: rgba(255, 255, 255, 0.15) !important;
    color: #ffffff !important;
    border: none !important;
    transform: translateX(-3px);
}

.menu .item.active > a, .menu .item a.active {
    background: rgba(255, 255, 255, 0.22) !important;
    color: #ffffff !important;
    font-weight: 700;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    border-right: 4px solid #ffffff !important;
}

.sub-menu {
    background: rgba(0, 0, 0, 0.15) !important;
    border-radius: 10px;
    padding: 6px 0;
    margin: 4px 0;
}

.sub-menu .sub-item {
    padding: 8px 18px 8px 12px !important;
    font-size: 0.85rem !important;
    color: rgba(255, 255, 255, 0.8) !important;
    border-radius: 8px;
    margin: 2px 8px;
    background: transparent !important;
}

.sub-menu .sub-item:hover {
    background: rgba(255, 255, 255, 0.15) !important;
    color: #ffffff !important;
}

.app-sidebar::-webkit-scrollbar {
    width: 5px;
}
.app-sidebar::-webkit-scrollbar-thumb {
    background: rgba(255, 255, 255, 0.2);
    border-radius: 10px;
}
</style>

<div class="app-sidebar">
    <div class="logo-box text-center">
        <div class="logo-avatar-wrapper mb-2">
            <img class="logo-image" src="{{ get_store_logo(Auth::user()->tenant_id) }}" alt="Store Logo" width="56" height="56">
            @if(get_seller_data(Auth::user()->tenant_id)->approval_status == 'approved')  
                <span class="verified-badge" title="متجر موثق">
                    <i class="bi bi-check-lg"></i>
                </span>
            @endif
        </div>
        <div class="user-name">
            <span class="user-tenant-badge">
                <i class="fa-solid fa-store me-1 small"></i> {{ Auth::user()->tenant_id }}
            </span>
        </div>  
    </div> 
    <hr class="my-3 opacity-25 text-white">
    <!--Start Menu-->
    @include('users.sellers.components.sidbar.inc.menu.index')
    <!--End Menu-->
</div>
<!-- End Sid Bar  -->

<!-- Start Mobile Sidebar -->
<div class="offcanvas offcanvas-start d-lg-block d-lg-none d-xl-block d-xl-none d-xxl-block d-xxl-none" data-bs-scroll="true" data-bs-backdrop="false" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
    <div class="offcanvas-header pb-0">
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body pt-0">
        <div class="logo-box text-center">
            <div class="logo-avatar-wrapper mb-2">
                <img class="logo-image" src="{{ get_store_logo(Auth::user()->tenant_id) }}" alt="Store Logo" width="56" height="56">
                @if(get_seller_data(Auth::user()->tenant_id)->approval_status == 'approved')  
                    <span class="verified-badge" title="متجر موثق">
                        <i class="bi bi-check-lg"></i>
                    </span>
                @endif
            </div>
            <div class="user-name">
                <span class="user-tenant-badge">
                    <i class="fa-solid fa-user me-1 small"></i> {{ Auth::user()->name }}
                </span>
            </div>
        </div>   
        <hr class="my-3 opacity-25 text-white">
        <!--Start Menu-->
        @include('users.sellers.components.sidbar.inc.menu.index')
        <!--End Menu-->
    </div>
</div>
<!--End Mobile Sidebar-->