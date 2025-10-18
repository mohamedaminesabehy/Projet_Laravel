@extends('layouts.admin')

@section('content')
<div class="container-fluid p-4">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <div>
      <h4 class="mb-0">Participants — {{ $event->title }}</h4>
      <small class="text-muted">Total: {{ $participants->total() }}</small>
    </div>
    <div>
      <a href="{{ route('admin.events.index') }}" class="btn btn-light">← Retour</a>
      <a href="{{ route('admin.events.downloadPdf', $event) }}" class="btn btn-outline-danger" target="_blank">
        <i class="fas fa-file-pdf me-1"></i> Télécharger PDF
      </a>
    </div>
  </div>

  <div class="card">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-light">
          <tr>
            <th>#</th>
            <th>Participant</th>
            <th>Email</th>
            <th>Inscrit le</th>
            <th>Statut</th>
            <th>Check-in</th>
            <th>Départ</th>
            <th>Source</th>
            <th>Notes</th>
          </tr>
        </thead>
        <tbody>
          @forelse ($participants as $u)
            @php
              $displayName = $u->name ?? trim(($u->first_name ?? '').' '.($u->last_name ?? ''));
              if ($displayName === '') $displayName = 'User #'.$u->id;
            @endphp
            <tr>
              <td>{{ $u->id }}</td>
              <td>{{ $displayName }}</td>
              <td>{{ $u->email }}</td>
              <td>{{ optional($u->pivot->joined_at)->format('d/m/Y H:i') }}</td>
              <td>
                @php $status = $u->pivot->status ?? 'joined'; @endphp
                <span class="badge {{ $status === 'joined' ? 'bg-success' : ($status === 'left' ? 'bg-secondary' : 'bg-info') }}">
                  {{ $status }}
                </span>
              </td>
              <td>{{ optional($u->pivot->checked_in_at)->format('d/m/Y H:i') ?: '—' }}</td>
              <td>{{ optional($u->pivot->left_at)->format('d/m/Y H:i') ?: '—' }}</td>
              <td>{{ $u->pivot->source ?? '—' }}</td>
              <td style="max-width:260px">{{ $u->pivot->notes ?? '—' }}</td>
            </tr>
          @empty
            <tr>
              <td colspan="9" class="text-center text-muted py-4">Aucun participant.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <div class="card-footer bg-white">
      {{ $participants->links() }}
    </div>
  </div>
</div>
@endsection
