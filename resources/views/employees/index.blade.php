<x-app-layout>
    <div class="py-6">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-200">
                        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                            {{ __('Employee Management') }}
                        </h2>
                        <div class="space-x-2">
                            <button onclick="openImportModal()" class="bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded shadow transition-colors">
                                Import Employees
                            </button>
                            <button onclick="openModal()" class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded shadow transition-colors">
                                + Register Employee
                            </button>
                        </div>
                    </div>

                    <div class="mb-4 flex items-center space-x-2">
                        <label for="statusFilter" class="text-sm font-medium text-gray-700">Filter Status:</label>
                        <select id="statusFilter" class="rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 text-sm">
                            <option value="">All Statuses</option>
                            <option value="Active">Active</option>
                            <option value="Resigned">Resigned</option>
                            <option value="AWOL">AWOL</option>
                            <option value="Retired">Retired</option>
                            <option value="Terminated">Terminated</option>
                        </select>
                    </div>
                    <table id="employeesTable" class="display w-full border-collapse">
                        <thead>
                            <tr class="bg-primary-50 text-primary-800">
                                <th class="p-3 border-b text-left">Name</th>
                                <th class="p-3 border-b text-left">Department</th>
                                <th class="p-3 border-b text-left">Position</th>
                                <th class="p-3 border-b text-center">Assets</th>
                                <th class="p-3 border-b text-left">Status</th>
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

    <!-- Employee Modal -->
    <div id="employeeModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg leading-6 font-medium text-gray-900 border-b pb-2 mb-4" id="modalTitle">Register Employee</h3>
                <form id="employeeForm">
                    @csrf
                    <input type="hidden" id="employee_id">
                    
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email Address</label>
                            <input type="email" id="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">First Name</label>
                            <input type="text" id="first_name" name="first_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Middle Name</label>
                            <input type="text" id="middle_name" name="middle_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Last Name</label>
                            <input type="text" id="last_name" name="last_name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Contact Number</label>
                            <input type="text" id="contact_number" name="contact_number" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Department</label>
                            <input type="text" id="department" name="department" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Location</label>
                            <input type="text" id="location" name="location" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Position</label>
                            <input type="text" id="position" name="position" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Date Hired</label>
                            <input type="date" id="date_hired" name="date_hired" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Employment Status</label>
                            <select id="employment_status" name="employment_status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                                <option value="Active">Active</option>
                                <option value="Resigned">Resigned</option>
                                <option value="AWOL">AWOL</option>
                                <option value="Retired">Retired</option>
                                <option value="Terminated">Terminated</option>
                            </select>
                        </div>
                        <div id="last_day_container" class="hidden">
                            <label class="block text-sm font-medium text-gray-700">Last Day Date</label>
                            <input type="date" id="date_separated" name="date_separated" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500">
                        </div>
                        <div class="col-span-2">
                            <label class="block text-sm font-medium text-gray-700">Accountability Form (Optional)</label>
                            <input type="file" id="accountability_form" name="accountability_form" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-md cursor-pointer bg-gray-50 focus:outline-none" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
                        </div>
                    </div>

                    <div class="mt-4 border-t pt-4 flex justify-end space-x-2">
                        <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded hover:bg-primary-700">Save Employee</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Preview Modal -->
    <div id="previewModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 hidden overflow-y-auto h-full w-full z-[60]">
        <div class="relative top-10 mx-auto p-5 border w-full max-w-4xl shadow-lg rounded-md bg-white mb-10 h-[80vh] flex flex-col">
            <div class="flex justify-between items-center mb-4 border-b pb-2">
                <h3 class="text-lg leading-6 font-medium text-gray-900">Accountability Form Preview</h3>
                <button type="button" onclick="closePreviewModal()" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">Close</span>
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="flex-grow w-full relative" id="previewContainer">
                <!-- iframe or img will be injected here -->
            </div>
        </div>
    </div>

    <!-- View Employee Modal -->
    <div id="viewEmployeeModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-2xl shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <div class="flex justify-between items-center border-b pb-2 mb-4">
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Employee Details</h3>
                    <button type="button" onclick="closeViewModal()" class="text-gray-400 hover:text-gray-500">
                        <span class="sr-only">Close</span>
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
                <div class="mb-4">
                    <h4 class="text-md font-semibold text-gray-800 border-b pb-1 mb-2">Employee Details</h4>
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div><span class="font-bold text-gray-700">Name:</span> <span id="view_name"></span></div>
                        <div><span class="font-bold text-gray-700">Email:</span> <span id="view_email"></span></div>
                        <div><span class="font-bold text-gray-700">Department:</span> <span id="view_department"></span></div>
                        <div><span class="font-bold text-gray-700">Position:</span> <span id="view_position"></span></div>
                        <div><span class="font-bold text-gray-700">Location:</span> <span id="view_location"></span></div>
                        <div><span class="font-bold text-gray-700">Contact Number:</span> <span id="view_contact"></span></div>
                        <div><span class="font-bold text-gray-700">Date Hired:</span> <span id="view_hired"></span></div>
                        <div><span class="font-bold text-gray-700">Status:</span> <span id="view_status"></span></div>
                        <div><span class="font-bold text-gray-700">Last Day Date:</span> <span id="view_separated"></span></div>
                    </div>
                </div>

                <div class="mb-4">
                    <h4 class="text-md font-semibold text-gray-800 border-b pb-1 mb-2">Accountability Form</h4>
                    <div id="view_preview_btn_container" class="text-sm">
                        <!-- Preview button injected here -->
                    </div>
                </div>

                <div class="mb-4">
                    <h4 class="text-md font-semibold text-gray-800 border-b pb-1 mb-2">Assigned Assets</h4>
                    <ul id="view_assets_list" class="list-disc list-inside text-sm text-gray-700">
                        <!-- Assets injected here -->
                    </ul>
                </div>
                
                <div class="mb-6">
                    <h4 class="text-md font-semibold text-gray-800 border-b pb-1 mb-2">History Logs</h4>
                    <div id="employeeHistoryContent" class="space-y-4 max-h-60 overflow-y-auto p-2 bg-gray-50 rounded border">
                        <!-- Filled via AJAX -->
                    </div>
                </div>

                <div class="mt-4 border-t pt-4 flex justify-end">
                    <button type="button" onclick="closeViewModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Import Modal -->
    <div id="importModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-lg shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg leading-6 font-medium text-gray-900 border-b pb-2 mb-4">Import Employees</h3>
                
                <div class="mb-4">
                    <p class="text-sm text-gray-600 mb-2">1. Download the template and fill it out.</p>
                    <a href="{{ route('employees.import-template') }}" class="inline-block px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 text-sm font-medium">Download Template</a>
                </div>

                <form id="importForm">
                    @csrf
                    <div class="mb-4">
                        <p class="text-sm text-gray-600 mb-2">2. Upload your completed CSV or XLSX file.</p>
                        <input type="file" id="import_file" name="file" accept=".csv,.xlsx" class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded file:border-0 file:text-sm file:font-semibold file:bg-primary-50 file:text-primary-700 hover:file:bg-primary-100" required>
                    </div>

                    <div class="mt-6 border-t pt-4 flex justify-end space-x-2">
                        <button type="button" onclick="closeImportModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded hover:bg-primary-700">Import</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let table;

        $(document).ready(function() {
            // Setup CSRF for all AJAX requests
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            table = $('#employeesTable').DataTable({
                ajax: '{{ route('employees.index') }}',
                columns: [
                    { 
                        data: null,
                        render: function(data) {
                            let mid = data.middle_name ? data.middle_name + ' ' : '';
                            return data.first_name + ' ' + mid + data.last_name;
                        }
                    },
                    { data: 'department' },
                    { data: 'position' },
                    {
                        data: 'assets_count',
                        className: 'text-center',
                        render: function(data) {
                            return `<span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded border border-gray-200">${data || 0}</span>`;
                        }
                    },
                    { 
                        data: 'employment_status',
                        render: function(data) {
                            let color = data === 'Active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800';
                            return `<span class="px-2 py-1 rounded-full text-xs font-semibold ${color}">${data}</span>`;
                        }
                    },
                    {
                        data: 'id',
                        render: function(data, type, row) {
                            return `
                                <div class="flex justify-center space-x-2">
                                    <button onclick='viewEmployee(${JSON.stringify(row)})' class="text-indigo-600 hover:text-indigo-900">View</button>
                                    <button onclick='editEmployee(${JSON.stringify(row)})' class="text-primary-600 hover:text-primary-900">Edit</button>
                                    <button onclick='deleteEmployee(${data})' class="text-accent-600 hover:text-accent-900">Delete</button>
                                </div>
                            `;
                        }
                    }
                ],
                // Styling DataTables to fit Tailwind
                "dom": '<"flex justify-between items-center mb-4"lf>rt<"flex justify-between items-center mt-4"ip>',
                "language": {
                    "search": "",
                    "searchPlaceholder": "Search employees..."
                }
            });

            $('#statusFilter').on('change', function() {
                // Column 5 is 'employment_status'
                table.column(5).search(this.value).draw();
            });

            $('#employeeForm').on('submit', function(e) {
                e.preventDefault();
                let id = $('#employee_id').val();
                let url = id ? `${window.AppUrl}/employees/${id}` : '{{ route('employees.store') }}';
                
                let formData = new FormData(this);
                if (id) {
                    formData.append('_method', 'PUT');
                }

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
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

            $('#employment_status').on('change', function() {
                toggleLastDayField($(this).val());
            });
        });

        function toggleLastDayField(status) {
            if (['Resigned', 'Retired', 'Terminated'].includes(status)) {
                $('#last_day_container').removeClass('hidden');
            } else {
                $('#last_day_container').addClass('hidden');
                $('#date_separated').val('');
            }
        }

        function openModal() {
            $('#employeeForm')[0].reset();
            $('#employee_id').val('');
            $('#location').val('');
            $('#modalTitle').text('Register Employee');
            $('#last_day_container').addClass('hidden');
            $('#employeeModal').removeClass('hidden');
        }

        function closeModal() {
            $('#employeeModal').addClass('hidden');
        }

        function openImportModal() {
            $('#importForm')[0].reset();
            $('#importModal').removeClass('hidden');
        }

        function closeImportModal() {
            $('#importModal').addClass('hidden');
        }

        $('#importForm').on('submit', function(e) {
            e.preventDefault();
            let formData = new FormData(this);
            
            Swal.fire({
                title: 'Importing...',
                text: 'Please wait while we process the file.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: '{{ route('employees.import') }}',
                type: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    closeImportModal();
                    table.ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Import Complete!',
                        text: response.message,
                        timer: 3000,
                        showConfirmButton: false
                    });
                },
                error: function(xhr) {
                    let errorMsg = xhr.responseJSON?.message || 'An error occurred during import.';
                    if (xhr.responseJSON?.errors?.file) {
                        errorMsg = xhr.responseJSON.errors.file[0];
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Import Failed',
                        text: errorMsg
                    });
                }
            });
        });

        function viewEmployee(data) {
            let mid = data.middle_name ? data.middle_name + ' ' : '';
            $('#view_name').text(data.first_name + ' ' + mid + data.last_name);
            $('#view_email').text(data.email);
            $('#view_department').text(data.department);
            $('#view_position').text(data.position);
            $('#view_location').text(data.location || 'N/A');
            $('#view_contact').text(data.contact_number || 'N/A');
            $('#view_hired').text(data.date_hired || 'N/A');
            $('#view_status').text(data.employment_status);
            $('#view_separated').text(data.date_separated || 'N/A');
            
            let printBtnHtml = `<a href="${window.AppUrl}/employees/${data.id}/print-accountability" target="_blank" class="px-3 py-1 mr-2 bg-green-100 text-green-700 rounded hover:bg-green-200 font-medium border border-green-200 inline-block">Print</a>`;
            if (data.accountability_form) {
                $('#view_preview_btn_container').html(printBtnHtml + `<button onclick='previewForm("${data.accountability_form}")' class="px-3 py-1 bg-blue-100 text-blue-700 rounded hover:bg-blue-200 font-medium border border-blue-200">View Form</button>`);
            } else {
                $('#view_preview_btn_container').html(printBtnHtml + '<span class="text-gray-500 italic ml-2">No scanned form attached</span>');
            }

            let assetsHtml = '';
            if (data.assets && data.assets.length > 0) {
                data.assets.forEach(asset => {
                    let category = asset.category ? asset.category.name : 'N/A';
                    let categorySlug = asset.category ? asset.category.slug : '';
                    let brand = asset.brand || 'N/A';
                    let model = asset.model || 'N/A';
                    
                    if (categorySlug === 'peripheral' && asset.specifications && asset.specifications.peripheral_type) {
                        let pType = asset.specifications.peripheral_type;
                        assetsHtml += `<li><span class="font-semibold text-gray-800">${category}</span> - ${pType} - ${brand} - ${model}</li>`;
                    } else {
                        assetsHtml += `<li><span class="font-semibold text-gray-800">${category}</span> - ${brand} - ${model}</li>`;
                    }
                });
            } else {
                assetsHtml = '<li class="text-gray-500 italic">No assigned assets</li>';
            }
            $('#view_assets_list').html(assetsHtml);

            $('#employeeHistoryContent').html('<div class="text-center text-gray-500 py-4">Loading history...</div>');
            $('#viewEmployeeModal').removeClass('hidden');

            $.get(`${window.AppUrl}/employees/${data.id}/history`, function(historyData) {
                if (historyData.length === 0) {
                    $('#employeeHistoryContent').html('<div class="text-center text-gray-500 py-4">No history records found.</div>');
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
                $('#employeeHistoryContent').html(html);
            }).fail(function() {
                $('#employeeHistoryContent').html('<div class="text-center text-red-500 py-4">Failed to load history.</div>');
            });
        }

        function closeViewModal() {
            $('#viewEmployeeModal').addClass('hidden');
        }

        function editEmployee(data) {
            openModal();
            $('#modalTitle').text('Edit Employee');
            $('#employee_id').val(data.id);
            $('#email').val(data.email);
            $('#first_name').val(data.first_name);
            $('#middle_name').val(data.middle_name);
            $('#last_name').val(data.last_name);
            $('#contact_number').val(data.contact_number);
            $('#department').val(data.department);
            $('#position').val(data.position);
            $('#location').val(data.location);
            $('#date_hired').val(data.date_hired);
            $('#employment_status').val(data.employment_status);
            toggleLastDayField(data.employment_status);
            $('#date_separated').val(data.date_separated);
        }

        function deleteEmployee(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444', // accent-500
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `${window.AppUrl}/employees/${id}`,
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

        function previewForm(path) {
            let url = `${window.AppUrl}/storage/${path}`;
            let ext = url.split('.').pop().toLowerCase();
            let html = '';
            
            if (['jpg', 'jpeg', 'png'].includes(ext)) {
                html = `<img src="${url}" class="max-w-full h-full object-contain mx-auto">`;
            } else {
                html = `<iframe src="${url}" class="w-full h-full border-0"></iframe>`;
            }
            
            $('#previewContainer').html(html);
            $('#previewModal').removeClass('hidden');
        }
        
        function closePreviewModal() {
            $('#previewModal').addClass('hidden');
            $('#previewContainer').html('');
        }
    </script>
</x-app-layout>
