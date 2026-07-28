<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Accountability Form - {{ $employee->first_name }} {{ $employee->last_name }}</title>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS for layout -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body {
                width: 210mm;
                height: 297mm;
                margin: 0;
                padding: 20mm;
                font-family: 'Inter', sans-serif;
                font-size: 10pt;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }
            @page {
                size: A4;
                margin: 0;
            }
            .print-hidden {
                display: none !important;
            }
        }
        body {
            font-family: 'Inter', sans-serif;
            font-size: 10pt;
            background: #fff;
            color: #1f2937;
            max-width: 210mm;
            margin: 0 auto;
            padding: 20mm;
        }
        .header-field {
            display: flex;
            margin-bottom: 8px;
        }
        .header-field .label {
            width: 100px;
            font-weight: 600;
            color: #4b5563;
        }
        .header-field .value {
            flex: 1;
            border-bottom: 1px solid #d1d5db;
            padding-left: 5px;
            font-weight: 500;
        }
        table.items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            margin-bottom: 40px;
        }
        table.items-table th, table.items-table td {
            border: 1px solid #e5e7eb;
            padding: 4px 6px;
            text-align: left;
            vertical-align: middle;
        }
        table.items-table th {
            font-weight: 600;
            text-align: center;
            background-color: #f9fafb;
            color: #374151;
            text-transform: uppercase;
            font-size: 8pt;
            letter-spacing: 0.05em;
        }
        table.items-table td {
            font-size: 9pt;
        }
        .signature-box {
            margin-top: 30px;
        }
        .signature-row {
            display: flex;
            align-items: flex-end;
            margin-bottom: 2px;
        }
        .signature-title {
            font-weight: 600;
            white-space: nowrap;
            margin-right: 8px;
            width: 90px;
            color: #374151;
        }
        .signature-line {
            border-bottom: 1px solid #9ca3af;
            flex-grow: 1;
        }
        .signature-label {
            font-size: 8pt;
            text-align: center;
            margin-left: 90px;
            color: #6b7280;
            margin-top: 4px;
        }
    </style>
</head>
<body onload="window.print()">
    <!-- Print controls for preview -->
    <div class="print-hidden mb-8 flex justify-end space-x-4 border-b pb-4">
        <button onclick="window.print()" class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 font-semibold shadow">Print Form</button>
        <button onclick="window.close()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400 font-semibold shadow">Close</button>
    </div>

    <!-- Header -->
    <div class="flex items-center mb-10 pb-4 border-b-2 border-gray-100 relative min-h-[100px]">
        <!-- Logo on the left -->
        <div class="w-32 z-10">
            <img src="{{ asset('UBIX_LOGO.png') }}" class="w-full h-auto object-contain" alt="UBIX Logo">
        </div>
        <!-- Perfectly centered text -->
        <div class="absolute inset-0 flex flex-col items-center justify-center pointer-events-none">
            <h1 class="text-xl font-bold uppercase tracking-wide text-gray-800 m-0 whitespace-nowrap">Asset Accountability Form</h1>
            <h2 class="text-lg font-semibold text-gray-500 mt-1 uppercase tracking-widest m-0">IT Department</h2>
        </div>
    </div>

    <!-- Top Fields -->
    <div class="grid grid-cols-2 gap-x-12 gap-y-2 mb-8">
        <!-- Left Column -->
        <div>
            <div class="header-field">
                <div class="label">Name:</div>
                <div class="value">{{ $employee->first_name }} {{ $employee->last_name }}</div>
            </div>
            <div class="header-field">
                <div class="label">Designation:</div>
                <div class="value">{{ $employee->position ?? 'N/A' }}</div>
            </div>
            <div class="header-field">
                <div class="label">Department:</div>
                <div class="value">{{ $employee->department ?? 'N/A' }}</div>
            </div>
        </div>
        <!-- Right Column -->
        <div>
            <div class="header-field">
                <div class="label">Date:</div>
                <div class="value">{{ date('F d, Y') }}</div>
            </div>
            <div class="header-field">
                <div class="label">Control No.:</div>
                <div class="value">AAF-{{ str_pad($employee->id, 4, '0', STR_PAD_LEFT) }}-{{ date('Y') }}</div>
            </div>
            <div class="header-field">
                <div class="label">Location:</div>
                <div class="value">{{ $employee->location ?? 'N/A' }}</div>
            </div>
        </div>
    </div>

    <!-- Assets Table -->
    <table class="items-table">
        <thead>
            <tr>
                <th rowspan="2" class="w-8">Qty</th>
                <th rowspan="2" class="w-12">Unit</th>
                <th colspan="5">Description</th>
                <th rowspan="2" class="w-28">Serial No.</th>
                <th rowspan="2" class="w-32">Asset No.</th>
                <th rowspan="2" class="w-20">Remarks</th>
            </tr>
            <tr>
                <th class="text-sm font-semibold">Brand/Model</th>
                <th class="text-sm font-semibold">Processor</th>
                <th class="text-sm font-semibold">OS</th>
                <th class="text-sm font-semibold">RAM</th>
                <th class="text-sm font-semibold">Storage</th>
            </tr>
        </thead>
        <tbody>
            @forelse($employee->assets as $asset)
                @php
                    $isComputer = in_array($asset->category ? $asset->category->slug : '', ['laptop', 'desktop', 'server']);
                @endphp
                <tr>
                    <td class="text-center">1</td>
                    <td class="text-center"></td>
                    @if($isComputer)
                        <td>{{ $asset->brand }} {{ $asset->model }}</td>
                        <td>{{ $asset->specifications['processor'] ?? '' }}</td>
                        <td>{{ $asset->specifications['os_version'] ?? '' }}</td>
                        <td>{{ $asset->ramModules->count() > 0 ? $asset->ramModules->first()->capacity : '' }}</td>
                        <td>{{ $asset->storageDrives->count() > 0 ? $asset->storageDrives->first()->size : '' }}</td>
                    @elseif($asset->category && strtolower($asset->category->slug) === 'peripheral')
                        <td colspan="5">
                            {{ $asset->specifications['peripheral_type'] ?? 'Peripheral' }} - {{ $asset->brand }} {{ $asset->model }} 
                            @if(!empty($asset->specifications['connection_type']))
                                - {{ $asset->specifications['connection_type'] }}
                            @endif
                        </td>
                    @else
                        <td colspan="5">{{ $asset->category ? $asset->category->name : '' }} - {{ $asset->brand }} {{ $asset->model }}</td>
                    @endif
                    <td class="text-center text-xs whitespace-nowrap">{{ $asset->serial_number ?: '' }}</td>
                    <td class="text-center text-xs whitespace-nowrap font-medium">{{ $asset->asset_tag }}</td>
                    <td class="text-xs">{{ $asset->remarks ?: '' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="10" class="text-center py-4 italic text-gray-500">No assets currently assigned.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Signatures -->
    <div class="grid grid-cols-2 gap-x-16 gap-y-6">
        <!-- Received By -->
        <div class="signature-box">
            <div class="signature-row">
                <div class="signature-title">Received By:</div>
                <div class="signature-line"></div>
            </div>
            <div class="signature-label">(Signature and over Printed Name)</div>
        </div>
        <!-- Noted By -->
        <div class="signature-box">
            <div class="signature-row">
                <div class="signature-title">Noted By:</div>
                <div class="signature-line"></div>
            </div>
            <div class="signature-label">(Signature and over Printed Name)</div>
        </div>
        <!-- Verified By -->
        <div class="signature-box">
            <div class="signature-row">
                <div class="signature-title">Verified By:</div>
                <div class="signature-line"></div>
            </div>
            <div class="signature-label">(Signature and over Printed Name)</div>
        </div>
        <!-- Approved By -->
        <div class="signature-box">
            <div class="signature-row">
                <div class="signature-title">Approved By:</div>
                <div class="signature-line"></div>
            </div>
            <div class="signature-label">(Signature and over Printed Name)</div>
        </div>
    </div>

    <!-- Footer -->
    <div class="mt-16 text-sm text-gray-600">
        <div>Form # UBIX-IT</div>
        <div>August 2026</div>
    </div>
</body>
</html>
