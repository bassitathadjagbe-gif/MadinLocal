@extends('layouts.app')

@section('title', 'Mes Messages')

@section('content')
<section class="py-5" style="padding-top: 100px !important; background: #fafafa; min-height: 80vh;">
    <div class="container">
        {{-- ✅ Header avec boutons --}}
        <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <h2 class="fw-bold mb-0" style="color: var(--primary-color);">
                <i class="bi bi-chat-dots me-2"></i>Mes Conversations
            </h2>
            <div class="d-flex gap-2 flex-wrap">
                {{-- ✅ Bouton Retour au Dashboard --}}
                @if(auth()->user()->role === 'client')
                    <a href="{{ route('client.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-speedometer2 me-2"></i>Dashboard
                    </a>
                @elseif(auth()->user()->role === 'artisan')
                    <a href="{{ route('artisan.dashboard') }}" class="btn btn-outline-secondary">
                        <i class="bi bi-speedometer2 me-2"></i>Dashboard
                    </a>
                @endif
                {{-- Bouton Catalogue --}}
                <a href="{{ route('catalogue') }}" class="btn btn-outline-madin">
                    <i class="bi bi-grid me-2"></i>Catalogue
                </a>
            </div>
        </div>

        @if(count($conversationsData) > 0)
            <div class="row g-3">
                @foreach($conversationsData as $conv)
                    <div class="col-md-6">
                        <a href="{{ route('messages.show', $conv['partner']->id) }}" class="text-decoration-none">
                            <div class="card shadow-sm border-0 rounded-4 h-100 conversation-card">
                                <div class="card-body d-flex align-items-center gap-3">
                                    {{-- Avatar --}}
                                    <div class="flex-shrink-0">
                                        @if($conv['partner']->avatar)
                                            <img src="{{ asset('storage/' . $conv['partner']->avatar) }}" 
                                                 alt="Avatar" 
                                                 class="rounded-circle"
                                                 style="width: 60px; height: 60px; object-fit: cover;">
                                        @else
                                            <div class="rounded-circle d-flex align-items-center justify-content-center"
                                                 style="width: 60px; height: 60px; background: linear-gradient(135deg, var(--secondary-color), var(--accent-color)); color: white; font-size: 1.5rem; font-weight: 700;">
                                                {{ strtoupper(substr($conv['partner']->name, 0, 1)) }}
                                            </div>
                                        @endif
                                    </div>

                                    {{-- Infos --}}
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-start mb-1">
                                            <h6 class="fw-bold mb-0" style="color: var(--primary-color);">
                                                {{ $conv['partner']->name }}
                                            </h6>
                                            @if($conv['unread_count'] > 0)
                                                <span class="badge bg-danger rounded-pill">
                                                    {{ $conv['unread_count'] }}
                                                </span>
                                            @endif
                                        </div>
                                        
                                        <p class="text-muted small mb-1">
                                            {{ Str::limit($conv['last_message']->contenu, 50) }}
                                        </p>
                                        
                                        <small class="text-muted">
                                            {{ $conv['last_message']->created_at->diffForHumans() }}
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5 bg-white rounded-4 shadow-sm">
                <i class="bi bi-chat-dots" style="font-size: 4rem; color: #ddd;"></i>
                <h4 class="mt-3 text-muted">Aucune conversation</h4>
                <p class="text-muted">Commencez par contacter un artisan depuis la page d'un produit</p>
                <a href="{{ route('catalogue') }}" class="btn btn-madin mt-3">
                    <i class="bi bi-grid me-2"></i>Voir le catalogue
                </a>
            </div>
        @endif
    </div>
</section>
@endsection

@push('styles')
<style>
    .conversation-card {
        transition: all 0.3s ease;
        cursor: pointer;
    }
    
    .conversation-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(139, 69, 19, 0.15) !important;
    }
</style>
@endpush