<style>
    body { direction: rtl; text-align: right; }

    #chatBoxContainer { animation: slideInUp 0.3s ease-out; }
    @keyframes slideInUp {
        from { transform: translateY(20px); opacity: 0; }
        to { transform: translateY(0); opacity: 1; }
    }

    #chatBox::-webkit-scrollbar { width: 6px; }
    #chatBox::-webkit-scrollbar-thumb { background: #ccc; border-radius: 10px; }
</style>

<button id="openChatBtn" class="btn btn-primary rounded-circle shadow"
        style="position: fixed; bottom: 20px; left: 20px; width: 60px; height: 60px; z-index: 1050;">
    💬
    <span id="chatBadge"
        class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger d-none">0</span>
</button>

<div id="chatBoxContainer" class="card shadow-lg border-0"
    style="position: fixed; bottom: 90px; left: 20px; width: 360px; max-height: 520px; display: none; z-index: 1060; border-radius: 20px; overflow: hidden;">

    <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
        <div>
            💼 <strong>محادثة حول إثبات دفع مرفوض #{{ $proof->id ?? '—' }}</strong><br>
            <small>رقم الطلبية: {{ $proof->order_number ?? '—' }}</small>
        </div>
        <button id="closeChatBtn" class="btn btn-sm btn-light text-primary border-0">✖</button>
    </div>

    <div id="chatBox" class="card-body bg-light" style="height: 350px; overflow-y: auto; padding: 15px;">
    </div>

    <div class="card-footer bg-white">
        <form id="adminChatForm" enctype="multipart/form-data" method="POST">
            <div class="input-group">
                <input type="text" name="message" class="form-control" placeholder="✍️ اكتب رسالة..." required>
                <label class="btn btn-outline-secondary mb-0">📎
                    <input type="file" name="attachments[]" multiple hidden>
                </label>
                <button class="btn btn-primary" type="submit">📨</button>
            </div>
        </form>
    </div>

    <audio id="messageSound" src="{{ asset('asset/v1/users/dashboard/sounds/notification.mp3') }}" preload="auto"></audio>
</div>


