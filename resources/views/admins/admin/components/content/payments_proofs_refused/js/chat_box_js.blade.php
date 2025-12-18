<script>
    const chatBoxContainer = document.getElementById('chatBoxContainer');
    const openChatBtn = document.getElementById('openChatBtn');
    const closeChatBtn = document.getElementById('closeChatBtn');
    const chatBox = document.getElementById('chatBox');
    const messageSound = document.getElementById('messageSound');
    let soundAllowed = false;
    let lastMessageCount = 0;

    document.addEventListener('click', () => soundAllowed = true);
    document.addEventListener('keydown', () => soundAllowed = true);

    // ✅ فتح الدردشة
    openChatBtn.addEventListener('click', async () => {
        chatBoxContainer.style.display = 'block';
        openChatBtn.style.display = 'none';
        chatBox.scrollTop = chatBox.scrollHeight;

        var chatBadgeCount = document.getElementById("chatBadge").textContent;

        // ✅ تعليم الرسائل كمقروءة
        await fetch(`{{ route('admin.payment_proof.refused.messages.read', $proof->id) }}`, {
            method: "POST",
            headers: {
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            }
        });
        document.getElementById("chatBadge").classList.add("d-none");
        //get unread message count
        var unreadMsg = document.getElementById("unreadMessages").textContent;
        if (unreadMsg != 0) {
            var newUnreadMsg = parseInt(unreadMsg) - parseInt(chatBadgeCount);
            //update unread message count
            document.getElementById("unreadMessages").textContent = newUnreadMsg;
            //set span UnradesProofsRefusedMessages value to 0
            document.getElementById("UnradesProofsRefusedMessages").setAttribute('data-value', 0);
        }

        // ✅ جلب الرسائل القديمة
        try {
            const res = await fetch(`{{ route('admin.payment_proof.refused.messages.get', $proof->id) }}`);
            if (res.ok) {
                const data = await res.json();
                const oldMessages = data.messages || [];
                chatBox.innerHTML = '';
                oldMessages.forEach(m =>
                    appendMessage(m.message, m.sender_type, m.created_at, m.attachments)
                );
                lastMessageCount = oldMessages.length;
                chatBox.scrollTop = chatBox.scrollHeight;
            }
        } catch (err) {
            console.error("❌ خطأ أثناء تحميل الرسائل القديمة:", err);
        }
    });

    // ✅ غلق الدردشة
    closeChatBtn.addEventListener('click', () => {
        chatBoxContainer.style.display = 'none';
        openChatBtn.style.display = 'block';
    });

    // ✅ إرسال رسالة جديدة
    document.getElementById('adminChatForm').addEventListener('submit', async function(e) {
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('_token', "{{ csrf_token() }}");

        const res = await fetch("{{ route('admin.payment_proof.refused.messages.send', $proof->id) }}", {
            method: "POST",
            body: formData
        });

        if (res.ok) {
            const data = await res.json();
            appendMessage(data.message, 'admin', 'الآن', data.attachments);
            this.reset();
        }
    });

    // ✅ جلب الرسائل بشكل دوري
    async function fetchMessages() {
        try {
            const res = await fetch(`{{ route('admin.payment_proof.refused.messages.fetch', $proof->id) }}`);
            const data = await res.json();
            const messages = data.messages || [];
            const unread = data.unread_count || 0;

            // شارة عدد الرسائل غير المقروءة
            const chatBadge = document.getElementById("chatBadge");
            const UnradesProofsRefusedMessages = document.getElementById("UnradesProofsRefusedMessages").getAttribute('data-value');
            if (unread > 0) {
                chatBadge.textContent = unread;
                chatBadge.classList.remove("d-none");
                //set span UnradesProofsRefusedMessages value to 0
                document.getElementById("UnradesProofsRefusedMessages").setAttribute('data-value', unread);
                //get unread message count
                var unreadMsg = document.getElementById("unreadMessages").textContent;
                if (UnradesProofsRefusedMessages != unread) {
                    //set span UnradesProofsRefusedMessages value to 0
                    document.getElementById("UnradesProofsRefusedMessages").setAttribute('data-value', unread);
                    var newUnreadMsg = parseInt(unread); //ad more unread messages in the future
                    //update unread message count
                    document.getElementById("unreadMessages").textContent = newUnreadMsg;
                }
            } else {
                chatBadge.classList.add("d-none");
            }

            // تحديث الرسائل فقط عند وجود تغيير
            if (messages.length !== lastMessageCount) {
                chatBox.innerHTML = '';
                messages.forEach(m => appendMessage(m.message, m.sender_type, m.created_at, m.attachments));

                // تشغيل صوت عند وجود رسالة جديدة من البائع
                if (lastMessageCount && messages.length > lastMessageCount) {
                    const last = messages[messages.length - 1];
                    if (last.sender_type !== 'admin' && soundAllowed)
                        messageSound.play().catch(() => {});
                }

                lastMessageCount = messages.length;
            }
        } catch (e) {
            console.error("❌ Error in fetchMessages:", e);
        }
    }
    setInterval(fetchMessages, 5000);
    fetchMessages();

    // ✅ إنشاء عنصر الرسالة
    function appendMessage(text, sender, date, attachments = []) {
        // تأكد أن attachments مصفوفة دائمًا
        if (attachments && typeof attachments === 'string') {
            try {
                attachments = JSON.parse(attachments);
            } catch {
                attachments = [];
            }
        }
        if (!Array.isArray(attachments)) attachments = [];

        const div = document.createElement('div');
        div.className = sender === 'admin' ? 'text-end mb-3' : 'text-start mb-3';

        let attHTML = '';
        if (attachments.length > 0) {
            attHTML = attachments.map(a => {
                const ext = a.split('.').pop().toLowerCase();
                const imageExts = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp'];
                const fileUrl = `/storage/general/${a}`;
                const fileName = a.split('/').pop();

                if (imageExts.includes(ext)) {
                    return `<a href="${fileUrl}" target="_blank">
                            <img src="${fileUrl}" class="img-thumbnail d-block mb-1" style="max-width:200px; max-height:200px;">
                        </a>`;
                } else {
                    return `<a href="${fileUrl}" target="_blank" class="d-block small">📎 ${fileName}</a>`;
                }
            }).join('');
        }

        div.innerHTML = `
        <div class="d-flex ${sender === 'admin' ? 'justify-content-start' : 'justify-content-end'} align-items-end">
            ${sender === 'admin'
                ? '<img src="{{ asset('asset/v1/users/dashboard/img/avatars/man.png') }}" width="35" height="35" class="rounded-circle ms-2">'
                : '<img src="https://cdn-icons-png.flaticon.com/512/3177/3177440.png" width="35" class="rounded-circle me-2">'}
            <div class="${sender === 'admin' ? 'bg-primary text-white' : 'bg-white border'} p-2 rounded-3" style="max-width:75%;">
                <p class="mb-1">${text || ''}</p>
                ${attHTML}
                <small class="text-muted">${formatTimeAgo(date)}</small>
            </div>
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
