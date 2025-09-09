@extends('layouts.admin')

@section('title', "Détails du log d'activité")

@section('content')
<div class="px-4">
	<div class="flex items-center justify-between mt-4 mb-6">
		<div>
			<h1 class="text-2xl font-bold text-gray-900">Détails du log d'activité</h1>
			<nav class="text-sm text-gray-500 mt-1">
				<a href="{{ route('admin.dashboard') }}" class="hover:text-green-600">Dashboard</a>
				<span class="mx-1">/</span>
				<a href="{{ route('admin.activity-logs.index') }}" class="hover:text-green-600">Journal d'activités</a>
				<span class="mx-1">/</span>
				<span class="text-gray-700">Détails</span>
			</nav>
		</div>
		<a href="{{ route('admin.activity-logs.index') }}" class="inline-flex items-center px-3 py-2 rounded-md bg-gray-800 text-white text-sm font-medium hover:bg-gray-700">
			<i class="fas fa-arrow-left mr-2"></i> Retour
		</a>
	</div>

	<!-- Card: General Info -->
	<div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
		<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
			<div>
				<p class="text-xs text-gray-500">ID</p>
				<p class="text-gray-900 font-medium">{{ $log->id }}</p>
			</div>
			<div>
				<p class="text-xs text-gray-500">Date</p>
				<p class="text-gray-900 font-medium">{{ $log->created_at->format('d/m/Y H:i:s') }}</p>
			</div>
			<div>
				<p class="text-xs text-gray-500">Utilisateur</p>
				<p class="text-gray-900 font-medium">{{ $log->user ? $log->user->name : 'Système' }}</p>
			</div>
			<div>
				<p class="text-xs text-gray-500">Action</p>
				<p>
					<span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold
						{{ strtolower($log->action) === 'create' ? 'bg-green-100 text-green-700' : '' }}
						{{ strtolower($log->action) === 'update' ? 'bg-yellow-100 text-yellow-700' : '' }}
						{{ strtolower($log->action) === 'delete' ? 'bg-red-100 text-red-700' : '' }}
						{{ !in_array(strtolower($log->action), ['create','update','delete']) ? 'bg-gray-100 text-gray-700' : '' }}">
						{{ ucfirst($log->action) }}
					</span>
				</p>
			</div>
			<div class="md:col-span-2">
				<p class="text-xs text-gray-500">Description</p>
				<p class="text-gray-900">{{ $log->description }}</p>
			</div>
			<div>
				<p class="text-xs text-gray-500">Type d'élément</p>
				<p class="text-gray-900 font-medium">{{ $log->model_type ? class_basename($log->model_type) : 'N/A' }}</p>
			</div>
			<div>
				<p class="text-xs text-gray-500">ID de l'élément</p>
				<p class="text-gray-900 font-medium">{{ $log->model_id ?? 'N/A' }}</p>
			</div>
			<div>
				<p class="text-xs text-gray-500">Adresse IP</p>
				<p class="text-gray-900 font-medium">{{ $log->ip_address ?? 'N/A' }}</p>
			</div>
			<div>
				<p class="text-xs text-gray-500">User Agent</p>
				<p class="text-gray-900 font-medium break-all">{{ $log->user_agent ?? 'N/A' }}</p>
			</div>
		</div>
	</div>

	@if($log->old_values || $log->new_values)
	<!-- Card: Changes -->
	<div class="bg-white border border-gray-200 rounded-lg p-6 mb-6">
		<h2 class="text-lg font-semibold text-gray-900 mb-4">Modifications</h2>
		@if($log->action == 'update' && $log->old_values && $log->new_values)
			<div class="grid grid-cols-1 md:grid-cols-2 gap-4">
				<div>
					<p class="text-xs text-gray-500 mb-1">Anciennes valeurs</p>
					<pre class="bg-gray-50 border border-gray-200 rounded p-3 text-xs overflow-auto">{{ json_encode($log->old_values, JSON_PRETTY_PRINT) }}</pre>
				</div>
				<div>
					<p class="text-xs text-gray-500 mb-1">Nouvelles valeurs</p>
					<pre class="bg-gray-50 border border-gray-200 rounded p-3 text-xs overflow-auto">{{ json_encode($log->new_values, JSON_PRETTY_PRINT) }}</pre>
				</div>
			</div>
		@elseif($log->action == 'create' && $log->new_values)
			<p class="text-xs text-gray-500 mb-1">Données créées</p>
			<pre class="bg-gray-50 border border-gray-200 rounded p-3 text-xs overflow-auto">{{ json_encode($log->new_values, JSON_PRETTY_PRINT) }}</pre>
		@elseif($log->action == 'delete' && $log->old_values)
			<p class="text-xs text-gray-500 mb-1">Données supprimées</p>
			<pre class="bg-gray-50 border border-gray-200 rounded p-3 text-xs overflow-auto">{{ json_encode($log->old_values, JSON_PRETTY_PRINT) }}</pre>
		@endif
	</div>
	@endif
</div>
@endsection

