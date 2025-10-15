@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Thanh toán đơn hàng</h1>

    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @php $cartItems = session()->get('cart', []); @endphp

    @if(empty($cartItems))
        <div class="alert alert-info">Giỏ hàng của bạn đang trống!</div>
        <a href="{{ route('products.index') }}" class="btn btn-primary">Tiếp tục mua sắm</a>
    @else
        <table class="table">
            <thead>
                <tr>
                    <th>Sản phẩm</th>
                    <th>Giá</th>
                    <th>Số lượng</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>
                @foreach($cartItems as $item)
                <tr>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ number_format($item['price']) }}₫</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>{{ number_format($item['price'] * $item['quantity']) }}₫</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <p><strong>Tổng cộng: </strong> {{ number_format(collect($cartItems)->sum(fn($i) => $i['price'] * $i['quantity'])) }}₫</p>

        <form action="{{ route('checkout.process') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-success">Thanh toán</button>
        </form>
    @endif
</div>
@endsection
