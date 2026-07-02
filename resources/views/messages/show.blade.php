@extends('layouts.app')

@section('title', 'Conversation avec ' . $partner->name)

@section('content')
<section class="py-5" style="padding-top: 100px !important; background: #fafafa; min-height: 80vh;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                
                {{-- HEADER --}}
                <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                    <a href="{{ route('messages.index') }}" class="btn btn-outline-secondary btn-sm">
                        <i class="bi bi-arrow-left me-1"></i>Conversations
                    </a>
                    
                    <div class="d-flex gap-2">
                        @if(auth()->user()->role === 'client')
                            <a href="{{ route('client.dashboard') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-speedometer2 me-1"></i>Dashboard
                            </a>
                        @elseif(auth()->user()->role === 'artisan')
                            <a href="{{ route('artisan.dashboard') }}" class="btn btn-outline-secondary btn-sm">
                                <i class="bi bi-speedometer2 me-1"></i>Dashboard
                            </a>
                        @endif
                    </div>
                </div>

                {{-- PARTENAIRE --}}
                <div class="card shadow-sm border-0 rounded-4 mb-3">
                    <div class="card-body d-flex align-items-center gap-3">
                        @if($partner->avatar)
                            <img src="{{ asset('storage/' . $partner->avatar) }}" 
                                 alt="Avatar" 
                                 class="rounded-circle"
                                 style="width: 50px; height: 50px; object-fit: cover;">
                        @else
                            <div class="rounded-circle d-flex align-items-center justify-content-center"
                                 style="width: 50px; height: 50px; background: linear-gradient(135deg, #D2691E, #F4A460); color: white; font-size: 1.3rem; font-weight: 700;">
                                {{ strtoupper(substr($partner->name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <h5 class="fw-bold mb-0" style="color: var(--primary-color);">{{ $partner->name }}</h5>
                            <small class="text-muted">{{ $partner->role === 'artisan' ? 'Artisan' : 'Client' }}</small>
                        </div>
                    </div>
                </div>

                {{-- MESSAGES --}}
                <div class="card shadow-sm border-0 rounded-4 mb-3">
                    <div class="card-body" id="messagesContainer" style="max-height: 600px; overflow-y: auto; background: #f0f2f5; padding: 20px;">
                        
                        @forelse($messages as $index => $message)
                            @php
                                $estMoi = (int) $message->expediteur_id === (int) auth()->id();
                            @endphp
                            
                            <div class="d-flex mb-3 {{ $estMoi ? 'justify-content-end' : 'justify-content-start' }}">
                                <div class="p-3 rounded-3 shadow-sm" 
                                     style="max-width: 75%; 
                                            background: {{ $estMoi ? '#0d6efd' : '#ffffff' }}; 
                                            color: {{ $estMoi ? '#ffffff' : '#000000' }};
                                            border: 1px solid #dee2e6;">
                                    
                                    {{-- Sujet sur le 1er message --}}
                                    @if($index === 0 && $message->sujet)
                                        <div class="mb-2 pb-2 border-bottom" style="border-color: rgba(0,0,0,0.1) !important;">
                                            <strong>📌 {{ $message->sujet }}</strong>
                                        </div>
                                    @endif
                                    
                                    {{-- Référence au produit --}}
                                    @if($message->produit)
                                        <div class="mb-2 p-2 rounded" style="background: {{ $estMoi ? 'rgba(255,255,255,0.2)' : '#f8f9fa' }};">
                                            <small>
                                                <i class="bi bi-box-seam"></i> 
                                                À propos de : <strong>{{ $message->produit->nom }}</strong>
                                            </small>
                                        </div>
                                    @endif
                                    
                                    {{-- Contenu --}}
                                    <p class="mb-1" style="white-space: pre-wrap; font-size: 15px;">{{ $message->contenu }}</p>
                                    
                                    {{-- Date et statut --}}
                                    <small style="opacity: 0.8;">
                                        {{ $message->created_at->format('d/m/Y H:i') }}
                                        @if($estMoi && $message->lu_a)
                                            <i class="bi bi-check2-all text-success"></i>
                                        @endif
                                    </small>
                                </div>
                            </div>
                        @empty
                            <div class="text-center py-4">
                                <i class="bi bi-chat-dots" style="font-size: 3rem; color: #ddd;"></i>
                                <p class="text-muted mt-2">Aucun message. Commencez la conversation !</p>
                            </div>
                        @endforelse
                        
                    </div>
                </div>

                {{-- FORMULAIRE --}}
                <div class="card shadow-sm border-0 rounded-4">
                    <div class="card-body">
                        <form method="POST" action="{{ route('messages.store', $partner->id) }}">
                            @csrf
                            
                            @php
                                $produitId = $messages->first()?->produit_id;
                            @endphp
                            
                            @if($produitId)
                                <input type="hidden" name="produit_id" value="{{ $produitId }}">
                            @endif
                            
                            <div class="mb-3">
                                <textarea name="contenu" 
                                          class="form-control" 
                                          rows="3" 
                                          placeholder="Écrivez votre message..." 
                                          required></textarea>
                            </div>
                            
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="bi bi-send me-2"></i>Envoyer
                                </button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const container = document.getElementById('messagesContainer');
        if (container) {
            container.scrollTop = container.scrollHeight;
        }
    });
</script>
@endpush