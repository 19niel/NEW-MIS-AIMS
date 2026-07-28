<x-app-layout>
    <div class="py-6">
        <div class="w-full px-4 sm:px-6 lg:px-8 space-y-6">
            
            <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-200 bg-white p-4 rounded-lg shadow-sm">
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    {{ __('System Reports') }}
                </h2>
            </div>
            
            <!-- Quick Stats -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Total Assets</h3>
                    <p class="text-3xl font-bold text-primary-800 mt-2">{{ number_format($totalAssets) }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Total Employees</h3>
                    <p class="text-3xl font-bold text-blue-600 mt-2">{{ number_format($totalEmployees) }}</p>
                </div>
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-100">
                    <h3 class="text-sm font-semibold text-gray-500 uppercase tracking-wider">Active Users</h3>
                    <p class="text-3xl font-bold text-green-600 mt-2">{{ number_format($totalUsers) }}</p>
                </div>
            </div>

            <!-- Breakdown Tables -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                
                <!-- Assets by Category -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-bold mb-4 border-b pb-2">Assets by Category</h3>
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="p-3 text-left text-sm font-semibold text-gray-600">Category Name</th>
                                    <th class="p-3 text-right text-sm font-semibold text-gray-600">Total Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($assetsByCategory as $item)
                                <tr class="border-b">
                                    <td class="p-3">{{ $item->category ? $item->category->name : 'Uncategorized' }}</td>
                                    <td class="p-3 text-right font-semibold text-primary-600">{{ number_format($item->count) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="p-3 text-center text-gray-500">No assets found in the system.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Assets by Condition -->
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">
                        <h3 class="text-lg font-bold mb-4 border-b pb-2">Assets by Condition</h3>
                        <table class="w-full border-collapse">
                            <thead>
                                <tr class="bg-gray-50">
                                    <th class="p-3 text-left text-sm font-semibold text-gray-600">Status / Condition</th>
                                    <th class="p-3 text-right text-sm font-semibold text-gray-600">Total Count</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($assetsByCondition as $item)
                                <tr class="border-b">
                                    <td class="p-3">
                                        @if($item->condition === 'Available')
                                            <span class="px-2 py-1 bg-green-100 text-green-800 rounded-full text-xs font-semibold">Available</span>
                                        @elseif($item->condition === 'Deployed')
                                            <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded-full text-xs font-semibold">Deployed</span>
                                        @elseif($item->condition === 'Defective')
                                            <span class="px-2 py-1 bg-red-100 text-red-800 rounded-full text-xs font-semibold">Defective</span>
                                        @elseif($item->condition === 'Missing')
                                            <span class="px-2 py-1 bg-yellow-100 text-yellow-800 rounded-full text-xs font-semibold">Missing</span>
                                        @elseif($item->condition === 'Disposed')
                                            <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-semibold">Disposed</span>
                                        @else
                                            <span class="px-2 py-1 bg-gray-100 text-gray-800 rounded-full text-xs font-semibold">{{ $item->condition ?? 'Unknown' }}</span>
                                        @endif
                                    </td>
                                    <td class="p-3 text-right font-semibold text-primary-600">{{ number_format($item->count) }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="2" class="p-3 text-center text-gray-500">No assets found in the system.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>

        </div>
    </div>
</x-app-layout>
