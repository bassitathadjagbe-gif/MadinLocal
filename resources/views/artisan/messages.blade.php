@extends('layouts.artisan')
@section('title', 'Messages')

@push('styles')
<style>
    .messages-container {
        background: white;
        border-radius: 20px;
        overflow: hidden;
        box-shadow: 0 4px 20px rgba(44, 62, 80, 0.05);
        display: grid;
        grid-template-columns: 320px 1fr;
        height: calc(100vh - 180px);
    }

    .conversations-list {
        border-right: 1px solid rgba(44, 62, 80, 0.08);
        overflow-y: auto;
    }

    .conversations-header {
        padding: 1.25rem;
        border-bottom: 1px solid rgba(44, 62, 80, 0.08);
        position: sticky;
        top: 0;
        background: white;
        z-index: 10;
    }

    .conversations-header h4 {
        margin: 0 0 1rem;
        color: var(--indigo);
    }

    .conversation-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 1rem 1.25rem;
        cursor: pointer;
        transition: background 0.2s;
        border-bottom: 1px solid rgba(44, 62, 80, 0.05);
        position: relative;
    }

    .conversation-item:hover { background: var(--ivory); }
    .conversation-item.active { background: var(--ivory-dark); }

    .conversation-item img {
        width: 45px; height: 45px;
        border-radius: 50%;
        object-fit: cover;
    }

    .conversation-item .info { flex: 1; min-width: 0; }
    .conversation-item .name {
        font-weight: 600;
        color: var(--indigo);
        margin: 0;
        font-size: 0.9rem;
    }
    .conversation-item .last-msg {
        color: var(--muted);
        font-size: 0.8rem;
        margin: 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }
    .conversation-item .time {
        font-size: 0.7rem;
        color: var(--muted);
    }
    .conversation-item .unread {
        position: absolute;
        top: 1rem; right: 1rem;
        width: 18px; height: 18px;
        background: var(--terracotta);
        color: white;
        border-radius: 50%;
        font-size: 0.7rem;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
    }

    .chat-area {
        display: flex;
        flex-direction: column;
    }

    .chat-header {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid rgba(44, 62, 80, 0.08);
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }

    .chat-header img {
        width: 40px; height: 40px;
        border-radius: 50%;
        object-fit: cover;
    }

    .chat-header .name {
        font-weight: 600;
        color: var(--indigo);
        margin: 0;
    }

    .chat-header .status {
        font-size: 0.8rem;
        color: #065F46;
        margin: 0;
    }

    .chat-messages {
        flex: 1;
        overflow-y: auto;
        padding: 1.5rem;
        background: var(--ivory);
    }

    .message {
        max-width: 70%;
        margin-bottom: 1rem;
        display: flex;
        flex-direction: column;
    }

    .message.received { align-self: flex-start; }
    .message.sent { align-self: flex-end; margin-left: auto; }

    .message .bubble {
        padding: 0.75rem 1rem;
        border-radius: 18px;
        font-size: 0.9rem;
        line-height: 1.5;
    }

    .message.received .bubble {
        background: white;
        color: var(--dark);
        border-bottom-left-radius: 4px;
    }

    .message.sent .bubble {
        background: var(--terracotta);
        color: white;
        border-bottom-right-radius: 4px;
    }

    .message .time {
        font-size: 0.7rem;
        color: var(--muted);
        margin-top: 0.25rem;
        padding: 0 0.5rem;
    }

    .message.sent .time { text-align: right; }

    .chat-input {
        padding: 1rem 1.5rem;
        border-top: 1px solid rgba(44, 62, 80, 0.08);
        display: flex;
        gap: 0.75rem;
        align-items: center;
        background: white;
    }

    .chat-input input {
        flex: 1;
        border: 1.5px solid rgba(44, 62, 80, 0.12);
        border-radius: 50px;
        padding: 0.75rem 1.25rem;
        font-size: 0.9rem;
    }

    .chat-input input:focus {
        outline: none;
        border-color: var(--terracotta);
    }

    .chat-input button {
        width: 45px; height: 45px;
        border-radius: 50%;
        background: var(--terracotta);
        color: white;
        border: none;
        cursor: pointer;
        transition: all 0.3s;
    }

    .chat-input button:hover {
        background: var(--indigo);
        transform: scale(1.05);
    }

    @media (max-width: 768px) {
        .messages-container { grid-template-columns: 1fr; }
        .conversations-list { display: none; }
    }
</style>
@endpush

@section('content')

<div class="topbar">
    <div>
        <h1 class="page-title serif">Messages</h1>
        <p class="page-subtitle">Communiquez avec l'administration et vos clients</p>
    </div>
</div>

<div class="messages-container">
    <!-- Liste conversations -->
    <div class="conversations-list">
        <div class="conversations-header">
            <h4 class="serif">Conversations</h4>
            <div class="search-box" style="width:100%;">
                <i class="bi bi-search"></i>
                <input type="text" placeholder="Rechercher..." style="width:100%;">
            </div>
        </div>

        <div class="conversation-item active">
            <img src="https://i.pravatar.cc/50?img=60" alt="Admin">
            <div class="info">
                <p class="name">Administration</p>
                <p class="last-msg">Votre produit a été validé !</p>
            </div>
            <div>
                <div class="time">10:32</div>
                <div class="unread">2</div>
            </div>
        </div>

        <div class="conversation-item">
            <img src="https://i.pravatar.cc/50?img=32" alt="Client">
            <div class="info">
                <p class="name">Amina Diallo</p>
                <p class="last-msg">Bonjour, je suis intéressée par...</p>
            </div>
            <div class="time">09:15</div>
        </div>

        <div class="conversation-item">
            <img src="https://i.pravatar.cc/50?img=15" alt="Client">
            <div class="info">
                <p class="name">Jean Kouassi</p>
                <p class="last-msg">Merci pour la rapidité !</p>
            </div>
            <div class="time">Hier</div>
        </div>

        <div class="conversation-item">
            <img src="https://i.pravatar.cc/50?img=52" alt="Client">
            <div class="info">
                <p class="name">Marc Dubois</p>
                <p class="last-msg">Quel est le délai de livraison ?</p>
            </div>
            <div class="time">Lun</div>
        </div>
    </div>

    <!-- Zone de chat -->
    <div class="chat-area">
        <div class="chat-header">
            <img src="https://i.pravatar.cc/50?img=60" alt="Admin">
            <div style="flex:1;">
                <p class="name">Administration MadinLocal</p>
                <p class="status">● En ligne</p>
            </div>
            <button class="icon-btn"><i class="bi bi-three-dots-vertical"></i></button>
        </div>

        <div class="chat-messages" style="display:flex; flex-direction:column;">
            <div class="text-center my-3">
                <small class="text-muted" style="background:white; padding:0.25rem 0.75rem; border-radius:20px;">Aujourd'hui</small>
            </div>

            <div class="message received">
                <div class="bubble">Bonjour Kouadio ! 👋</div>
                <div class="time">10:30</div>
            </div>

            <div class="message received">
                <div class="bubble">Nous avons le plaisir de vous informer que votre produit "Pagne tissé traditionnel" a été validé et est maintenant en ligne sur la plateforme.</div>
                <div class="time">10:31</div>
            </div>

            <div class="message sent">
                <div class="bubble">Bonjour ! Merci beaucoup pour cette excellente nouvelle ! 🎉</div>
                <div class="time">10:32</div>
            </div>

            <div class="message sent">
                <div class="bubble">Je vais continuer à ajouter d'autres produits cette semaine.</div>
                <div class="time">10:32</div>
            </div>

            <div class="message received">
                <div class="bubble">Parfait ! N'hésitez pas si vous avez des questions. Bonne journée !</div>
                <div class="time">10:33</div>
            </div>
        </div>

        <div class="chat-input">
            <button class="icon-btn" style="background:transparent; border:none; color:var(--muted);"><i class="bi bi-paperclip"></i></button>
            <input type="text" placeholder="Écrivez votre message...">
            <button><i class="bi bi-send-fill"></i></button>
        </div>
    </div>
</div>

@endsection
