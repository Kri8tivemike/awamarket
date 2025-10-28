<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Orders Export - {{ date('Y-m-d') }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 11px;
            color: #333;
            margin: 20px;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #4F46E5;
            padding-bottom: 15px;
        }
        
        .header h1 {
            margin: 0;
            color: #4F46E5;
            font-size: 24px;
        }
        
        .header p {
            margin: 5px 0 0 0;
            color: #666;
            font-size: 12px;
        }
        
        .info {
            margin-bottom: 20px;
            font-size: 10px;
            color: #666;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        
        thead {
            background-color: #4F46E5;
            color: white;
        }
        
        th {
            padding: 10px 8px;
            text-align: left;
            font-weight: bold;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        
        td {
            padding: 10px 8px;
            border-bottom: 1px solid #e5e7eb;
            font-size: 10px;
        }
        
        tbody tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        tbody tr:hover {
            background-color: #f3f4f6;
        }
        
        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 9px;
            font-weight: bold;
            display: inline-block;
            text-align: center;
        }
        
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .status-processing {
            background-color: #dbeafe;
            color: #1e40af;
        }
        
        .status-collected_by_dispatch {
            background-color: #e9d5ff;
            color: #6b21a8;
        }
        
        .status-delivered_successfully {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .status-failed_delivery {
            background-color: #fed7aa;
            color: #9a3412;
        }
        
        .status-order_cancelled {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 9px;
            color: #999;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }
        
        .total-row {
            font-weight: bold;
            background-color: #f3f4f6 !important;
            border-top: 2px solid #4F46E5;
        }
        
        .amount {
            font-weight: bold;
            color: #059669;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>📦 Orders Report</h1>
        <p>Generated on {{ date('F d, Y h:i A') }}</p>
    </div>
    
    <div class="info">
        <strong>Total Orders:</strong> {{ $orders->count() }} | 
        <strong>Total Revenue:</strong> ${{ number_format($orders->sum('total'), 2) }}
    </div>
    
    <table>
        <thead>
            <tr>
                <th style="width: 6%;">ID</th>
                <th style="width: 15%;">Customer</th>
                <th style="width: 18%;">Email</th>
                <th style="width: 10%;">Phone</th>
                <th style="width: 6%;">Items</th>
                <th style="width: 10%;">Total</th>
                <th style="width: 15%;">Status</th>
                <th style="width: 20%;">Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($orders as $order)
            <tr>
                <td>#{{ $order->id }}</td>
                <td>{{ $order->customer_name }}</td>
                <td>{{ $order->customer_email }}</td>
                <td>{{ $order->customer_phone ?? 'N/A' }}</td>
                <td style="text-align: center;">{{ $order->items_count }}</td>
                <td class="amount">${{ number_format($order->total, 2) }}</td>
                <td>
                    <span class="status-badge status-{{ $order->status }}">
                        {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                    </span>
                </td>
                <td>{{ $order->created_at->format('M d, Y H:i') }}</td>
            </tr>
            @endforeach
            
            @if($orders->count() > 0)
            <tr class="total-row">
                <td colspan="5" style="text-align: right; padding-right: 15px;">TOTAL:</td>
                <td class="amount">${{ number_format($orders->sum('total'), 2) }}</td>
                <td colspan="2"></td>
            </tr>
            @endif
        </tbody>
    </table>
    
    @if($orders->count() == 0)
    <div style="text-align: center; padding: 40px; color: #999;">
        <p style="font-size: 14px;">No orders found for the selected filters.</p>
    </div>
    @endif
    
    <div class="footer">
        <p>AwaMarket Admin Panel - Orders Report</p>
        <p>© {{ date('Y') }} AwaMarket. All rights reserved.</p>
    </div>
</body>
</html>
