@extends('layouts.app')

@section('content')
<div class="container mx-auto py-6 flex gap-6 h-[80vh]">

    <!-- Liste des conversations -->
    <div class="w-1/3 bg-white shadow rounded p-4 overflow-y-auto">
        <h2 class="text-xl font-bold mb-4">Conversations</h2>
        @foreach($users as $user)
            @php
                $lastMessage = $messages->filter(fn($msg) => 
                    ($msg->sender_id == $user->id && $msg->receiver_id == auth()->id()) ||
                    ($msg->receiver_id == $user->id && $msg->sender_id == auth()->id())
                )->last();
            @endphp
            <div class="flex items-center gap-3 p-2 mb-2 cursor-pointer hover:bg-gray-100 rounded conversationItem"
                 data-id="{{ $user->id }}" data-name="{{ $user->name }}">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=random" 
                     class="w-10 h-10 rounded-full">
                <div>
                    <div class="font-semibold">{{ $user->name }}</div>
                    <div class="text-sm text-gray-500 truncate w-[200px]">
                        {{ $lastMessage->contenu ?? 'Pas encore de messages' }}
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Conversation sélectionnée -->
    <div class="w-2/3 bg-white shadow rounded flex flex-col">
        <h2 class="text-xl font-bold mb-4 p-2 border-b" id="conversationTitle">
            Sélectionnez une conversation
        </h2>

        <!-- Messages -->
        <div class="flex-1 overflow-y-auto p-4 flex flex-col gap-2 bg-gray-100" id="conversationMessages">
            <div class="text-gray-500 text-center">Aucune conversation sélectionnée.</div>
        </div>

        <!-- Formulaire d'envoi -->
        <form method="POST" action="{{ route('messages.store') }}" id="conversationForm" 
              class="flex gap-2 p-3 border-t bg-white">
            @csrf
            <input type="hidden" name="receiver_id" id="formReceiver">
            <input type="hidden" name="message_id" id="formMessageId">
            <input type="text" name="contenu" id="formContenu" placeholder="Aa"
                   class="border p-2 w-full rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500" required>
            <button type="submit" class="bg-blue-700 text-white px-4 py-2 rounded-full hover:bg-blue-800" id="sendBtn">
                Envoyer
            </button>
            <button type="button" class="bg-gray-600 text-white px-4 py-2 rounded-full hover:bg-gray-700 hidden" id="cancelEditBtn">
                Annuler
            </button>
        </form>
    </div>
</div>

<script>
const conversationItems = document.querySelectorAll('.conversationItem');
const conversationTitle = document.getElementById('conversationTitle');
const conversationMessages = document.getElementById('conversationMessages');
const formReceiver = document.getElementById('formReceiver');
const formMessageId = document.getElementById('formMessageId');
const formContenu = document.getElementById('formContenu');
const sendBtn = document.getElementById('sendBtn');
const cancelEditBtn = document.getElementById('cancelEditBtn');

let messages = @json($messages);
const authId = @json(auth()->id());

function renderMessages(conversation) {
    conversationMessages.innerHTML = '';

    conversation.forEach(msg => {
        let msgDiv = document.createElement('div');
        msgDiv.classList.add('p-3', 'rounded-xl', 'max-w-[70%]', 'relative', 'break-words');

        if(msg.sender_id == authId){
            msgDiv.classList.add('bg-blue-700', 'text-black', 'self-end'); // Bleu foncé, texte noir
            msgDiv.innerHTML = `
                <span>${msg.contenu}</span>
                <div class="absolute -top-4 right-0 flex gap-2 text-xs">
                    <button type="button" class="editBtn text-yellow-300" data-id="${msg.id}" data-content="${msg.contenu}">✏️</button>
                    <form method="POST" action="/messages/${msg.id}" onsubmit="return confirm('Supprimer ?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-300">🗑️</button>
                    </form>
                </div>`;
        } else {
            msgDiv.classList.add('bg-gray-800', 'text-black', 'self-start'); // Gris très foncé, texte noir
            msgDiv.innerHTML = `<span>${msg.contenu}</span>`;
        }

        conversationMessages.appendChild(msgDiv);
    });

    conversationMessages.scrollTop = conversationMessages.scrollHeight;

    document.querySelectorAll('.editBtn').forEach(btn => {
        btn.addEventListener('click', () => {
            formMessageId.value = btn.dataset.id;
            formContenu.value = btn.dataset.content;
            sendBtn.textContent = 'Mettre à jour';
            cancelEditBtn.classList.remove('hidden');
        });
    });
}

conversationItems.forEach(item => {
    item.addEventListener('click', () => {
        const userId = item.dataset.id;
        const userName = item.dataset.name;

        conversationTitle.textContent = "Conversation avec " + userName;
        formReceiver.value = userId;
        formMessageId.value = '';
        formContenu.value = '';
        sendBtn.textContent = 'Envoyer';
        cancelEditBtn.classList.add('hidden');

        let conversation = messages.filter(msg =>
            (msg.sender_id == userId && msg.receiver_id == authId) ||
            (msg.receiver_id == userId && msg.sender_id == authId)
        );

        renderMessages(conversation);
    });
});

cancelEditBtn.addEventListener('click', () => {
    formMessageId.value = '';
    formContenu.value = '';
    sendBtn.textContent = 'Envoyer';
    cancelEditBtn.classList.add('hidden');
});
</script>
@endsection