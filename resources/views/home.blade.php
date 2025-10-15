@extends('layouts.app') {{-- Sử dụng layout chung --}}

@section('content')
<div class="container py-5">
    <!-- Banner/Slider -->
    <div class="mb-5">
        <div class="bg-dark text-white p-5 rounded text-center">
            <h1>Chào mừng đến với cửa hàng</h1>
            <p class="lead">Khám phá các sản phẩm mới nhất với giá tốt nhất</p>
        </div>
    </div>

    <!-- Sản phẩm nổi bật -->
    <section class="mb-5">
        <h2 class="mb-4">Sản Phẩm Nổi Bật</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-4 g-4">
            @foreach($featuredProducts as $product)
            <div class="col">
                <div class="card h-100 d-flex flex-column shadow-sm">
                    <a href="{{ route('products.show', $product['id']) }}">
                        <img src="{{ asset('storage/' . $product->image) }}" 
                             alt="{{ $product->name }}" 
                             class="card-img-top" style="height:200px; object-fit:cover;">
                    </a>
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $product->name }}</h5>
                        <p class="card-text text-danger fw-bold">{{ number_format($product->price) }} VNĐ</p>
                        <a href="{{ route('products.show', $product['id']) }}" class="btn btn-primary mt-auto">Xem chi tiết</a>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>

    <!-- Phản hồi khách hàng -->
    <section class="mb-5">
        <h2 class="mb-4">Khách Hàng Nói Gì</h2>
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            @foreach($recentFeedbacks as $feedback)
            <div class="col">
                <div class="card h-100">
                    <div class="card-body">
                        <p class="card-text">"{{ $feedback->message }}"</p>
                    </div>
                    <div class="card-footer bg-light">
                        <small class="text-muted">
                            {{ $feedback->user->name }} - 
                            {{ $feedback->created_at->diffForHumans() }}
                        </small>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
</div>
@endsection
