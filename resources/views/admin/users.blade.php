@extends('layout')

@section('title', 'Zarządzanie użytkownikami')

@section('main_content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2><i class="bi bi-people-fill me-2"></i> Użytkownicy</h2>
        <span class="badge bg-secondary">Łącznie: {{ $users->total() }}</span>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary">
                        <tr>
                            <th class="ps-4">Użytkownik</th>
                            <th>Rola</th>
                            <th>Data rejestracji</th>
                            <th class="text-end pe-4">Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td class="ps-4">
                                <div class="d-flex align-items-center">
                                    <div class="me-3" style="width: 45px; height: 45px;">
                                        @if($user->avatar)
                                            <img src="{{ asset('storage/' . $user->avatar) }}" 
                                                 class="rounded-circle w-100 h-100 object-fit-cover border"
                                                 alt="Avatar">
                                        @else
                                            <div class="rounded-circle bg-dark text-white d-flex align-items-center justify-content-center" 
                                     style="width: 45px; height: 45px; font-weight: bold;">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                                        @endif
                                    </div>
                                    
                                    <div>
                                        <div class="fw-bold text-dark">{{ $user->name }}</div>
                                        <div class="small text-muted">{{ $user->email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($user->is_admin)
                                    <span class="badge bg-danger">Administrator</span>
                                @else
                                    <span class="badge bg-success">Klient</span>
                                @endif
                            </td>
                            <td>
                                <i class="bi bi-calendar3 me-1 text-muted"></i>
                                {{ $user->created_at->format('d.m.Y') }}
                            </td>
                            <td class="text-end pe-4">
                                @if($user->id !== auth()->id())
                                <div class="d-flex justify-content-end gap-2">
            
            <form action="{{ route('admin.users.toggleRole', $user) }}" method="POST">
                @csrf
                @method('PATCH')
                
                @if($user->is_admin)
                    <button type="submit" class="btn btn-sm btn-warning" title="Zabierz uprawnienia administratora">
                        <i class="bi bi-shield-slash"></i> Zdegraduj
                    </button>
                @else
                    <button type="submit" class="btn btn-sm btn-primary" title="Mianuj administratorem">
                        <i class="bi bi-shield-check"></i> Awansuj
                    </button>
                @endif
            </form>
                                    <form action="{{ route('admin.users.delete', $user) }}" method="POST" onsubmit="return confirm('Czy na pewno chcesz usunąć tego użytkownika? Ta operacja jest nieodwracalna.');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Usuń konto">
                                            <i class="bi bi-trash"></i> Usuń
                                        </button>
                                    </form>
                                </div>
                                @else
                                    <span class="text-muted small">To Ty</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mt-4 d-flex justify-content-center">
        {{ $users->links() }}
    </div>
</div>
@endsection