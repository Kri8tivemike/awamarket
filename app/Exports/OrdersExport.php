<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class OrdersExport implements FromCollection, WithHeadings, WithMapping, WithStyles, ShouldAutoSize
{
    protected $query;

    public function __construct($query)
    {
        $this->query = $query;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return $this->query->get();
    }

    /**
     * Define the headings for the Excel file
     */
    public function headings(): array
    {
        return [
            'Order ID',
            'Customer Name',
            'Customer Email',
            'Customer Phone',
            'Items Count',
            'Total Amount',
            'Status',
            'Shipping Address',
            'Billing Address',
            'Order Date',
            'Last Updated'
        ];
    }

    /**
     * Map data for each order row
     */
    public function map($order): array
    {
        return [
            $order->id,
            $order->customer_name,
            $order->customer_email,
            $order->customer_phone ?? 'N/A',
            $order->items_count,
            '$' . number_format($order->total, 2),
            $this->formatStatus($order->status),
            $order->shipping_address ?? 'N/A',
            $order->billing_address ?? 'N/A',
            $order->created_at->format('M d, Y H:i'),
            $order->updated_at->format('M d, Y H:i'),
        ];
    }

    /**
     * Format status with labels
     */
    private function formatStatus($status)
    {
        $statuses = [
            'pending' => 'Pending',
            'processing' => 'Processing',
            'collected_by_dispatch' => 'Collected By Dispatch',
            'delivered_successfully' => 'Delivered Successfully',
            'failed_delivery' => 'Failed Delivery',
            'order_cancelled' => 'Order Cancelled',
        ];

        return $statuses[$status] ?? ucfirst(str_replace('_', ' ', $status));
    }

    /**
     * Style the worksheet
     */
    public function styles(Worksheet $sheet)
    {
        return [
            // Style the header row
            1 => [
                'font' => [
                    'bold' => true,
                    'size' => 12,
                    'color' => ['rgb' => 'FFFFFF']
                ],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => '4F46E5']
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ]
            ],
        ];
    }
}
