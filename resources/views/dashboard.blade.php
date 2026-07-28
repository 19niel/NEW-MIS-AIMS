<x-app-layout>
    <div class="py-6">
        <div class="w-full px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-200">
                        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                            {{ __('Dashboard') }}
                        </h2>
                        <div class="text-sm text-gray-500">
                            Welcome back, {{ Auth::user()->name }}!
                        </div>
                    </div>
                    
                    <!-- Stats Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                        <!-- Total Assets -->
                        <div class="bg-gradient-to-br from-primary-50 to-white p-6 rounded-xl border border-primary-100 shadow-sm relative overflow-hidden group hover:shadow-md transition-shadow">
                            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                                <svg class="w-16 h-16 text-primary-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 3v2m6-2v2M9 19v2m6-2v2M5 9H3m2 6H3m18-6h-2m2 6h-2M7 19h10a2 2 0 002-2V7a2 2 0 00-2-2H7a2 2 0 00-2 2v10a2 2 0 002 2zM9 9h6v6H9V9z"></path></svg>
                            </div>
                            <h3 class="text-sm font-bold text-primary-600 uppercase tracking-wider mb-1">Total Assets</h3>
                            <div class="flex items-baseline space-x-2">
                                <p class="text-4xl font-extrabold text-gray-900">{{ number_format($totalAssets) }}</p>
                            </div>
                            <div class="mt-4 flex items-center justify-between text-sm">
                                <span class="text-emerald-600 font-medium">Active: {{ number_format($activeAssets) }}</span>
                                <span class="text-rose-600 font-medium">Inactive: {{ number_format($inactiveAssets) }}</span>
                            </div>
                        </div>

                        <!-- Total Employees -->
                        <div class="bg-gradient-to-br from-emerald-50 to-white p-6 rounded-xl border border-emerald-100 shadow-sm relative overflow-hidden group hover:shadow-md transition-shadow">
                            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                                <svg class="w-16 h-16 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                            </div>
                            <h3 class="text-sm font-bold text-emerald-600 uppercase tracking-wider mb-1">Total Employees</h3>
                            <div class="flex items-baseline space-x-2">
                                <p class="text-4xl font-extrabold text-gray-900">{{ number_format($totalEmployees) }}</p>
                            </div>
                            <div class="mt-4 flex items-center justify-between text-sm">
                                <span class="text-emerald-600 font-medium">Active: {{ number_format($activeEmployees) }}</span>
                                <span class="text-rose-600 font-medium">Inactive: {{ number_format($inactiveEmployees) }}</span>
                            </div>
                        </div>

                        <!-- Total Users -->
                        <div class="bg-gradient-to-br from-indigo-50 to-white p-6 rounded-xl border border-indigo-100 shadow-sm relative overflow-hidden group hover:shadow-md transition-shadow">
                            <div class="absolute top-0 right-0 p-4 opacity-10 group-hover:opacity-20 transition-opacity">
                                <svg class="w-16 h-16 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                            </div>
                            <h3 class="text-sm font-bold text-indigo-600 uppercase tracking-wider mb-1">System Users</h3>
                            <div class="flex items-baseline space-x-2">
                                <p class="text-4xl font-extrabold text-gray-900">{{ number_format($totalUsers) }}</p>
                            </div>
                            <div class="mt-4 flex items-center justify-between text-sm">
                                <span class="text-emerald-600 font-medium">Active: {{ number_format($activeUsers) }}</span>
                                <span class="text-rose-600 font-medium">Inactive: {{ number_format($inactiveUsers) }}</span>
                            </div>
                        </div>

                        <!-- Quick Actions -->
                        <div class="p-6 rounded-xl border border-gray-200 shadow-sm bg-white flex flex-col justify-center space-y-3">
                            <h3 class="text-sm font-bold text-gray-600 uppercase tracking-wider mb-1">Quick Actions</h3>
                            <a href="{{ route('assets.index') }}" class="text-sm font-medium text-primary-600 hover:text-primary-800 flex items-center">
                                <span class="mr-2">→</span> Go to Asset Register
                            </a>
                            <a href="{{ route('employees.index') }}" class="text-sm font-medium text-emerald-600 hover:text-emerald-800 flex items-center">
                                <span class="mr-2">→</span> Go to Employee Register
                            </a>
                        </div>
                    </div>

                    <!-- Recent Assets Table -->
                    <div class="mt-8">
                        <h3 class="text-lg font-bold text-gray-800 mb-4 pb-2 border-b">Recently Added Assets</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Asset Tag</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Category</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Assigned To</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Condition</th>
                                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Added</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @forelse($recentAssets as $asset)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <div class="text-sm font-medium text-gray-900">{{ $asset->asset_tag }}</div>
                                            <div class="text-xs text-gray-500">{{ $asset->brand }} {{ $asset->model }}</div>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                                {{ $asset->category ? $asset->category->name : 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $asset->assignedEmployee ? $asset->assignedEmployee->first_name . ' ' . $asset->assignedEmployee->last_name : 'Unassigned' }}
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap">
                                            @if(in_array($asset->condition, ['Available', 'Deployed', 'Active']))
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">{{ $asset->condition }}</span>
                                            @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">{{ $asset->condition }}</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                            {{ $asset->created_at->diffForHumans() }}
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 text-center">
                                            No assets found in the system yet.
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
