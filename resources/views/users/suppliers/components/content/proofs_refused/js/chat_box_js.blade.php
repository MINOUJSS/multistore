{{-- Chat Box JavaScript --}}
<script>
    const proofId = {{ $proof->id }}; // Assuming $proof is passed to the view
    const csrfToken = '{{ csrf_token() }}';

    const chatBoxContainer = document.getElementById('chatBoxContainer');
    const openChatBtn = document.getElementById('openChatBtn');
    const closeChatBtn = document.getElementById('closeChatBtn');
    const chatBox = document.getElementById('chatBox');
    const messageSound = document.getElementById('messageSound');
    let soundAllowed = false;
    let lastMessageCount = 0;

    // Allow sound after user interaction
    document.addEventListener('click', () => soundAllowed = true);
    document.addEventListener('keydown', () => soundAllowed = true);

    // Open chat box
    openChatBtn.addEventListener('click', async () => {
        chatBoxContainer.style.display = 'block';
        openChatBtn.style.display = 'none';
        chatBox.scrollTop = chatBox.scrollHeight;
        var chatBadgeCount = document.getElementById("chatBadge").textContent;
        // Mark messages as read (from supplier's perspective)
        try {
            await fetch(`{{ route('supplier.proofs.refused.chat.read', ['proofId' => $proof->id]) }}`, { // Updated route
                method: "POST",
                headers: {
                    "X-CSRF-TOKEN": csrfToken,
                    "Content-Type": "application/json"
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

        } catch (err) {
            console.error("❌ Error marking messages as read:", err);
        }

        // Load old messages
        try {
            const res = await fetch(
                `{{ route('supplier.proofs.refused.chat.get_messages', ['proofId' => $proof->id]) }}`, { // Updated route
                    method: "GET",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken
                    }
                });
            if (res.ok) {
                const data = await res.json();
                const oldMessages = data.messages || [];
                chatBox.innerHTML = ''; // Clear before displaying
                oldMessages.forEach(m =>
                    appendMessage(m.message, m.sender_type, m.created_at, m.attachments)
                );
                lastMessageCount = oldMessages.length;
                chatBox.scrollTop = chatBox.scrollHeight;
            } else {
                console.error("❌ Failed to load old messages:", res.status, res.statusText);
            }
        } catch (err) {
            console.error("❌ Error fetching old messages:", err);
        }
    });

    // Close chat box
    closeChatBtn.addEventListener('click', () => {
        chatBoxContainer.style.display = 'none';
        openChatBtn.style.display = 'block';
    });

    // Send message
    document.getElementById('supplierChatForm').addEventListener('submit', async function(e) { // Changed form ID
        e.preventDefault();
        const formData = new FormData(this);
        formData.append('_token', csrfToken); // Ensure token is appended

        try {
            const res = await fetch(
                "{{ route('supplier.proofs.refused.chat.send', ['proofId' => $proof->id]) }}", { // Updated route
                    method: "POST",
                    body: formData
                });
            if (res.ok) {
                const data = await res.json();
                appendMessage(data.message, data.sender_type, 'الآن', data.attachments);
                this.reset(); // Clear form
            } else {
                console.error("❌ Failed to send message:", res.status, res.statusText);
                // Optionally display an error message to the user
            }
        } catch (err) {
            console.error("❌ Error sending message:", err);
            // Optionally display an error message to the user
        }
    });

    // Fetch new messages periodically
    async function fetchMessages() {
        try {
            const res = await fetch(
                `{{ route('supplier.proofs.refused.chat.fetch', ['proofId' => $proof->id]) }}`, { // Updated route
                    method: "GET",
                    headers: {
                        "X-CSRF-TOKEN": csrfToken
                    }
                });

            if (!res.ok) {
                console.error("❌ Failed to fetch messages:", res.status, res.statusText);
                return;
            }
            const data = await res.json();
            const messages = data.messages || [];
            const unread = data.unread_count || 0;

            const chatBadge = document.getElementById("chatBadge");
            const UnradesProofsRefusedMessages = document.getElementById("UnradesProofsRefusedMessages")
                .getAttribute('data-value');
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

            // Only update if new messages arrived
            if (messages.length !== lastMessageCount) {
                chatBox.innerHTML = ''; // Clear and re-append all messages for simplicity
                messages.forEach(m => appendMessage(m.message, m.sender_type, m.created_at, m.attachments));

                // Play sound if new message from other party and sound is allowed
                if (lastMessageCount && messages.length > lastMessageCount) {
                    const lastMessage = messages[messages.length - 1];
                    // Check if the last message is from the 'admin' (who is on the left now) and sound is allowed
                    if (lastMessage.sender_type === 'admin' && soundAllowed) {
                        messageSound.play().catch(e => console.warn("Audio play failed:", e));
                    }
                }
                lastMessageCount = messages.length;
            }
        } catch (e) {
            console.error("❌ Error in fetchMessages:", e);
        }
    }

    // Initial fetch and interval
    setInterval(fetchMessages, 5000); // Fetch every 5 seconds
    fetchMessages(); // Initial fetch

    // Function to append a message to the chat box
    function appendMessage(text, sender_type, date, attachments = []) { // Renamed 'sender' to 'sender_type'
        const div = document.createElement('div');
        let uiRole = '';
        const adminAvatarUrl = '{{ asset('asset/v1/users/dashboard/img/avatars/man.png') }}';
        const userAvatarUrl = 'https://cdn-icons-png.flaticon.com/512/3177/3177440.png';

        // Determine UI role based on backend sender_type
        // 'admin' (backend) means the admin is chatting with the supplier -> display as 'supplier' (left)
        // 'supplier' (backend) means the supplier is chatting -> display as 'admin' (right)
        if (sender_type === 'admin') {
            uiRole = 'admin'; // Display as supplier (left side)
        } else if (sender_type === 'user') {
            uiRole = 'user'; // Display as admin (right side)
        } else {
            uiRole = 'other'; // Fallback for unknown sender types
        }

        // Apply styling based on uiRole
        const alignmentClass = uiRole === 'admin' ? 'text-end mb-3' :
            'text-start mb-3'; // text-end for right, text-start for left
        const flexJustification = uiRole === 'admin' ? 'justify-content-end' :
            'justify-content-start'; // justify-content-end for right, justify-content-start for left
        const bubbleClass = uiRole === 'admin' ? 'bg-primary text-white' :
            'bg-white border'; // Primary bubble for admin (right), white for user (left)
        const avatarSrc = uiRole === 'admin' ? userAvatarUrl : adminAvatarUrl; // Swap avatar sources
        const avatarClass = uiRole === 'admin' ? 'rounded-circle me-2' : 'rounded-circle ms-2'; // Margin for avatar

        div.className = alignmentClass;

        let attHTML = '';
        if (attachments && typeof attachments === 'string') {
            try {
                attachments = JSON.parse(attachments);
            } catch (e) {
                attachments = [];
            }
        }

        if (Array.isArray(attachments) && attachments.length > 0) {
            attHTML = attachments.map(a => {
                const attachmentUrl = a.startsWith('/') ? a : '/storage/general/' + a;
                const fileName = attachmentUrl.split('/').pop();
                const fileExtension = fileName.split('.').pop().toLowerCase();
                const imageExts = ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp'];

                if (imageExts.includes(fileExtension)) {
                    return `<a href="${attachmentUrl}" target="_blank"><img src="${attachmentUrl}" alt="Attachment Image" class="img-thumbnail d-block mb-1" style="max-width:200px; max-height:200px;"></a>`;
                } else {
                    return `<a href="${attachmentUrl}" target="_blank" class="d-block small">📎 ${fileName}</a>`;
                }
            }).join('');
        }

        div.innerHTML = `
        <div class="d-flex ${flexJustification}">
            ${uiRole === 'user' ? `<img src="${adminAvatarUrl}" width="35" height="35" class="rounded-circle ms-2">` : ''}
            <div class="${bubbleClass} p-2 rounded-3" style="max-width:75%;">
                <p class="mb-1">${text || ''}</p>
                ${attHTML}
                <small class="text-muted">${formatTimeAgo(date)}</small>
            </div>
            ${uiRole === 'admin' ? `<img src="${userAvatarUrl}" width="35" height="35" class="rounded-circle me-2">` : ''}
        </div>`;
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
