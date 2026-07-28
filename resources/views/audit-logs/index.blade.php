<x-app-layout>
    <div class="py-6">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-200">
                        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                            {{ __('Audit Logs') }}
                        </h2>
                    </div>
                    <p class="text-sm text-gray-500 mb-4">A complete history of actions performed within the system.</p>
                    <table id="auditLogsTable" class="display w-full border-collapse">
                        <thead>
                            <tr class="bg-primary-50 text-primary-800">
                                <th class="p-3 border-b text-left">Timestamp</th>
                                <th class="p-3 border-b text-left">User</th>
                                <th class="p-3 border-b text-left">Module</th>
                                <th class="p-3 border-b text-left">Action</th>
                                <th class="p-3 border-b text-left">Description</th>
                                <th class="p-3 border-b text-left">IP Address</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Filled by DataTables -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            $('#auditLogsTable').DataTable({
                ajax: '{{ route('audit-logs.index') }}',
                order: [[0, 'desc']],
                columns: [
                    { 
                        data: 'created_at',
                        render: function(data) {
                            let date = new Date(data);
                            return date.toLocaleString();
                        }
                    },
                    { 
                        data: 'user',
                        render: function(data) {
                            return data ? data.name : 'System';
                        }
                    },
                    { 
                        data: 'module',
                        render: function(data) {
                            return `<span class="px-2 py-1 bg-gray-100 text-gray-700 rounded text-xs font-semibold">${data}</span>`;
                        }
                    },
                    { 
                        data: 'action',
                        render: function(data) {
                            let color = 'bg-gray-100 text-gray-800';
                            if(data === 'Created') color = 'bg-green-100 text-green-800';
                            if(data === 'Updated') color = 'bg-blue-100 text-blue-800';
                            if(data === 'Deleted') color = 'bg-red-100 text-red-800';
                            if(data === 'Imported') color = 'bg-purple-100 text-purple-800';
                            return `<span class="px-2 py-1 rounded-full text-xs font-semibold ${color}">${data}</span>`;
                        }
                    },
                    { data: 'description' },
                    { data: 'ip_address' }
                ],
                "dom": '<"flex justify-between items-center mb-4"lf>rt<"flex justify-between items-center mt-4"ip>',
                "language": {
                    "search": "",
                    "searchPlaceholder": "Search logs..."
                }
            });
        });
    </script>
</x-app-layout>
