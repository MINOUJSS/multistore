<script>
const chatBoxContainer = document.getElementById('chatBoxContainer');
const openChatBtn = document.getElementById('openChatBtn');
const closeChatBtn = document.getElementById('closeChatBtn');
const chatBox = document.getElementById('chatBox');

// فتح المحادثة
openChatBtn.addEventListener('click', async () => {
    chatBoxContainer.style.display = 'block';
    openChatBtn.style.display = 'none';
    chatBox.scrollTop = chatBox.scrollHeight;

    // تعليم الرسائل كمقروءة
    try {
        await fetch(`{{ route('admin.payment_proof.disputes.messages.markAsRead', $dispute->id) }}`, {
            method: "POST",
            headers: { "X-CSRF-TOKEN": "{{ csrf_token() }}" }
        });
        document.getElementById("chatBadge").classList.add("d-none");
    } catch (e) {
        console.error("لم يتم تحديث حالة القراءة:", e);
    }
});

// غلق المحادثة
closeChatBtn.addEventListener('click', () => {
    chatBoxContainer.style.display = 'none';
    openChatBtn.style.display = 'block';
});

// إرسال رسالة جديدة
document.getElementById('adminChatForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    const formData = new FormData(this);
    formData.append('_token', "{{ csrf_token() }}");

    const response = await fetch("{{ route('admin.payment_proof.dispute.reply', $dispute->id ?? 0) }}", {
        method: "POST",
        body: formData
    });

    if (response.ok) {
        const data = await response.json();

        // توليد HTML للمرفقات إن وُجدت
        let attachmentsHtml = "";
        if (Array.isArray(data.attachments) && data.attachments.length > 0) {
            attachmentsHtml = `
                <div class="mt-2">
                    ${data.attachments.map((file, i) => `
                        <a href="/storage/${file.replace('app/public/', '')}" target="_blank"
                           class="d-block text-decoration-underline text-light small">
                            📎 مرفق ${i + 1}
                        </a>
                    `).join('')}
                </div>`;
        }

        // عرض الرسالة مباشرة في المحادثة
        chatBox.innerHTML += `
            <div class="d-flex mb-3">
                <img src="{{ asset('asset/v1/users/dashboard') }}/img/avatars/man.png"
                     width="40" height="40" class="rounded-circle ms-2" alt="Admin">
                <div class="bg-primary text-white p-2 px-3 rounded-3" style="max-width: 75%;">
                    <p class="mb-1">${data.message ?? formData.get('message')}</p>
                    ${attachmentsHtml}
                    <small class="text-white-50">الآن</small>
                </div>
                
            </div>
        `;

        this.reset();
        chatBox.scrollTop = chatBox.scrollHeight;
    } else {
        alert("حدث خطأ أثناء إرسال الرسالة!");
    }
});

// تشغيل صوت الرسائل الجديدة
const messageSound = document.getElementById('messageSound');
let soundAllowed = false;

document.addEventListener('click', () => soundAllowed = true);
document.addEventListener('keydown', () => soundAllowed = true);

let lastMessageCount = 0;

// جلب الرسائل الجديدة دورياً
async function fetchMessages() {
    try {
        const res = await fetch(`{{ route('admin.payment_proof.dispute.messages.fetch', $dispute->id) }}`);
        const data = await res.json();
        const messages = data.messages || [];
        const unreadCount = data.unread_count || 0;

        const chatBadge = document.getElementById("chatBadge");
        if (unreadCount > 0) {
            chatBadge.textContent = unreadCount;
            chatBadge.classList.remove("d-none");
        } else {
            chatBadge.classList.add("d-none");
        }

        if (messages.length !== lastMessageCount) {
            chatBox.innerHTML = '';
            messages.forEach(m =>
                appendMessage(m.message, m.sender_type, m.created_at, m.attachments)
            );

            // صوت عند وصول رسالة جديدة من الزبون
            if (lastMessageCount && messages.length > lastMessageCount) {
                const lastMsg = messages[messages.length - 1];
                if (lastMsg.sender_type !== 'admin' && soundAllowed) {
                    messageSound.play().catch(err => console.warn("⚠️ لم يُسمح بتشغيل الصوت:", err));
                }
            }

            lastMessageCount = messages.length;
        }

    } catch (err) {
        console.error('Error fetching messages:', err);
    }
}

setInterval(fetchMessages, 5000);
fetchMessages();

// ✅ دالة عرض الرسائل مع المرفقات
function appendMessage(text, sender, date, attachments = []) {
    const div = document.createElement('div');
    div.className = sender === 'admin' ? 'text-end mb-2' : 'text-start mb-2';

    // 🔹 تأكد أن attachments مصفوفة فعلًا
    if (typeof attachments === 'string') {
        try {
            attachments = JSON.parse(attachments);
        } catch (e) {
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

                    // تأكد أن الرابط مطلق (asset كامل)
                    const fileUrl = file.startsWith('http') ? file : `/storage/${file.replace(/^public\//, '')}`;

                    if (isImage) {
                        return `
                            <a href="${fileUrl}" target="_blank">
                                <img src="${fileUrl}" alt="attachment"
                                     class="rounded mt-1 border"
                                     style="max-width:150px; max-height:150px; border:1px solid #ccc;">
                            </a>`;
                    } else {
                        const fileName = file.split('/').pop();
                        return `
                            <a href="/storage/app/public/${file.replace('app/public/', '')}" target="_blank"
                            class="btn btn-outline-light btn-sm d-inline-block me-1">
                            📎 مرفق ${i + 1}
                            </a>`;
                    }
                }).join('')}
            </div>`;
    }

    // 🔹 بناء الرسالة
    div.innerHTML = `
        ${sender === 'admin'
            ? `<div class="d-flex mb-3">
                <img src="{{ asset('asset/v1/users/dashboard') }}/img/avatars/man.png"
                         width="40" height="40" class="rounded-circle ms-2" alt="Admin">`
            : `<div class="d-flex justify-content-end mb-3">`}

            <div class="p-2 px-3 rounded-3 ${sender === 'admin' ? 'bg-primary text-white' : 'bg-white border'}"
                 style="max-width: 75%;">
                <p class="mb-1">${text || ''}</p>
                ${attachmentsHTML}
                <small class="text-muted-50 d-block mt-1">${formatTimeAgo(date) ?? date}</small>
            </div>

            ${sender === 'customer'
                ? `<img src="https://cdn-icons-png.flaticon.com/512/3177/3177440.png"
                         width="40" height="40" class="rounded-circle me-2" alt="User">`
                : ''}
        </div>
    `;

    chatBox.appendChild(div);
    chatBox.scrollTop = chatBox.scrollHeight;
}


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