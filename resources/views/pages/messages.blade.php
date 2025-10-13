@extends('layouts.app')

@section('content')
<style>
    * {
        box-sizing: border-box;
    }
    
    .messaging-container {
        background: #ffffff;
        border-radius: 0;
        padding: 0;
        height: 100vh;
        max-height: 100vh;
    }
    
    .messenger-layout {
        display: flex;
        height: calc(100vh - 100px);
        max-width: 1400px;
        margin: 0 auto;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    
    /* Sidebar */
    .sidebar {
        width: 360px;
        background: #ffffff;
        border-right: 1px solid #e4e6eb;
        display: flex;
        flex-direction: column;
    }
    
    .sidebar-header {
        padding: 16px 20px;
        border-bottom: 1px solid #e4e6eb;
    }
    
    .sidebar-header h1 {
        font-size: 24px;
        font-weight: 700;
        color: #050505;
        margin: 0;
    }
    
    .search-bar {
        padding: 8px 16px;
        margin: 8px 12px;
        background: #f0f2f5;
        border-radius: 50px;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .search-bar input {
        background: transparent;
        border: none;
        outline: none;
        flex: 1;
        font-size: 15px;
        color: #050505;
    }
    
    .search-bar input::placeholder {
        color: #65676b;
    }
    
    .search-bar i {
        color: #65676b;
        font-size: 14px;
    }
    
    .conversations-list {
        flex: 1;
        overflow-y: auto;
        padding: 4px 8px;
    }
    
    .conversation-item {
        display: flex;
        align-items: center;
        padding: 8px 12px;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.2s;
        margin-bottom: 2px;
    }
    
    .conversation-item:hover {
        background: #f2f2f2;
    }
    
    .conversation-item.active {
        background: #e7f3ff;
    }
    
    .user-avatar {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0084ff, #00c6ff);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 18px;
        flex-shrink: 0;
        position: relative;
    }
    
    .online-indicator {
        position: absolute;
        bottom: 2px;
        right: 2px;
        width: 12px;
        height: 12px;
        background: #31a24c;
        border: 2px solid white;
        border-radius: 50%;
    }
    
    .conversation-info {
        flex: 1;
        margin-left: 12px;
        min-width: 0;
    }
    
    .conversation-name {
        font-size: 15px;
        font-weight: 600;
        color: #050505;
        margin-bottom: 2px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .conversation-preview {
        font-size: 13px;
        color: #65676b;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    
    .unread-indicator {
        width: 12px;
        height: 12px;
        background: #0084ff;
        border-radius: 50%;
        flex-shrink: 0;
    }
    
    /* Chat Area */
    .chat-area {
        flex: 1;
        display: flex;
        flex-direction: column;
        background: #ffffff;
    }
    
    .chat-header {
        padding: 12px 16px;
        border-bottom: 1px solid #e4e6eb;
        display: flex;
        align-items: center;
        background: #ffffff;
    }
    
    .chat-header-info {
        display: flex;
        align-items: center;
        gap: 12px;
    }
    
    .chat-header-avatar {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: linear-gradient(135deg, #0084ff, #00c6ff);
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
        font-size: 14px;
    }
    
    .chat-header-name {
        font-size: 15px;
        font-weight: 600;
        color: #050505;
    }
    
    .chat-header-actions {
        display: none; /* Hidden - user requested removal */
    }
    
    /* Messages */
    .messages-container {
        flex: 1;
        overflow-y: auto;
        padding: 16px;
        background: #ffffff;
    }
    
    .messages-container::-webkit-scrollbar {
        width: 6px;
    }
    
    .messages-container::-webkit-scrollbar-thumb {
        background: #ccc;
        border-radius: 3px;
    }
    
    .date-separator {
        text-align: center;
        margin: 20px 0 12px;
        font-size: 12px;
        color: #65676b;
        font-weight: 500;
    }
    
    .message-group {
        display: flex;
        margin-bottom: 8px;
        gap: 8px;
        position: relative;
    }
    
    .message-group.sent {
        justify-content: flex-end;
    }
    
    .message-wrapper {
        position: relative;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    
    .message-wrapper.sent {
        flex-direction: row-reverse;
    }
    
    .message-bubble {
        max-width: 60%;
        padding: 8px 12px;
        border-radius: 18px;
        font-size: 15px;
        line-height: 1.4;
        word-wrap: break-word;
        position: relative;
    }
    
    .message-group.sent .message-bubble {
        background: #0084ff;
        color: white;
        cursor: pointer;
    }
    
    .message-group.received .message-bubble {
        background: #f0f0f0;
        color: #050505;
    }
    
    .message-actions {
        display: flex;
        gap: 6px;
        margin-left: 8px;
        opacity: 0;
        transition: opacity 0.2s;
    }
    
    .message-group.sent:hover .message-actions {
        opacity: 1;
    }
    
    .message-action-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        border: none;
        background: rgba(0, 0, 0, 0.05);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: all 0.2s;
        font-size: 14px;
        color: #050505;
    }
    
    .message-action-btn:hover {
        background: rgba(0, 0, 0, 0.1);
        transform: scale(1.1);
    }
    
    .message-action-btn.edit:hover {
        background: #e7f3ff;
        color: #0084ff;
    }
    
    .message-action-btn.delete:hover {
        background: #ffebe9;
        color: #f02849;
    }
    
    /* Message Input */
    .message-input-container {
        padding: 12px 16px;
        border-top: 1px solid #e4e6eb;
        background: #ffffff;
    }
    
    .message-input-wrapper {
        display: flex;
        align-items: center;
        gap: 8px;
        background: #f0f2f5;
        border-radius: 24px;
        padding: 8px 12px;
    }
    
    .message-input-wrapper input {
        flex: 1;
        background: transparent;
        border: none;
        outline: none;
        font-size: 15px;
        color: #050505;
    }
    
    .message-input-wrapper input::placeholder {
        color: #65676b;
    }
    
    .send-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #0084ff;
        color: white;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: none;
        transition: background 0.2s;
    }
    
    .send-btn:hover {
        background: #0073e6;
    }
    
    .cancel-edit-btn {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #e4e6eb;
        color: #65676b;
        display: none;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        border: none;
        transition: background 0.2s;
        margin-left: 4px;
    }
    
    .cancel-edit-btn.show {
        display: flex;
    }
    
    .cancel-edit-btn:hover {
        background: #d0d2d6;
    }
    
    .empty-state {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        height: 100%;
        color: #65676b;
    }
    
    .empty-state i {
        font-size: 64px;
        margin-bottom: 16px;
        opacity: 0.3;
    }
</style>

<div class="messaging-container">
    <div class="messenger-layout">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <h1>Discussions</h1>
            </div>
            
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" placeholder="Rechercher dans Messenger">
            </div>
            
            <div class="conversations-list">
                @foreach($users as $user)
                    @php
                        $lastMessage = $messages->filter(fn($msg) =>
                            ($msg->sender_id == $user->id && $msg->receiver_id == auth()->id()) ||
                            ($msg->receiver_id == $user->id && $msg->sender_id == auth()->id())
                        )->last();
                        $fullName = trim(($user->first_name ?? $user->name ?? '') . ' ' . ($user->last_name ?? $user->prenom ?? ''));
                        $initials = strtoupper(substr($user->first_name ?? $user->name ?? 'U', 0, 1)) . strtoupper(substr($user->last_name ?? $user->prenom ?? 'N', 0, 1));
                    @endphp
                    <div class="conversation-item conversationItem"
                         data-id="{{ $user->id }}"
                         data-name="{{ $user->first_name ?? $user->name ?? '' }}"
                         data-lastname="{{ $user->last_name ?? $user->prenom ?? '' }}">
                        <div class="user-avatar">
                            {{ $initials }}
                            <span class="online-indicator"></span>
                        </div>
                        <div class="conversation-info">
                            <div class="conversation-name">{{ $fullName }}</div>
                            <div class="conversation-preview">
                                {{ Str::limit($lastMessage->contenu ?? 'Commencer une conversation', 40) }}
                            </div>
                        </div>
                        @if($lastMessage && !$lastMessage->lu && $lastMessage->receiver_id == auth()->id())
                            <div class="unread-indicator"></div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        <!-- Chat Area -->
        <div class="chat-area">
            <div class="chat-header">
                <div class="chat-header-info">
                    <div class="chat-header-avatar" id="conversationAvatar">
                        <i class="fas fa-user"></i>
                    </div>
                    <div>
                        <div class="chat-header-name" id="conversationTitle">Sélectionnez une conversation</div>
                    </div>
                </div>
            </div>

            <div class="messages-container" id="conversationMessages">
                <div class="empty-state">
                    <i class="far fa-comments"></i>
                    <p style="font-weight: 600; margin: 0;">Sélectionnez une conversation</p>
                    <p style="font-size: 13px; margin: 4px 0 0;">Choisissez un contact pour commencer à discuter</p>
                </div>
            </div>

            <div class="message-input-container">
                <form method="POST" action="{{ route('messages.store') }}" id="conversationForm">
                    @csrf
                    <input type="hidden" name="receiver_id" id="formReceiver">
                    <input type="hidden" name="message_id" id="formMessageId">
                    <div class="message-input-wrapper">
                        <input type="text" name="contenu" id="formContenu" placeholder="Aa" required>
                        <button type="button" class="cancel-edit-btn" id="cancelEditBtn" style="display: none;">
                            <i class="fas fa-times"></i>
                        </button>
                        <button type="submit" class="send-btn" id="sendBtn">
                            <i class="fas fa-paper-plane"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
const conversationItems = document.querySelectorAll('.conversationItem');
const conversationTitle = document.getElementById('conversationTitle');
const conversationAvatar = document.getElementById('conversationAvatar');
const conversationMessages = document.getElementById('conversationMessages');
const formReceiver = document.getElementById('formReceiver');
const formMessageId = document.getElementById('formMessageId');
const formContenu = document.getElementById('formContenu');
const sendBtn = document.getElementById('sendBtn');
const cancelEditBtn = document.getElementById('cancelEditBtn');
const conversationForm = document.getElementById('conversationForm');

let messages = @json($messages);
const authId = @json(auth()->id());
let currentReceiverId = null;

function getInitials(name, lastname) {
    const n = (name || 'U').charAt(0).toUpperCase();
    const l = (lastname || 'N').charAt(0).toUpperCase();
    return n + l;
}

function formatDate(dateString) {
    const date = new Date(dateString);
    const today = new Date();
    const yesterday = new Date(today);
    yesterday.setDate(yesterday.getDate() - 1);
    
    if (date.toDateString() === today.toDateString()) {
        return "Aujourd'hui";
    } else if (date.toDateString() === yesterday.toDateString()) {
        return 'Hier';
    } else {
        return date.toLocaleDateString('fr-FR', { day: 'numeric', month: 'long', year: 'numeric' });
    }
}

function editMessage(messageId, messageContent) {
    formMessageId.value = messageId;
    formContenu.value = messageContent;
    formContenu.focus();
    cancelEditBtn.style.display = 'flex';
    sendBtn.innerHTML = '<i class="fas fa-check"></i>';
}

function deleteMessage(messageId) {
    if (!confirm('Êtes-vous sûr de vouloir supprimer ce message ?')) {
        return;
    }
    
    fetch(`/messages/${messageId}`, {
        method: 'DELETE',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json',
            'Content-Type': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        // Remove message from local array
        messages = messages.filter(msg => msg.id !== messageId);
        
        // Re-render messages for current conversation
        if (currentReceiverId) {
            const conversation = messages.filter(msg =>
                (msg.sender_id == currentReceiverId && msg.receiver_id == authId) ||
                (msg.receiver_id == currentReceiverId && msg.sender_id == authId)
            );
            
            // Get user info
            const userItem = document.querySelector(`.conversationItem[data-id="${currentReceiverId}"]`);
            const userName = userItem?.dataset.name || '';
            const userLastName = userItem?.dataset.lastname || '';
            
            renderMessages(conversation, userName, userLastName);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Erreur lors de la suppression du message');
    });
}

function renderMessages(conversation, userName, userLastName) {
    conversationMessages.innerHTML = '';

    if(conversation.length === 0) {
        conversationMessages.innerHTML = `
            <div class="empty-state">
                <i class="far fa-comments"></i>
                <p style="font-weight: 600; margin: 0;">Commencez une conversation</p>
                <p style="font-size: 13px; margin: 4px 0 0;">Envoyez votre premier message à ${userName} ${userLastName}</p>
            </div>
        `;
        return;
    }

    let lastDate = null;
    
    conversation.forEach(msg => {
        const msgDate = new Date(msg.date_envoi).toDateString();
        
        // Add date separator if date changed
        if (msgDate !== lastDate) {
            const dateSeparator = document.createElement('div');
            dateSeparator.className = 'date-separator';
            dateSeparator.textContent = formatDate(msg.date_envoi);
            conversationMessages.appendChild(dateSeparator);
            lastDate = msgDate;
        }
        
        const msgGroup = document.createElement('div');
        msgGroup.className = 'message-group ' + (msg.sender_id == authId ? 'sent' : 'received');
        
        const msgBubble = document.createElement('div');
        msgBubble.className = 'message-bubble';
        msgBubble.textContent = msg.contenu;
        
        msgGroup.appendChild(msgBubble);
        
        // Add edit/delete buttons for sent messages
        if (msg.sender_id == authId) {
            const actionsDiv = document.createElement('div');
            actionsDiv.className = 'message-actions';
            
            const editBtn = document.createElement('button');
            editBtn.className = 'message-action-btn edit';
            editBtn.innerHTML = '<i class="fas fa-edit"></i>';
            editBtn.title = 'Modifier';
            editBtn.onclick = () => editMessage(msg.id, msg.contenu);
            
            const deleteBtn = document.createElement('button');
            deleteBtn.className = 'message-action-btn delete';
            deleteBtn.innerHTML = '<i class="fas fa-trash"></i>';
            deleteBtn.title = 'Supprimer';
            deleteBtn.onclick = () => deleteMessage(msg.id);
            
            actionsDiv.appendChild(editBtn);
            actionsDiv.appendChild(deleteBtn);
            msgGroup.appendChild(actionsDiv);
        }
        
        conversationMessages.appendChild(msgGroup);
    });

    conversationMessages.scrollTop = conversationMessages.scrollHeight;
}

conversationItems.forEach(item => {
    item.addEventListener('click', () => {
        // Remove active class from all items
        conversationItems.forEach(el => el.classList.remove('active'));
        // Add active class to clicked item
        item.classList.add('active');

        const userId = item.dataset.id;
        const userName = item.dataset.name;
        const userLastName = item.dataset.lastname;
        const fullName = `${userName} ${userLastName}`.trim();
        const initials = getInitials(userName, userLastName);

        conversationTitle.textContent = fullName;
        conversationAvatar.textContent = initials;
        formReceiver.value = userId;
        currentReceiverId = userId;

        const conversation = messages.filter(msg =>
            (msg.sender_id == userId && msg.receiver_id == authId) ||
            (msg.receiver_id == userId && msg.sender_id == authId)
        );

        renderMessages(conversation, userName, userLastName);
        
        // Reset edit mode
        formMessageId.value = '';
        formContenu.value = '';
        cancelEditBtn.style.display = 'none';
        sendBtn.innerHTML = '<i class="fas fa-paper-plane"></i>';
        
        // Focus on input
        formContenu.focus();
    });
});

// Cancel edit button
cancelEditBtn.addEventListener('click', () => {
    formMessageId.value = '';
    formContenu.value = '';
    cancelEditBtn.style.display = 'none';
    sendBtn.innerHTML = '<i class="fas fa-paper-plane"></i>';
    formContenu.focus();
});

// Auto-scroll on page load
document.addEventListener('DOMContentLoaded', () => {
    if(conversationMessages.children.length > 1) {
        conversationMessages.scrollTop = conversationMessages.scrollHeight;
    }
});
</script>
@endsection