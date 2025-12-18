<script>
    document.addEventListener('DOMContentLoaded', function() {
                const replyForm = document.getElementById('replyForm');
                const messagesContainer = document.getElementById('messages-container');
                const token = "{{ $dispute->access_token }}";
                const unreadBadge = document.getElementById('unreadBadge');
                const unreadCountEl = document.getElementById('unreadCount');
                let lastMessageId = {{ $dispute->messages->last()->id ?? 0 }};
                let unreadCount = 0;
                let windowActive = true;
                messagesContainer.scrollTop = messagesContainer.scrollHeight;

                // 🔔 صوت الإشعار
                const notificationSound = new Audio('{{ asset('asset/v1/users/dashboard/sounds/notification.mp3') }}');

                // 🧠 متابعة حالة النافذة
                window.addEventListener('focus', () => {
                    windowActive = true;
                    unreadCount = 0;
                    hideBadge();
                });
                window.addEventListener('blur', () => windowActive = false);

                // ✅ إرسال الرد مع المرفقات
                if (replyForm) {
                    replyForm.addEventListener('submit', async function(e) {
                        e.preventDefault();
                        const message = document.getElementById('message').value.trim();
                        const files = document.getElementById('attachments').files;

                        if (!message && files.length === 0) {
                            alert("⚠️ الرجاء كتابة رسالة أو إضافة مرفق على الأقل.");
                            return;
                        }

                        const formData = new FormData(replyForm);
                        formData.append('_token', "{{ csrf_token() }}");

                        try {
                            const response = await fetch(`/dispute/${token}/reply`, {
                                method: "POST",
                                body: formData
                            });

                            const result = await response.json();

                            if (response.ok) {
                                // appendMessage(
                                //     'customer',
                                //     message ? message : '📎 تم إرسال مرفقات',
                                //     'الآن',
                                //     result.attachments || []
                                // );
                                replyForm.reset();
                            } else {
                                alert(result.message || "⚠️ حدث خطأ أثناء إرسال الرسالة");
                            }
                        } catch (error) {
                            console.error(error);
                            alert("❌ فشل الاتصال بالخادم");
                        }
                    });
                }

                // 🧩 عرض الرسائل
                function appendMessage(sender, text, time, attachments = []) {
                    const div = document.createElement('div');
                    div.classList.add('mb-3', sender === 'customer' ? 'text-end' : 'text-start');

                    // 🔹 تأكد أن attachments مصفوفة فعلًا
                    if (typeof attachments === 'string') {
                        try {
                            attachments = JSON.parse(attachments);
                        } catch {
                            attachments = [];
                        }
                    } else if (!Array.isArray(attachments)) {
                        attachments = [];
                    }

                    // 🔹 بناء قسم المرفقات
                    let attachmentsHTML = '';
                    if (attachments.length > 0) {
                        attachmentsHTML = `
                <div class="mt-2">
                    ${attachments.map((file, i) => {
                        if (!file) return '';
                        const ext = file.split('.').pop().toLowerCase();
                        const isImage = ['jpg', 'jpeg', 'png', 'gif', 'webp'].includes(ext);
                        const fileUrl = file.startsWith('http') ? file : `/storage/${file.replace(/^public\//, '')}`;

                        if (isImage) {
                            return `
                                <a href="${fileUrl}" target="_blank">
                                    <img src="${fileUrl}" alt="attachment"
                                        class="rounded mt-1 border"
                                        style="max-width:150px; max-height:150px;">
                                </a>`;
                        } else {
                            const fileName = file.split('/').pop();
                            return ` <a href = "${fileUrl}" target = "_blank" class = "btn btn-outline-light btn-sm d-inline-block me-1" > 📎المرفق ${i+1} </a>`;
                    }
                }).join('')
        } </div>`;
    }

    // 🔹 بناء الرسالة
    
    div.innerHTML = `
            <div class="d-inline-block p-2 rounded-3 shadow-sm 
                ${sender === 'customer' ? 'bg-primary text-white' : 'bg-secondary text-white'}">
                <p class="mb-1">${text || ''}</p>
                ${attachmentsHTML}
            </div>
            <div class="small text-muted mt-1">${formatTimeAgo(time)} (${sender === 'customer' ? 'أنت' : 'الإدارة'})</div>
        `;
    
        messagesContainer.appendChild(div);
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
    

    }

    // 🔁 جلب الرسائل الجديدة كل 5 ثوانٍ
    setInterval(fetchNewMessages, 5000);

    async function fetchNewMessages() {
        try {
            const response = await fetch(`/dispute/${token}/messages?after=${lastMessageId}`);
            if (!response.ok) return;

            const data = await response.json();
            if (data.messages && data.messages.length > 0) {
                data.messages.forEach(msg => {
                    appendMessage(
                        msg.sender_type,
                        msg.message || '📎 مرفقات جديدة',
                        msg.time_ago,
                        msg.attachments || []
                    );
                    lastMessageId = msg.id;
                });

                // 🔔 إشعار فقط عند وصول رسائل من الإدارة
                if (data.messages.some(m => m.sender_type === 'admin')) {
                    notificationSound.play().catch(() => {});
                }

                if (!windowActive) {
                    unreadCount += data.messages.length;
                    showBadge();
                }
            }
        } catch (err) {
            console.error("خطأ في جلب الرسائل:", err);
        }
    }

    // 🎯 شارة الرسائل غير المقروءة
    function showBadge() {
        unreadCountEl.textContent = unreadCount;
        unreadBadge.classList.remove('d-none');
    }

    function hideBadge() {
        unreadBadge.classList.add('d-none');
    }
    });

// دوال الوقت بالعربية
function formatTimeAgo(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const diffInSeconds = Math.floor((now - date) / 1000);

    if (diffInSeconds < 0) return "في المستقبل";

    const intervals = {
        سنة: 31536000,
        شهر: 2592000,
        أسبوع: 604800,
        يوم: 86400,
        ساعة: 3600,
        دقيقة: 60,
        ثانية: 1
    };

    if (diffInSeconds < 60) return "منذ قليل";

    for (const [unit, secondsInUnit] of Object.entries(intervals)) {
        const diff = Math.floor(diffInSeconds / secondsInUnit);
        if (diff >= 1) return `منذ ${diff} ${getArabicUnit(unit, diff)}`;
    }

    return "منذ قليل";
}

function getArabicUnit(unit, count) {
    const units = {
        سنة: ['سنة', 'سنتين', 'سنوات'],
        شهر: ['شهر', 'شهرين', 'أشهر'],
        أسبوع: ['أسبوع', 'أسبوعين', 'أسابيع'],
        يوم: ['يوم', 'يومين', 'أيام'],
        ساعة: ['ساعة', 'ساعتين', 'ساعات'],
        دقيقة: ['دقيقة', 'دقيقتين', 'دقائق'],
        ثانية: ['ثانية', 'ثانيتين', 'ثواني']
    };
    if (count === 1) return units[unit][0];
    if (count === 2) return units[unit][1];
    return units[unit][2];
}
</script>
