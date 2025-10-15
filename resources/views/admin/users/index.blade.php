@extends('layouts.admin')

@section('title', 'Quản lý Người dùng')

@section('content')
<div class="card shadow mb-4">
    <div class="card-header py-3 d-flex justify-content-between align-items-center">
        <h6 class="m-0 font-weight-bold text-primary">Danh sách Người dùng</h6>
        @can('admin-access')
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <i class="fas fa-plus-circle"></i> Thêm Người dùng
        </a>
        @endcan
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-bordered" id="usersTable" width="100%" cellspacing="0">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên</th>
                        <th>Email</th>
                        <th>Địa chỉ</th>
                        <th>Số điện thoại</th>
                        <th>Vai trò</th>
                        <th>Ngày tạo</th>
                        <th>Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $user)
                    <tr>
                        <td>{{ $user->id }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->address ?? 'Chưa cập nhật' }}</td>
                        <td>{{ $user->phone ?? 'Chưa cập nhật' }}</td>
                        <td>
                            @if($user->is_admin)
                                <span class="badge bg-success">Admin</span>
                            @else
                                <span class="badge bg-secondary">Người dùng</span>
                            @endif
                        </td>
                        <td>{{ $user->created_at->format('d/m/Y') }}</td>
                        <td>
                            <div class="d-flex">
                                <a href="{{ route('admin.users.edit', $user) }}" 
                                   class="btn btn-sm btn-primary me-1" title="Sửa">
                                    <i class="fas fa-edit"></i>Sửa
                                </a>
                                
                                @if(!$user->is_admin)
                                    <form action="{{ route('admin.users.make-admin', $user) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-success me-1" title="Cấp quyền Admin">
                                            <i class="fas fa-user-shield"></i>cấp quyền Admin
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('admin.users.revoke-admin', $user) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-warning me-1" title="Thu hồi quyền Admin">
                                            <i class="fas fa-user-times"></i>Thu hồi quyền Admin
                                        </button>
                                    </form>
                                @endif
                                
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Bạn chắc chắn muốn xóa người dùng này?')" 
                                            title="Xóa">
                                        <i class="fas fa-trash"></i>xóa
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        <!-- Phân trang -->
        <div class="d-flex justify-content-center mt-4">
            {{ $users->links() }}
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        $('#usersTable').DataTable({
            "paging": false,
            "searching": true,
            "info": false,
            "ordering": true,
            "language": {
                "url": "//cdn.datatables.net/plug-ins/1.10.25/i18n/Vietnamese.json"
            }
        });
    });
</script>
@endsection