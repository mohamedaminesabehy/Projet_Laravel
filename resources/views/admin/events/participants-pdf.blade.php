<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <title>Participants — {{ $event->title }}</title>
  <style>
    body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
    h2 { margin: 0 0 10px 0; }
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #ccc; padding: 6px; }
    th { background: #f0f0f0; }
  </style>
</head>
<body>
  <h2>Participants — {{ $event->title }}</h2>
  <p>Date: {{ now()->format('d/m/Y H:i') }}</p>
  <table>
    <thead>
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
      @foreach ($participants as $u)
        @php
          $displayName = $u->name ?? trim(($u->first_name ?? '').' '.($u->last_name ?? ''));
          if ($displayName === '') $displayName = 'User #'.$u->id;
        @endphp
        <tr>
          <td>{{ $u->id }}</td>
          <td>{{ $displayName }}</td>
          <td>{{ $u->email }}</td>
          <td>{{ optional($u->pivot->joined_at)->format('d/m/Y H:i') }}</td>
          <td>{{ $u->pivot->status ?? 'joined' }}</td>
          <td>{{ optional($u->pivot->checked_in_at)->format('d/m/Y H:i') }}</td>
          <td>{{ optional($u->pivot->left_at)->format('d/m/Y H:i') }}</td>
          <td>{{ $u->pivot->source ?? '' }}</td>
          <td>{{ $u->pivot->notes ?? '' }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
</body>
</html>
