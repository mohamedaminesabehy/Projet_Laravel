@php
    // Works for paginator or plain collection:
    $total = method_exists($participants, 'total') ? $participants->total() : $participants->count();

    // Helper to show initials avatar
    function initials($name) {
        $n = trim($name ?: '');
        if ($n === '') return 'U';
        $parts = preg_split('/\s+/', $n);
        return strtoupper(mb_substr($parts[0],0,1) . (count($parts)>1 ? mb_substr(end($parts),0,1) : ''));
    }
@endphp

<div class="participants-modal">
    <div class="pm-header">
        <div class="pm-title">
            <span class="pm-chip">Total: {{ $total }}</span>
        </div>

        
    </div>

    @if($total === 0)
        <div class="pm-empty">
            <i class="fas fa-users mb-2"></i>
            <p class="mb-0 text-muted">Aucun participant pour cet événement.</p>
        </div>
    @else
        <div class="pm-table-wrap">
            <table class="table pm-table align-middle">
                <thead>
                    <tr>
                        <th style="width: 56px;">#</th>
                        <th>Participant</th>
                        <th>Email</th>
                        <th>Inscription</th>
                        <th>Statut</th>

                    </tr>
                </thead>
                <tbody>
                    @foreach($participants as $p)
                        @php
                            // $p is an App\Models\User (via belongsToMany). Pivot has meta.
                            $display = $p->name ?? trim(($p->first_name ?? '').' '.($p->last_name ?? '')) ?: ('User #'.$p->id);
                            $status  = $p->pivot->status ?? 'joined';
                            $badge   = $status === 'joined' ? 'pm-badge-success'
                                     : ($status === 'left' ? 'pm-badge-muted' : 'pm-badge-info');
                        @endphp
                        <tr>
                            <td class="text-muted">{{ $p->id }}</td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <div class="pm-avatar">{{ initials($display) }}</div>
                                    <div class="pm-user">
                                        <div class="pm-user-name">{{ $display }}</div>
                                        <div class="pm-user-id">ID: {{ $p->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><a href="mailto:{{ $p->email }}" class="text-decoration-none">{{ $p->email }}</a></td>
                            <td>
                                @if($p->pivot->joined_at)
                                    {{ \Carbon\Carbon::parse($p->pivot->joined_at)->format('d/m/Y H:i') }}
                                @else
                                    —
                                @endif
                            </td>
                            <td><span class="pm-badge {{ $badge }}">{{ $status }}</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- If you use paginator, you can show a tiny footer pager (optional) --}}
        @if(method_exists($participants, 'links'))
            <div class="mt-2">
                {{ $participants->links() }}
            </div>
        @endif
    @endif
</div>