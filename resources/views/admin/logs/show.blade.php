@extends('layouts.admin')

@section('title', 'Détails du log d\'activité')

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4">Détails du log d'activité</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Dashboard</a></li>
        <li class="breadcrumb-item"><a href="{{ route('admin.logs.index') }}">Journal d'activité</a></li>
        <li class="breadcrumb-item active">Détails</li>
    </ol>
    
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-info-circle me-1"></i>
                    Informations générales
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">ID:</div>
                        <div class="col-md-9">{{ $log->id }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Date:</div>
                        <div class="col-md-9">{{ $log->created_at->format('d/m/Y H:i:s') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Utilisateur:</div>
                        <div class="col-md-9">{{ $log->user ? $log->user->name : 'Système' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Action:</div>
                        <div class="col-md-9">
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
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Description:</div>
                        <div class="col-md-9">{{ $log->description }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Type d'élément:</div>
                        <div class="col-md-9">{{ $log->model_type ? class_basename($log->model_type) : 'N/A' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">ID de l'élément:</div>
                        <div class="col-md-9">{{ $log->model_id ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Adresse IP:</div>
                        <div class="col-md-9">{{ $log->ip_address ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">User Agent:</div>
                        <div class="col-md-9">{{ $log->user_agent ?? 'N/A' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    @if($log->old_values || $log->new_values)
    <div class="row">
        <div class="col-xl-12">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-exchange-alt me-1"></i>
                    Modifications
                </div>
                <div class="card-body">
                    <div class="row">
                        @if($log->action == 'update' && $log->old_values && $log->new_values)
                            <div class="col-md-12">
                                <h5>Changements</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Champ</th>
                                                <th>Ancienne valeur</th>
                                                <th>Nouvelle valeur</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($log->new_values as $key => $value)
                                                @if(isset($log->old_values[$key]) && $log->old_values[$key] != $value)
                                                    <tr>
                                                        <td>{{ $key }}</td>
                                                        <td>
                                                            @if(is_array($log->old_values[$key]))
                                                                <pre>{{ json_encode($log->old_values[$key], JSON_PRETTY_PRINT) }}</pre>
                                                            @else
                                                                {{ $log->old_values[$key] }}
                                                            @endif
                                                        </td>
                                                        <td>
                                                            @if(is_array($value))
                                                                <pre>{{ json_encode($value, JSON_PRETTY_PRINT) }}</pre>
                                                            @else
                                                                {{ $value }}
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @elseif($log->action == 'create' && $log->new_values)
                            <div class="col-md-12">
                                <h5>Données créées</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Champ</th>
                                                <th>Valeur</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($log->new_values as $key => $value)
                                                <tr>
                                                    <td>{{ $key }}</td>
                                                    <td>
                                                        @if(is_array($value))
                                                            <pre>{{ json_encode($value, JSON_PRETTY_PRINT) }}</pre>
                                                        @else
                                                            {{ $value }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @elseif($log->action == 'delete' && $log->old_values)
                            <div class="col-md-12">
                                <h5>Données supprimées</h5>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Champ</th>
                                                <th>Valeur</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($log->old_values as $key => $value)
                                                <tr>
                                                    <td>{{ $key }}</td>
                                                    <td>
                                                        @if(is_array($value))
                                                            <pre>{{ json_encode($value, JSON_PRETTY_PRINT) }}</pre>
                                                        @else
                                                            {{ $value }}
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif
    
    <div class="mb-4">
        <a href="{{ route('admin.logs.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i> Retour à la liste
        </a>
        <button type="button" class="btn btn-danger" 
                onclick="confirmDeleteLog('{{ route('admin.logs.destroy', $log) }}')">
            <i class="fas fa-trash me-1"></i> Supprimer ce log
        </button>
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