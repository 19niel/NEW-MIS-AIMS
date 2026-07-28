<x-app-layout>
    <div class="py-6">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-200">
                        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                            {{ __('Asset Management') }}
                        </h2>
                        <button onclick="openModal()" class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded shadow transition-colors">
                            + Register Asset
                        </button>
                    </div>

                    <div class="mb-4 flex items-center space-x-2">
                        <label for="conditionFilter" class="text-sm font-medium text-gray-700">Filter Condition:</label>
                        <select id="conditionFilter" class="rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm">
                            <option value="">All Conditions</option>
                            <option value="Available">Available</option>
                            <option value="Active">Active</option>
                            <option value="Under Repair">Under Repair</option>
                            <option value="Disposed">Disposed</option>
                        </select>
                    </div>
                    <table id="assetsTable" class="display w-full border-collapse">
                        <thead>
                            <tr class="bg-primary-50 text-primary-800">
                                <th class="p-3 border-b text-left">Asset Tag</th>
                                <th class="p-3 border-b text-left">Category</th>
                                <th class="p-3 border-b text-left">Brand/Model</th>
                                <th class="p-3 border-b text-left">Serial No.</th>
                                <th class="p-3 border-b text-left">Deployed To</th>
                                <th class="p-3 border-b text-left">Condition</th>
                                <th class="p-3 border-b text-center">Actions</th>
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

    <!-- Asset Modal -->
    <div id="assetModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-md bg-white mb-20">
            <div class="mt-3">
                <h3 class="text-lg leading-6 font-medium text-gray-900 border-b pb-2 mb-4" id="modalTitle">Register Asset</h3>
                <form id="assetForm">
                    @csrf
                    <input type="hidden" id="asset_id">
                    
                    <div class="space-y-6">
                        <!-- General Info -->
                        <div class="space-y-4">
                            <h4 class="font-semibold text-primary-700 border-b pb-1">General Information</h4>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Category</label>
                                    <select id="asset_category_id" name="asset_category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" required>
                                        <option value="" disabled selected>Select Category</option>
                                        @foreach($categories as $category)
                                            <option value="{{ $category->id }}" data-slug="{{ $category->slug }}">{{ $category->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Brand</label>
                                    <input type="text" id="brand" name="brand" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Model</label>
                                    <input type="text" id="model" name="model" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Serial Number</label>
                                    <input type="text" id="serial_number" name="serial_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Purchase Date</label>
                                    <input type="date" id="purchase_date" name="purchase_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Arrival Date</label>
                                    <input type="date" id="arrival_date" name="arrival_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Deployed Date</label>
                                    <input type="date" id="deployment_date" name="deployment_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Deployed To</label>
                                    <select id="assigned_to" name="assigned_to" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                        <option value="">Unassigned</option>
                                        @foreach($employees as $employee)
                                            <option value="{{ $employee->id }}">{{ $employee->first_name }} {{ $employee->last_name }} ({{ $employee->department }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Condition</label>
                                    <select id="condition" name="condition" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" required>
                                        <option value="Available">Available</option>
                                        <option value="Active">Active</option>
                                        <option value="Under Repair">Under Repair</option>
                                        <option value="Disposed">Disposed</option>
                                    </select>
                                </div>
                                <div class="col-span-2">
                                    <label class="block text-sm font-medium text-gray-700">Remarks</label>
                                    <textarea id="remarks" name="remarks" rows="2" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"></textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Computer Specific Specs -->
                        <div id="computer_specs" class="space-y-4 hidden bg-gray-50 p-4 rounded-lg border">
                            <h4 class="font-semibold text-primary-700 border-b pb-1">Computer Specifications</h4>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700">Processor</label>
                                <input type="text" id="processor" name="processor" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">RAM Capacity</label>
                                    <input type="text" id="ram_capacity" name="ram_capacity" placeholder="e.g. 16GB" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">RAM Type</label>
                                    <input type="text" id="ram_type" name="ram_type" placeholder="e.g. DDR4" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Storage Size</label>
                                    <input type="text" id="storage_size" name="storage_size" placeholder="e.g. 512GB" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Storage Type</label>
                                    <input type="text" id="storage_type" name="storage_type" placeholder="e.g. NVMe SSD" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">OS Version</label>
                                    <input type="text" id="os_version" name="os_version" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">OS Install Date</label>
                                    <input type="date" id="os_install_date" name="os_install_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">AntiVirus</label>
                                    <input type="text" id="antivirus" name="antivirus" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">AntiVirus Install Date</label>
                                    <input type="date" id="antivirus_install_date" name="antivirus_install_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">MAC Address</label>
                                    <input type="text" id="mac_address" name="mac_address" placeholder="e.g. 00:1A:2B:3C:4D:5E" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">IP Address</label>
                                    <input type="text" id="ip_address" name="ip_address" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Monitor Specific Specs -->
                        <div id="monitor_specs" class="space-y-4 hidden bg-gray-50 p-4 rounded-lg border">
                            <h4 class="font-semibold text-primary-700 border-b pb-1">Monitor Specifications</h4>
                            
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Resolution</label>
                                    <input type="text" id="resolution" name="resolution" placeholder="e.g. 1920x1080" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Refresh Rate</label>
                                    <input type="text" id="refresh_rate" name="refresh_rate" placeholder="e.g. 144Hz" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Response Time</label>
                                    <input type="text" id="response_time" name="response_time" placeholder="e.g. 1ms" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Panel Type</label>
                                    <input type="text" id="panel_type" name="panel_type" placeholder="e.g. IPS" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                </div>
                            </div>
                        </div>
                        
                        <!-- Peripheral Specific Specs -->
                        <div id="peripheral_specs" class="space-y-4 hidden bg-gray-50 p-4 rounded-lg border">
                            <h4 class="font-semibold text-primary-700 border-b pb-1">Peripheral Specifications</h4>
                            
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Peripheral Type</label>
                                    <select id="peripheral_type" name="peripheral_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                        <option value="" disabled selected>Select Type</option>
                                        <option value="Laptop Charger">Laptop Charger</option>
                                        <option value="Mouse">Mouse</option>
                                        <option value="Keyboard">Keyboard</option>
                                        <option value="Flash Drive">Flash Drive</option>
                                        <option value="Headset">Headset</option>
                                        <option value="HDMI">HDMI</option>
                                        <option value="UPS">UPS</option>
                                        <option value="Others">Others</option>
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700">Connection Type</label>
                                    <select id="connection_type" name="connection_type" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                        <option value="" disabled selected>Select Connection</option>
                                        <option value="Wired">Wired</option>
                                        <option value="Wireless">Wireless</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-6 border-t pt-4 flex justify-end space-x-2">
                        <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded hover:bg-primary-700">Save Asset</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- View Asset Modal -->
    <div id="viewAssetModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-3xl shadow-lg rounded-md bg-white mb-20">
            <div class="mt-3">
                <div class="flex justify-between items-center border-b pb-2 mb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Asset Details</h3>
                    <button type="button" onclick="closeViewAssetModal()" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                
                <div class="mb-6">
                    <h4 class="text-md font-semibold text-gray-800 border-b pb-1 mb-2">General Information</h4>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div><span class="font-bold text-gray-700">Asset Tag:</span> <span id="view_asset_tag"></span></div>
                        <div><span class="font-bold text-gray-700">Category:</span> <span id="view_asset_category"></span></div>
                        <div><span class="font-bold text-gray-700">Brand:</span> <span id="view_asset_brand"></span></div>
                        <div><span class="font-bold text-gray-700">Model:</span> <span id="view_asset_model"></span></div>
                        <div><span class="font-bold text-gray-700">Serial Number:</span> <span id="view_asset_serial"></span></div>
                        <div><span class="font-bold text-gray-700">Condition:</span> <span id="view_asset_condition"></span></div>
                        <div><span class="font-bold text-gray-700">Deployed To:</span> <span id="view_asset_deployed"></span></div>
                        <div class="col-span-2"><span class="font-bold text-gray-700">Remarks:</span> <span id="view_asset_remarks"></span></div>
                    </div>
                </div>

                <div class="mb-6">
                    <h4 class="text-md font-semibold text-gray-800 border-b pb-1 mb-2">History Logs</h4>
                    <div id="historyContent" class="space-y-4 max-h-60 overflow-y-auto p-2 bg-gray-50 rounded border">
                        <!-- Filled via AJAX -->
                    </div>
                </div>

                <div class="mt-4 border-t pt-4 flex justify-end">
                    <button type="button" onclick="closeViewAssetModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Close</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let table;

        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            table = $('#assetsTable').DataTable({
                ajax: '{{ route('assets.index') }}',
                columns: [
                    { 
                        data: 'asset_tag',
                        render: function(data) {
                            return `<span class="font-bold text-primary-600">${data}</span>`;
                        }
                    },
                    { data: 'category.name' },
                    { 
                        data: null,
                        render: function(data) {
                            let brand = data.brand || '';
                            let model = data.model || '';
                            return (brand + ' ' + model).trim() || 'N/A';
                        }
                    },
                    { data: 'serial_number' },
                    { 
                        data: 'assigned_employee',
                        render: function(data) {
                            return data ? (data.first_name + ' ' + data.last_name) : '<span class="text-gray-400 italic">Unassigned</span>';
                        }
                    },
                    { 
                        data: 'condition',
                        render: function(data) {
                            let color = 'bg-gray-100 text-gray-800';
                            if (data === 'Available') color = 'bg-green-100 text-green-800';
                            if (data === 'Active') color = 'bg-blue-100 text-blue-800';
                            if (data === 'Under Repair') color = 'bg-yellow-100 text-yellow-800';
                            if (data === 'Disposed') color = 'bg-red-100 text-red-800';
                            return `<span class="px-2 py-1 rounded-full text-xs font-semibold ${color}">${data}</span>`;
                        }
                    },
                    {
                        data: 'id',
                        render: function(data, type, row) {
                            return `
                                <div class="flex justify-center space-x-2">
                                    <button onclick='viewAsset(${JSON.stringify(row)})' class="text-indigo-600 hover:text-indigo-900">View</button>
                                    <button onclick='editAsset(${JSON.stringify(row)})' class="text-primary-600 hover:text-primary-900">Edit</button>
                                    <button onclick='deleteAsset(${data})' class="text-accent-600 hover:text-accent-900">Delete</button>
                                </div>
                            `;
                        }
                    }
                ],
                "dom": '<"flex justify-between items-center mb-4"lf>rt<"flex justify-between items-center mt-4"ip>',
                "language": {
                    "search": "",
                    "searchPlaceholder": "Search assets..."
                }
            });

            $('#conditionFilter').on('change', function() {
                // Column 5 is 'condition'
                table.column(5).search(this.value).draw();
            });

            // Dynamic Form Toggle
            $('#asset_category_id').on('change', function() {
                let slug = $(this).find(':selected').data('slug');
                
                // Hide and clear all specific sections
                $('#computer_specs, #monitor_specs, #peripheral_specs').addClass('hidden');
                $('#computer_specs input, #monitor_specs input, #peripheral_specs select').val('');

                if (slug === 'laptop' || slug === 'desktop' || slug === 'server') {
                    $('#computer_specs').removeClass('hidden');
                } else if (slug === 'monitor') {
                    $('#monitor_specs').removeClass('hidden');
                } else if (slug === 'peripheral') {
                    $('#peripheral_specs').removeClass('hidden');
                }
            });

            $('#assetForm').on('submit', function(e) {
                e.preventDefault();
                let id = $('#asset_id').val();
                let url = id ? `/assets/${id}` : '{{ route('assets.store') }}';
                let method = id ? 'PUT' : 'POST';

                $.ajax({
                    url: url,
                    type: method,
                    data: $(this).serialize(),
                    success: function(response) {
                        closeModal();
                        table.ajax.reload();
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                    },
                    error: function(xhr) {
                        let errors = xhr.responseJSON.errors;
                        let errorMsg = '';
                        for(let key in errors) {
                            errorMsg += errors[key][0] + '<br>';
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Validation Error',
                            html: errorMsg
                        });
                    }
                });
            });
        });

        function openModal() {
            $('#assetForm')[0].reset();
            $('#asset_id').val('');
            $('#remarks').val('');
            $('#modalTitle').text('Register Asset');
            $('#computer_specs, #monitor_specs, #peripheral_specs').addClass('hidden');
            $('#assetModal').removeClass('hidden');
        }

        function closeModal() {
            $('#assetModal').addClass('hidden');
        }

        function editAsset(data) {
            openModal();
            $('#modalTitle').text('Edit Asset');
            $('#asset_id').val(data.id);
            $('#asset_category_id').val(data.asset_category_id).trigger('change');
            $('#brand').val(data.brand);
            $('#model').val(data.model);
            $('#serial_number').val(data.serial_number);
            $('#purchase_date').val(data.purchase_date);
            $('#arrival_date').val(data.arrival_date);
            $('#deployment_date').val(data.deployment_date);
            $('#assigned_to').val(data.assigned_to || '');
            $('#condition').val(data.condition);
            $('#remarks').val(data.remarks || '');
            
            if (data.specifications) {
                $('#processor').val(data.specifications.processor || '');
                $('#os_version').val(data.specifications.os_version || '');
                $('#os_install_date').val(data.specifications.os_install_date || '');
                $('#antivirus').val(data.specifications.antivirus || '');
                $('#antivirus_install_date').val(data.specifications.antivirus_install_date || '');
                $('#mac_address').val(data.specifications.mac_address || '');
                $('#ip_address').val(data.specifications.ip_address || '');
                
                $('#resolution').val(data.specifications.resolution || '');
                $('#refresh_rate').val(data.specifications.refresh_rate || '');
                $('#response_time').val(data.specifications.response_time || '');
                $('#panel_type').val(data.specifications.panel_type || '');
                
                $('#peripheral_type').val(data.specifications.peripheral_type || '');
                $('#connection_type').val(data.specifications.connection_type || '');
            }
            
            if (data.ram_modules && data.ram_modules.length > 0) {
                $('#ram_capacity').val(data.ram_modules[0].capacity);
                $('#ram_type').val(data.ram_modules[0].type);
            }
            
            if (data.storage_drives && data.storage_drives.length > 0) {
                $('#storage_size').val(data.storage_drives[0].size);
                $('#storage_type').val(data.storage_drives[0].type);
            }
        }

        function deleteAsset(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/assets/${id}`,
                        type: 'DELETE',
                        success: function(response) {
                            table.ajax.reload();
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: response.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    });
                }
            });
        }
        function viewAsset(data) {
            // Populate Asset Details
            $('#view_asset_tag').text(data.asset_tag || 'N/A');
            $('#view_asset_category').text(data.category ? data.category.name : 'N/A');
            $('#view_asset_brand').text(data.brand || 'N/A');
            $('#view_asset_model').text(data.model || 'N/A');
            $('#view_asset_serial').text(data.serial_number || 'N/A');
            $('#view_asset_condition').text(data.condition);
            $('#view_asset_remarks').text(data.remarks || 'N/A');
            let deployed = data.assigned_employee ? (data.assigned_employee.first_name + ' ' + data.assigned_employee.last_name) : 'Unassigned';
            $('#view_asset_deployed').text(deployed);

            $('#historyContent').html('<div class="text-center text-gray-500 py-4">Loading history...</div>');
            $('#viewAssetModal').removeClass('hidden');
            
            $.get(`/assets/${data.id}/history`, function(historyData) {
                if (historyData.length === 0) {
                    $('#historyContent').html('<div class="text-center text-gray-500 py-4">No history records found.</div>');
                    return;
                }
                
                let html = '<ul class="relative border-l border-gray-200 ml-3">';
                historyData.forEach(log => {
                    let date = new Date(log.created_at).toLocaleString();
                    let performer = log.performer ? log.performer.name : 'System';
                    html += `
                        <li class="mb-4 ml-4">
                            <div class="absolute w-3 h-3 bg-primary-600 rounded-full mt-1.5 -left-1.5 border border-white"></div>
                            <time class="mb-1 text-xs font-normal leading-none text-gray-400">${date}</time>
                            <h3 class="text-sm font-semibold text-gray-900">${log.action_type} <span class="font-normal text-xs text-gray-500">by ${performer}</span></h3>
                            <p class="text-sm font-normal text-gray-500">${log.description}</p>
                        </li>
                    `;
                });
                html += '</ul>';
                $('#historyContent').html(html);
            }).fail(function() {
                $('#historyContent').html('<div class="text-center text-red-500 py-4">Failed to load history.</div>');
            });
        }

        function closeViewAssetModal() {
            $('#viewAssetModal').addClass('hidden');
        }
    </script>
</x-app-layout>
