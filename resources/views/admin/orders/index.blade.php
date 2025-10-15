@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Quản lý Đơn hàng</h1>

    <div class="mb-3">
        <h4>Doanh thu đơn hàng đã hoàn thành: <strong>{{ number_format($totalRevenue) }} ₫</strong></h4>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Khách hàng</th>
                <th>Tổng tiền</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->user->name }}</td>
                <td>{{ number_format($order->total) }} ₫</td>
                <td>
                    <span class="badge bg-{{ $order->status_color }}">
                        {{ $order->status_text }}
                    </span>
                </td>
                <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                <td>
                    <a href="{{ route('admin.orders.show', $order) }}" class="btn btn-sm btn-info">
                        <i class="fas fa-eye"></i> Cập nhật trạng thái
                    </a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $orders->links('pagination::simple-bootstrap-4') }}
</div>
@endsection
