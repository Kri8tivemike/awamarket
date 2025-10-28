<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\WhatsAppSetting;
use App\Models\Order;
use App\Models\OrderItem;

class CartController extends Controller
{
    /**
     * Get cart items from session
     */
    public function getCart()
    {
        $cart = Session::get('cart', []);
        $total = $this->calculateTotal($cart);
        
        return response()->json([
            'cart' => array_values($cart),
            'count' => $this->getCartCount($cart),
            'subtotal' => $total['subtotal'],
            'tax' => $total['tax'],
            'total' => $total['total']
        ]);
    }
    
    /**
     * Add item to cart
     */
    public function addToCart(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer',
            'product_name' => 'required|string',
            'options' => 'required|array',
            'options.*.name' => 'required|string',
            'options.*.price' => 'required|numeric',
            'options.*.quantity' => 'required|integer|min:1'
        ]);
        
        $cart = Session::get('cart', []);
        
        // Add each option as a separate cart item
        foreach ($request->options as $option) {
            $cartItemKey = $request->product_id . '_' . md5($option['name']);
            
            if (isset($cart[$cartItemKey])) {
                // Item exists, update quantity
                $cart[$cartItemKey]['quantity'] += $option['quantity'];
            } else {
                // New item
                $cart[$cartItemKey] = [
                    'id' => $cartItemKey,
                    'product_id' => $request->product_id,
                    'product_name' => $request->product_name,
                    'option_name' => $option['name'],
                    'price' => $option['price'],
                    'quantity' => $option['quantity'],
                    'image' => $option['image'] ?? null
                ];
            }
        }
        
        Session::put('cart', $cart);
        Session::save(); // Explicitly save session
        
        return response()->json([
            'success' => true,
            'message' => 'Items added to cart successfully',
            'cart_count' => $this->getCartCount($cart)
        ]);
    }
    
    /**
     * Update cart item quantity
     */
    public function updateQuantity(Request $request)
    {
        $request->validate([
            'item_id' => 'required|string',
            'quantity' => 'required|integer|min:1'
        ]);
        
        $cart = Session::get('cart', []);
        
        if (isset($cart[$request->item_id])) {
            $cart[$request->item_id]['quantity'] = $request->quantity;
            Session::put('cart', $cart);
            Session::save(); // Explicitly save session
            
            $total = $this->calculateTotal($cart);
            
            return response()->json([
                'success' => true,
                'cart_count' => $this->getCartCount($cart),
                'subtotal' => $total['subtotal'],
                'tax' => $total['tax'],
                'total' => $total['total']
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Item not found in cart'
        ], 404);
    }
    
    /**
     * Remove item from cart
     */
    public function removeItem(Request $request)
    {
        $request->validate([
            'item_id' => 'required|string'
        ]);
        
        $cart = Session::get('cart', []);
        
        if (isset($cart[$request->item_id])) {
            unset($cart[$request->item_id]);
            Session::put('cart', $cart);
            Session::save(); // Explicitly save session
            
            $total = $this->calculateTotal($cart);
            
            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart',
                'cart_count' => $this->getCartCount($cart),
                'subtotal' => $total['subtotal'],
                'tax' => $total['tax'],
                'total' => $total['total']
            ]);
        }
        
        return response()->json([
            'success' => false,
            'message' => 'Item not found in cart'
        ], 404);
    }
    
    /**
     * Clear entire cart
     */
    public function clearCart()
    {
        Session::forget('cart');
        Session::save(); // Explicitly save session
        
        return response()->json([
            'success' => true,
            'message' => 'Cart cleared successfully'
        ]);
    }
    
    /**
     * Show cart page
     */
    public function showCart()
    {
        $cart = Session::get('cart', []);
        $total = $this->calculateTotal($cart);
        
        return view('pages.cart', [
            'cart' => array_values($cart),
            'count' => $this->getCartCount($cart),
            'subtotal' => $total['subtotal'],
            'tax' => $total['tax'],
            'total' => $total['total']
        ]);
    }
    
    /**
     * Show checkout page
     */
    public function showCheckout()
    {
        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty');
        }
        
        $total = $this->calculateTotal($cart);
        $whatsappSettings = WhatsAppSetting::getSettings();
        
        return view('pages.checkout', [
            'cart' => array_values($cart),
            'count' => $this->getCartCount($cart),
            'subtotal' => $total['subtotal'],
            'shipping' => 0, // Free shipping
            'tax' => $total['tax'],
            'total' => $total['total'],
            'whatsapp_phone' => $whatsappSettings->phone_number
        ]);
    }
    
    /**
     * Calculate cart totals
     */
    private function calculateTotal($cart)
    {
        $subtotal = 0;
        
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }
        
        $tax = $subtotal * 0.08; // 8% tax
        $total = $subtotal + $tax;
        
        return [
            'subtotal' => number_format($subtotal, 2, '.', ''),
            'tax' => number_format($tax, 2, '.', ''),
            'total' => number_format($total, 2, '.', '')
        ];
    }
    
    /**
     * Get total number of items in cart
     */
    private function getCartCount($cart)
    {
        $count = 0;
        foreach ($cart as $item) {
            $count += $item['quantity'];
        }
        return $count;
    }

    /**
     * Create order in database
     */
    public function createOrder(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip' => 'nullable|string|max:6',
        ]);

        $cart = Session::get('cart', []);
        
        if (empty($cart)) {
            return response()->json([
                'success' => false,
                'message' => 'Your cart is empty'
            ], 400);
        }

        $total = $this->calculateTotal($cart);

        // Build address string
        $addressParts = [$request->address, $request->city, $request->state];
        if ($request->zip) {
            $addressParts[] = $request->zip;
        }
        $fullAddress = implode(', ', $addressParts);

        // Create the order
        $order = Order::create([
            'customer_name' => $request->first_name . ' ' . $request->last_name,
            'customer_email' => $request->email,
            'customer_phone' => $request->phone,
            'total' => $total['total'],
            'items_count' => $this->getCartCount($cart),
            'shipping_address' => $fullAddress,
            'billing_address' => $fullAddress,
            'status' => Order::STATUS_PENDING,
        ]);

        // Create order items
        foreach ($cart as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_name' => $item['product_name'],
                'option_name' => $item['option_name'],
                'quantity' => $item['quantity'],
                'price' => $item['price'],
                'subtotal' => $item['price'] * $item['quantity'],
                'image' => $item['image'] ?? null,
            ]);
        }

        // Get WhatsApp settings for redirect
        $whatsappSettings = WhatsAppSetting::getSettings();

        return response()->json([
            'success' => true,
            'message' => 'Order created successfully',
            'order_id' => $order->id,
            'whatsapp_phone' => $whatsappSettings->phone_number,
        ]);
    }
}
