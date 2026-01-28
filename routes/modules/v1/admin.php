<?php

use App\Http\Controllers\Admins\Admin\AdminController;
use App\Http\Controllers\Admins\Admin\AdminDisputeController;
use App\Http\Controllers\Admins\Admin\AdminEmployeeController;
use App\Http\Controllers\Admins\admin\ArchivesDisputesController;
use App\Http\Controllers\Admins\Admin\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Admins\Admin\NotificationController;
use App\Http\Controllers\Admins\Admin\PaymentsController;
use App\Http\Controllers\Admins\Admin\PaymentsProofsRefusedController;
use App\Http\Controllers\Admins\Admin\PaymentsProofsRefusedsArchivesController;
use App\Http\Controllers\Admins\admin\ProofsRefusedChatController;
use App\Http\Controllers\Admins\Admin\SellerController;
use App\Http\Controllers\Admins\Admin\SettingController;
use App\Http\Controllers\Admins\Admin\SupplierController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "admin" middleware group. Make something great!
|
*/
// routes/admin.php, api.php or any other central route files you have

foreach (config('tenancy.central_domains') as $domain) {
    Route::domain($domain)->group(function () {
        // your actual routes
        Route::name('admin.')->group(function () {
            Route::middleware('guest')->group(function () {
                Route::get('/ah-login', [AuthenticatedSessionController::class, 'create'])->name('login');
                Route::post('/ah-login', [AuthenticatedSessionController::class, 'login']);
            });
            Route::middleware('admin')->group(function () {
                Route::get('/ah-admin', [AdminController::class, 'index'])->name('dashboard');
                Route::post('/ah-logout', [AuthenticatedSessionController::class, 'logout'])->name('logout');
                // setting admin routes here
                Route::get('/ah-admin/settings', [SettingController::class, 'index'])->name('settings');
                // suppliers actions
                Route::get('/ah-admin/suppliers', [SupplierController::class, 'index'])->name('suppliers');
                Route::delete('/ah-admin/supplier/destroy/{id}', [SupplierController::class, 'destroy'])->name('supplier.destroy');
                // sellers actions
                Route::get('/ah-admin/sellers', [SellerController::class, 'index'])->name('sellers');
                Route::delete('/ah-admin/seller/destroy/{id}', [SellerController::class, 'destroy'])->name('seller.destroy');
                // payments Routes
                Route::get('/ah-admin/payments/rechage-requests', [PaymentsController::class, 'recharge_requests'])->name('payments.recharge_requests');
                Route::patch('/admin/payments/recharge-request/approve/{id}', [PaymentsController::class, 'approve_recharge'])->name('payments.recharge.approve');
                Route::get('/ah-admin/payments/invoices-payments', [PaymentsController::class, 'invoices_payments'])->name('payments.invoices_payments');
                Route::patch('/admin/payments/invoice/approve/{id}', [PaymentsController::class, 'approve_invoice_payment'])->name('payments.invoice.approve');
                Route::get('/ah-admin/payments/subscribes-payments', [PaymentsController::class, 'subscribes_payments'])->name('payments.subscribes_payments');
                Route::get('/ah-admin/payments/suppliers/subscribes-payments', [PaymentsController::class, 'suppliers_subscribes_payments'])->name('payments.suppliers.subscribes_payments');
                Route::patch('/admin/payments/suppliers/subscribe/approve/{id}', [PaymentsController::class, 'approve_suppliers_subscribe_payment'])->name('payments.suppliers.subscribe.approve');
                Route::get('/ah-admin/payments/sellers/subscribes-payments', [PaymentsController::class, 'sellers_subscribes_payments'])->name('payments.sellers.subscribes_payments');
                Route::patch('/admin/payments/sellers/subscribe/approve/{id}', [PaymentsController::class, 'approve_sellers_subscribe_payment'])->name('payments.sellers.subscribe.approve');
                // disputes routes
                Route::get('/ah-admin/payment-proof/disputes', [AdminDisputeController::class, 'index'])->name('payment_proof.disputes');
                Route::get('/ah-admin/payment-proof/dispute/{id}/show', [AdminDisputeController::class, 'show'])->name('payment_proof.dispute.show');
                Route::put('/ah-admin/payment-proof/dispute/{id}/update', [AdminDisputeController::class, 'updateStatus'])->name('payment_proof.dispute.updateStatus');
                Route::post('/ah-admin/payment-proof/dispute/{id}/reply', [AdminDisputeController::class, 'reply'])->name('payment_proof.dispute.reply');
                Route::get('/ah-admin/disputes/{id}/export-pdf', [AdminDisputeController::class, 'exportPdf'])->name('payment_proof.disputes.export.pdf');
                Route::delete('/ah-admin/payment-proof/disputes/{dispute}', [AdminDisputeController::class, 'destroy'])->name('payment_proof.dispute.destroy');
                // Archived disputes routes
                Route::get('/ah-admin/payment-proof/disputes/archives', [ArchivesDisputesController::class, 'index'])->name('payment_proof.disputes.archives');
                Route::get('/ah-admin/payment-proof/disputes/archive/{id}/download', [ArchivesDisputesController::class, 'download'])->name('payment_proof.dispute.archive.download');
                Route::delete('/ah-admin/payment-proof/disputes/archive/{id}/destroy', [ArchivesDisputesController::class, 'destroy'])->name('payment_proof.dispute.archive.destroy');
                // payments proofs refused routes
                Route::get('/ah-admin/payment-proof/disputes/refused', [PaymentsProofsRefusedController::class, 'index'])->name('payment_proof.disputes.refused');
                Route::get('/ah-admin/payment-proof/dispute/{id}/refused/show', [PaymentsProofsRefusedController::class, 'show'])->name('payment_proof.dispute.refused.show');
                Route::put('/ah-admin/payment-proof/refused/{id}/update', [PaymentsProofsRefusedController::class, 'update'])->name('payment_proof.refused.update');
                Route::delete('/ah-admin/payment-proof/dispute/refused/{id}/destroy', [PaymentsProofsRefusedController::class, 'destroy'])->name('payment_proof.refused.destroy');
                // payments proofs refused archives route
                Route::get('/ah-admin/payment-proof/disputes/refused/archives', [PaymentsProofsRefusedsArchivesController::class, 'index'])->name('payment_proof.disputes.refused.archive');
                Route::get('/ah-admin/payment-proof/dispute/{id}/refused/download', [PaymentsProofsRefusedsArchivesController::class, 'download'])->name('payment_proof.dispute.refused.download');
                Route::delete('/ah-admin/payment-proof/dispute/{id}/refused/destroy', [PaymentsProofsRefusedsArchivesController::class, 'destroy'])->name('payment_proof.dispute.refused.destroy');
                // proofs refused messages routes
                Route::get('/ah-admin/payment-proof/refused/{id}/messages', [ProofsRefusedChatController::class, 'fetchMessages'])->name('payment_proof.refused.messages.fetch');
                Route::post('/ah-admin/payment-proof/refused/{id}/messages/send', [ProofsRefusedChatController::class, 'sendMessage'])->name('payment_proof.refused.messages.send');
                Route::post('/ah-admin/payment-proof/refused/{id}/messages/read', [ProofsRefusedChatController::class, 'markAsRead'])->name('payment_proof.refused.messages.read');
                Route::get('/ah-admin/payment-proof/refused/{id}/messages/get', [ProofsRefusedChatController::class, 'getMessages'])->name('payment_proof.refused.messages.get');
                // dispute messages routes
                Route::get('/ah-admin/payment-proof/dispute/{id}/messages', [AdminDisputeController::class, 'fetch'])->name('payment_proof.dispute.messages.fetch');
                Route::post('/ah-admin/payment-proof/disputes/{dispute}/messages/mark-as-read', [AdminDisputeController::class, 'markAsRead'])->name('payment_proof.disputes.messages.markAsRead');
                // notifications routes
                Route::get('/ah-admin/notifications', [NotificationController::class, 'index'])->name('notifications');
                // employees routes
                Route::middleware('ForBossOnly')->group(function () {
                    Route::get('/ah-admin/employees', [AdminEmployeeController::class, 'index'])->name('employees');
                    Route::get('/ah-admin/employees/create', [AdminEmployeeController::class, 'create'])->name('employees.create');
                    Route::post('/ah-admin/employees', [AdminEmployeeController::class, 'store'])->name('employees.store');
                    Route::get('/ah-admin/employees/{id}/edit', [AdminEmployeeController::class, 'edit'])->name('employees.edit');
                    Route::put('/ah-admin/employees/{id}', [AdminEmployeeController::class, 'update'])->name('employees.update');
                    Route::delete('/ah-admin/employees/{id}', [AdminEmployeeController::class, 'destroy'])->name('employees.destroy');
                });
            });
        });
    });
}
