@extends('layouts.admin')

@section('title', 'Journal d\'activité')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Journal d'activité</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item active">Journal d'activité</li>
    </ol>
    
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-history me-1"></i>
            Filtres
        </div>
        <div class="card-body">
            <form action="{{ route('admin.logs.index') }}" method="GET" class="row g-3">
                <div class="col-md-3">
                    <label for="action" class="form-label">Action</label>
                    <select name="action" id="action" class="form-select">
                        <option value="">Toutes les actions</option>
                        @foreach($actions as $action)
                            <option value="{{ $action }}" {{ request('action') == $action ? 'selected' : '' }}>
                                @switch($action)
                                    @case('create')
                                        Création
                                        @break
                                    @case('update')
                                        Mise à jour
                                        @break
                                    @case('delete')
                                        Suppression
                                        @break
                                    @case('login')
                                        Connexion
                                        @break
                                    @case('logout')
                                        Déconnexion
                                        @break
                                    @default
                                        {{ ucfirst($action) }}
                                @endswitch
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label for="model_type" class="form-label">Type d'élément</label>
                    <select name="model_type" id="model_type" class="form-select">
                        <option value="">Tous les types</option>
                        @foreach($modelTypes as $type)
                            <option value="{{ $type }}" {{ request('model_type') == $type ? 'selected' : '' }}>
                                {{ class_basename($type) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                
                <div class="col-md-3">
                    <label for="date_from" class="form-label">Date de début</label>
                    <input type="date" class="form-control" id="date_from" name="date_from" value="{{ request('date_from') }}">
                </div>
                
                <div class="col-md-3">
                    <label for="date_to" class="form-label">Date de fin</label>
                    <input type="date" class="form-control" id="date_to" name="date_to" value="{{ request('date_to') }}">
                </div>
                
                <div class="col-12 mt-4">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-filter me-1"></i> Filtrer</button>
                    <a href="{{ route('admin.logs.index') }}" class="btn btn-secondary"><i class="fas fa-undo me-1"></i> Réinitialiser</a>
                    <button type="button" class="btn btn-danger float-end" data-bs-toggle="modal" data-bs-target="#clearLogsModal">
                        <i class="fas fa-trash me-1"></i> Effacer tous les logs
                    </button>
                </div>
            </form>
        </div>
    </div>
    
    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <div>
                <i class="fas fa-history me-1"></i>
                Journal d'activité
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Utilisateur</th>
                            <th>Action</th>
                            <th>Description</th>
                            <th>Type</th>
                            <th>ID</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($logs as $log)
                            <tr>
                                <td>{{ $log->created_at->format('d/m/Y H:i:s') }}</td>
                                <td>{{ $log->user ? $log->user->name : 'Système' }}</td>
                                <td>
                                    @switch($log->action)
                                        @case('create')
                                            <span class="badge bg-success">Création</span>
                                            @break
                                        @case('update')
                                            <span class="badge bg-primary">Mise à jour</span>
                                            @break
                                        @case('delete')
                                            <span class="badge bg-danger">Suppression</span>
                                            @break
                                        @case('login')
                                            <span class="badge bg-info">Connexion</span>
                                            @break
                                        @case('logout')
                                            <span class="badge bg-warning">Déconnexion</span>
                                            @break
                                        @default
                                            <span class="badge bg-secondary">{{ ucfirst($log->action) }}</span>
                                    @endswitch
                                </td>
                                <td>{{ $log->description }}</td>
                                <td>{{ $log->model_type ? class_basename($log->model_type) : 'N/A' }}</td>
                                <td>{{ $log->model_id ?? 'N/A' }}</td>
                                <td>
                                    <a href="{{ route('admin.logs.show', $log) }}" class="btn btn-sm btn-info">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <button type="button" class="btn btn-sm btn-danger" 
                                            onclick="confirmDeleteLog('{{ route('admin.logs.destroy', $log) }}')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">Aucun log d'activité trouvé</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="d-flex justify-content-center mt-4">
                {{ $logs->appends(request()->query())->links() }}
            </div>
        </div>
    </div>
</div>

<!-- Modal de confirmation pour effacer tous les logs -->
<div class="modal fade" id="clearLogsModal" tabindex="-1" aria-labelledby="clearLogsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="clearLogsModalLabel">Confirmation</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Êtes-vous sûr de vouloir effacer tous les logs d'activité ? Cette action est irréversible.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annuler</button>
                <form action="{{ route('admin.logs.clear') }}" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Effacer tous les logs</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    function confirmDeleteLog(url) {
        showConfirmModal(
            'Confirmation de suppression',
            'Êtes-vous sûr de vouloir supprimer ce log d\'activité ?',
            function() {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = url;
                form.style.display = 'none';
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                
                const method = document.createElement('input');
                method.type = 'hidden';
                method.name = '_method';
                method.value = 'DELETE';
                
                form.appendChild(csrfToken);
                form.appendChild(method);
                document.body.appendChild(form);
                form.submit();
            }
        );
    }
</script>
@endsection