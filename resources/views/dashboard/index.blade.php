@extends('layouts.app')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

{{-- ── Stat Cards ──────────────────────────────────────────── --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card" style="background:linear-gradient(135deg,#1a2942,#2d4a7a)">
            <div class="stat-icon"><i class="bi bi-tag"></i></div>
            <div class="stat-value">{{ $totais['categorias'] }}</div>
            <div class="stat-label">Categorias</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card" style="background:linear-gradient(135deg,#0f766e,#0d9488)">
            <div class="stat-icon"><i class="bi bi-people"></i></div>
            <div class="stat-value">{{ $totais['hospedes'] }}</div>
            <div class="stat-label">Hóspedes</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card" style="background:linear-gradient(135deg,#7c3aed,#a855f7)">
            <div class="stat-icon"><i class="bi bi-person-badge"></i></div>
            <div class="stat-value">{{ $totais['funcionarios'] }}</div>
            <div class="stat-label">Funcionários</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card" style="background:linear-gradient(135deg,#b45309,#d97706)">
            <div class="stat-icon"><i class="bi bi-door-closed"></i></div>
            <div class="stat-value">{{ $totais['quartos'] }}</div>
            <div class="stat-label">Quartos</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card" style="background:linear-gradient(135deg,#0369a1,#0ea5e9)">
            <div class="stat-icon"><i class="bi bi-calendar-check"></i></div>
            <div class="stat-value">{{ $totais['reservas'] }}</div>
            <div class="stat-label">Reservas</div>
        </div>
    </div>
    <div class="col-6 col-md-4 col-xl-2">
        <div class="stat-card" style="background:linear-gradient(135deg,#166534,#16a34a)">
            <div class="stat-icon"><i class="bi bi-door-open"></i></div>
            <div class="stat-value">{{ $quartosDisponiveis }}</div>
            <div class="stat-label">Disponíveis</div>
        </div>
    </div>
</div>

{{-- ── Últimas Reservas ─────────────────────────────────────── --}}
<div class="card">
    <div class="card-header d-flex align-items-center justify-content-between py-3 px-4">
        <h6 class="mb-0 fw-semibold"><i class="bi bi-clock-history me-2 text-muted"></i>Últimas Reservas</h6>
        <a href="{{ route('reservas.index') }}" class="btn btn-sm btn-outline-secondary">Ver todas</a>
    </div>
    <div class="card-body p-0">
        @if($reservasRecentes->isEmpty())
        <p class="text-muted text-center py-4 mb-0">Nenhuma reserva cadastrada ainda.</p>
        @else
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th class="px-4">Hóspede</th>
                        <th>Quarto</th>
                        <th>Check-in</th>
                        <th>Check-out</th>
                        <th>Status</th>
                        <th>Valor</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservasRecentes as $r)
                    <tr>
                        <td class="px-4">{{ $r->hospede->nome ?? '—' }}</td>
                        <td>Nº {{ $r->quarto->numero ?? '—' }}</td>
                        <td>{{ $r->data_checkin->format('d/m/Y') }}</td>
                        <td>{{ $r->data_checkout->format('d/m/Y') }}</td>
                        <td>
                            <span class="badge badge-{{ $r->status }} px-2 py-1">
                                {{ \App\Models\Reserva::statusLabel($r->status) }}
                            </span>
                        </td>
                        <td>R$ {{ number_format($r->valor_total, 2, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
</div>

@endsection