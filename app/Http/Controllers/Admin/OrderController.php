<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Exports\OrdersExport;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::query();

        // Status filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->byStatus($request->status);
        }

        // Search filter
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Date range filter
        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        // Get paginated results
        $orders = $query->orderBy('created_at', 'desc')->paginate(10);

        // Preserve query parameters in pagination links
        $orders->appends($request->query());

        return view('admin.orders', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('items')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
    }

    public function edit($id)
    {
        $order = Order::findOrFail($id);
        $statuses = Order::getStatuses();
        return view('admin.orders.edit', compact('order', 'statuses'));
    }

    public function update(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $validator = Validator::make($request->all(), [
            'customer_name' => 'required|string|max:255',
            'customer_email' => 'required|email|max:255',
            'customer_phone' => 'nullable|string|max:20',
            'total' => 'required|numeric|min:0',
            'status' => 'required|in:' . implode(',', array_keys(Order::getStatuses())),
            'items_count' => 'required|integer|min:1',
            'shipping_address' => 'nullable|string',
            'billing_address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput()
                ->with('error', 'Please correct the errors below.');
        }

        // Update order (admin override: allow changing to any status)
        $oldStatus = $order->status;
        $order->update($request->only([
            'customer_name', 'customer_email', 'customer_phone', 'total', 
            'status', 'items_count', 'shipping_address', 'billing_address', 'notes'
        ]));

        Log::info('Order updated', ['order_id' => $order->id, 'old_status' => $oldStatus, 'new_status' => $order->status]);

        return redirect()->route('admin.orders.show', $order->id)
            ->with('success', 'Order updated successfully!');
    }

    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        
        // Check if order can be deleted (business rule: only pending orders can be deleted)
        if ($order->status !== Order::STATUS_PENDING) {
            return redirect()->route('admin.orders')
                ->with('error', 'Only pending orders can be deleted. Current status: ' . ucfirst($order->status));
        }

        $orderNumber = $order->id;
        
        Log::info('Order deleted', ['order_id' => $order->id, 'customer_name' => $order->customer_name]);
        
        $order->delete();

        return redirect()->route('admin.orders')
            ->with('success', "Order #{$orderNumber} has been deleted successfully!");
    }

    /**
     * Export orders to Excel or PDF
     */
    public function export(Request $request)
    {
        $format = $request->input('format', 'excel'); // Default to excel
        
        // Build the query with the same filters as the orders page
        $query = Order::query();

        // Apply status filter
        if ($request->filled('status') && $request->status !== 'all') {
            $query->byStatus($request->status);
        }

        // Apply search filter
        if ($request->filled('search')) {
            $query->search($request->search);
        }

        // Apply date range filters
        if ($request->filled('date_from')) {
            $query->where('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->where('created_at', '<=', $request->date_to . ' 23:59:59');
        }

        // Order by creation date
        $query->orderBy('created_at', 'desc');

        if ($format === 'pdf') {
            return $this->exportToPDF($query);
        }

        return $this->exportToExcel($query);
    }

    /**
     * Export orders to Excel
     */
    private function exportToExcel($query)
    {
        $filename = 'orders_' . date('Y-m-d_His') . '.xlsx';
        Log::info('Orders exported to Excel', ['filename' => $filename]);
        return Excel::download(new OrdersExport($query), $filename);
    }

    /**
     * Export orders to PDF
     */
    private function exportToPDF($query)
    {
        $orders = $query->get();
        $filename = 'orders_' . date('Y-m-d_His') . '.pdf';
        
        Log::info('Orders exported to PDF', ['filename' => $filename, 'count' => $orders->count()]);
        
        $pdf = Pdf::loadView('admin.exports.orders-pdf', compact('orders'));
        $pdf->setPaper('a4', 'landscape');
        
        return $pdf->download($filename);
    }
}
