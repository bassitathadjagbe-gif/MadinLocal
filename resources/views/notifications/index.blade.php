@extends('layouts.app')

@section('title', 'Mes Notifications')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold" style="color: var(--primary-color);">
            <i class="bi bi-bell me-2"></i>Mes Notifications
            @if($nonLues > 0)
                <span class="badge bg-danger ms-2">{{ $nonLues }}</span>
            @endif
        </h2>
        <div class="d-flex gap-2">
            @if($nonLues > 0)
                <form method="POST" action="{{ route('notifications.mark-all-read') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-primary btn-sm">
                        <i class="bi bi-check-all me-1"></i>Tout marquer comme lu
                    </button>
                </form>
            @endif
            <form method="POST" action="{{ route('notifications.delete-all-read') }}" 
                  onsubmit="return confirm('Supprimer toutes les notifications lues ?')">
                @csrf
                <button type="submit" class="btn btn-outline-danger btn-sm">
                    <i class="bi bi-trash me-1"></i>Supprimer les lues
                </button>
            </form>
        </div>
    </div>

    @if($notifications->count() > 0)
        <div class="list-group">
            @foreach($notifications as $notification)
                <div class="list-group-item list-group-item-action {{ $notification->read_at ? '' : 'bg-light' }}">
                    <div class="d-flex w-100 justify-content-between align-items-start">
                        <div class="flex-grow-1">
                            <div class="d-flex align-items-center gap-2 mb-1">
                                <i class="bi {{ $notification->icon }} fs-5"></i>
                                <h6 class="mb-0 fw-bold">{{ $notification->message }}</h6>
                            </div>
                            <small class="text-muted">
                                <i class="bi bi-clock me-1"></i>
                                {{ $notification->created_at->diffForHumans() }}
                            </small>
                        </div>
                        <div class="d-flex gap-2">
                            @if(!$notification->read_at)
                                <a href="{{ route('notifications.read', $notification) }}" 
                                   class="btn btn-sm btn-outline-success" title="Marquer comme lu">
                                    <i class="bi bi-check"></i>
                                </a>
                            @endif
                            <a href="{{ $notification->link }}" class="btn btn-sm btn-outline-primary" title="Voir">
                                <i class="bi bi-eye"></i>
                            </a>
                            <form method="POST" action="{{ route('notifications.destroy', $notification) }}" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-outline-danger" title="Supprimer"
                                        onclick="return confirm('Supprimer cette notification ?')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-4">
            {{ $notifications->links() }}
        </div>
    @else
        <div class="text-center py-5 bg-white rounded-4 shadow-sm">
            <i class="bi bi-bell-slash" style="font-size: 4rem; color: #ddd;"></i>
            <h4 class="mt-3 text-muted">Aucune notification</h4>
            <p class="text-muted">Vous n'avez pas encore de notifications</p>
        </div>
    @endif
</div>
@endsection