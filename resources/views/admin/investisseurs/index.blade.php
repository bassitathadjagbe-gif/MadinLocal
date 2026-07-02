@extends('layouts.app')

@section('title', 'Validation des Investisseurs')

@section('content')
<div class="container py-4">
    <h2 class="fw-bold mb-4">
        <i class="bi bi-person-check me-2"></i>Investisseurs en attente de validation
    </h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if($investisseurs->count() > 0)
        <div class="card shadow-sm border-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Nom / Entreprise</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Date d'inscription</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($investisseurs as $investisseur)
                            <tr>
                                <td>
                                    <strong>{{ $investisseur->name }}</strong>
                                    @if($investisseur->entreprise)
                                        <br><small class="text-muted">{{ $investisseur->entreprise }}</small>
                                    @endif
                                </td>
                                <td>{{ $investisseur->email }}</td>
                                <td>{{ $investisseur->telephone ?? '-' }}</td>
                                <td>{{ $investisseur->created_at->format('d/m/Y') }}</td>
                                <td class="text-end">
                                    <form method="POST" action="{{ route('admin.investisseurs.valider', $investisseur) }}" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" class="btn btn-sm btn-success rounded-pill px-3" onclick="return confirm('Valider cet investisseur ?')">
                                            <i class="bi bi-check-lg me-1"></i>Valider
                                        </button>
                                    </form>
                                    
                                    <button type="button" class="btn btn-sm btn-outline-danger rounded-pill px-3" 
                                            data-bs-toggle="modal" data-bs-target="#modalRejet{{ $investisseur->id }}">
                                        <i class="bi bi-x-lg me-1"></i>Rejeter
                                    </button>
                                </td>
                            </tr>

                            {{-- Modal Rejet --}}
                            <div class="modal fade" id="modalRejet{{ $investisseur->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form method="POST" action="{{ route('admin.investisseurs.rejeter', $investisseur) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title">Rejeter l'investisseur</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">Motif du rejet *</label>
                                                    <textarea name="motif" class="form-control" rows="3" required></textarea>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                                                <button type="submit" class="btn btn-danger">Confirmer le rejet</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-3">{{ $investisseurs->links() }}</div>
    @else
        <div class="text-center py-5 bg-white rounded shadow-sm">
            <i class="bi bi-check-circle" style="font-size: 4rem; color: #28a745;"></i>
            <h4 class="mt-3">Tous les investisseurs sont validés !</h4>
            <p class="text-muted">Aucun compte en attente de vérification.</p>
        </div>
    @endif
</div>
@endsection