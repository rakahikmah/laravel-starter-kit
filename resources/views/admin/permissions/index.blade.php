@extends('layouts.app')

@push('styles')
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}">
@endpush

@section('content')
    <div class="page-heading">
        <h3>Manajemen Permission</h3>
    </div>
    <div class="page-content">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-header">
                <div class="d-flex justify-content-between align-items-center">
                    <h5 class="card-title">Daftar Permission</h5>
                    {{-- @can('permission.create') --}}
                        <a href="{{ route('permissions.create') }}" class="btn btn-primary"><i class="bi bi-plus-lg"></i> Tambah Permission</a>
                    {{-- @endcan --}}
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <th class="text-center">No.</th>
                                <th>Nama Izin</th>
                                <th>Slug</th>
                                <th>Induk Menu</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($permissions as $permission)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration + $permissions->firstItem() - 1 }}</td>
                                    <td>{{ $permission->name }}</td>
                                    <td><span class="badge bg-secondary">{{ $permission->slug }}</span></td>
                                    <td><span class="badge bg-light-secondary">{{ $permission->menu->name ?? '-' }}</span></td>
                                    <td class="text-center">
                                        @can('permission.edit')
                                            <a href="{{ route('permissions.edit', $permission) }}" class="btn btn-sm btn-warning"><i class="bi bi-pencil-square"></i></a>
                                        @endcan
                                        @can('permission.delete')
                                            <form action="{{ route('permissions.destroy', $permission) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn btn-sm btn-danger btn-delete"><i class="bi bi-trash3-fill"></i></button>
                                            </form>
                                        @endcan
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center">Data belum tersedia.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="mt-3">
                    {{ $permissions->links('components.pagination') }}
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        // Tunggu sampai semua HTML dimuat
        document.addEventListener('DOMContentLoaded', function() {
            // Ambil semua tombol dengan kelas .btn-delete
            const deleteButtons = document.querySelectorAll('.btn-delete');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function(event) {
                    event.preventDefault(); // Mencegah aksi default tombol

                    // Ambil form terdekat dari tombol yang diklik
                    const form = this.closest('form');

                    // Tampilkan SweetAlert
                    Swal.fire({
                        title: 'Anda yakin?',
                        text: "Data yang dihapus tidak dapat dikembalikan!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    }).then((result) => {
                        // Jika pengguna menekan "Ya, hapus!"
                        if (result.isConfirmed) {
                            // Submit form untuk menghapus data
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endpush
