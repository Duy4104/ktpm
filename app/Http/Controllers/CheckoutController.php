<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = session()->get('cart', []);
        $total = collect($cartItems)->sum(fn($item) => $item['price'] * $item['quantity']);
        return view('checkout.index', compact('cartItems', 'total'));
    }

    public function process(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return redirect()->back()->with('error', 'Giỏ hàng trống.');
        }

        $total = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);

        try {
            DB::transaction(function () use ($cart, $total) {
                $order = Order::create([
                    'user_id' => Auth::id(),
                    'total' => $total,
                    'status' => 'pending',
                ]);

                foreach ($cart as $productId => $item) {
                    $product = Product::findOrFail($productId);

                    if ($product->stock < $item['quantity']) {
                        throw new \Exception("Sản phẩm {$product->name} không đủ số lượng.");
                    }

                    $order->orderItems()->create([
                        'product_id' => $productId,
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                    ]);

                    $product->decrement('stock', $item['quantity']);
                }
            });
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }

        session()->forget('cart');
        return redirect()->route('user.orders.index')->with('success', 'Đặt hàng thành công!');
    }
}
?>
