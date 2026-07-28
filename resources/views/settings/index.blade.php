<x-app-layout>
    <div class="py-6">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-200">
                        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                            {{ __('System Settings') }}
                        </h2>
                        <button onclick="openModal()" class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded shadow transition-colors">
                            + Add Asset Category
                        </button>
                    </div>

                    <h3 class="text-lg font-bold mb-4">Asset Categories</h3>
                    <p class="text-sm text-gray-500 mb-6">Manage the different types of assets the system can track (e.g. Computers, Monitors, Peripherals).</p>
                    
                    <table id="categoriesTable" class="display w-full border-collapse">
                        <thead>
                            <tr class="bg-primary-50 text-primary-800">
                                <th class="p-3 border-b text-left w-1/4">Name</th>
                                <th class="p-3 border-b text-left w-1/4">Slug (System ID)</th>
                                <th class="p-3 border-b text-left w-1/3">Description</th>
                                <th class="p-3 border-b text-center w-1/6">Actions</th>
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

    <!-- Category Modal -->
    <div id="categoryModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-lg shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg leading-6 font-medium text-gray-900 border-b pb-2 mb-4" id="modalTitle">Add Asset Category</h3>
                <form id="categoryForm">
                    @csrf
                    <input type="hidden" id="category_id">
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Category Name</label>
                            <input type="text" id="name" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" required placeholder="e.g. Printer">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Slug (System ID)</label>
                            <input type="text" id="slug" name="slug" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500 bg-gray-50" required placeholder="e.g. printer" title="Must be lowercase, no spaces">
                            <p class="text-xs text-gray-500 mt-1">Used internally by the system. E.g. 'computer', 'monitor', 'peripheral'.</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Description</label>
                            <textarea id="description" name="description" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500"></textarea>
                        </div>
                    </div>

                    <div class="mt-4 border-t pt-4 flex justify-end space-x-2">
                        <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded hover:bg-primary-700">Save Category</button>
                    </div>
                </form>
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

            // Auto-generate slug from name
            $('#name').on('input', function() {
                if(!$('#category_id').val()) { // Only auto-fill for new categories
                    let val = $(this).val().toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)+/g, '');
                    $('#slug').val(val);
                }
            });

            table = $('#categoriesTable').DataTable({
                ajax: '{{ route('settings.index') }}',
                columns: [
                    { 
                        data: 'name',
                        render: function(data) {
                            return `<span class="font-semibold text-gray-800">${data}</span>`;
                        }
                    },
                    { 
                        data: 'slug',
                        render: function(data) {
                            return `<span class="text-sm bg-gray-100 text-gray-600 px-2 py-1 rounded font-mono">${data}</span>`;
                        }
                    },
                    { data: 'description' },
                    {
                        data: 'id',
                        render: function(data, type, row) {
                            // Don't allow deleting core system categories easily, but we'll show edit
                            return `
                                <div class="flex justify-center space-x-2">
                                    <button onclick='editCategory(${JSON.stringify(row)})' class="text-primary-600 hover:text-primary-900">Edit</button>
                                    <button onclick='deleteCategory(${data})' class="text-accent-600 hover:text-accent-900">Delete</button>
                                </div>
                            `;
                        }
                    }
                ],
                "dom": '<"flex justify-between items-center mb-4"lf>rt<"flex justify-between items-center mt-4"ip>',
                "language": {
                    "search": "",
                    "searchPlaceholder": "Search categories..."
                }
            });

            $('#categoryForm').on('submit', function(e) {
                e.preventDefault();
                let id = $('#category_id').val();
                let url = id ? `/settings/categories/${id}` : '{{ route('settings.categories.store') }}';
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
                        let errorMsg = xhr.responseJSON.message || 'An error occurred';
                        if(errors) {
                            errorMsg = '';
                            for(let key in errors) {
                                errorMsg += errors[key][0] + '<br>';
                            }
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
            $('#categoryForm')[0].reset();
            $('#category_id').val('');
            $('#modalTitle').text('Add Asset Category');
            $('#categoryModal').removeClass('hidden');
        }

        function closeModal() {
            $('#categoryModal').addClass('hidden');
        }

        function editCategory(data) {
            openModal();
            $('#modalTitle').text('Edit Asset Category');
            $('#category_id').val(data.id);
            $('#name').val(data.name);
            $('#slug').val(data.slug);
            $('#description').val(data.description);
        }

        function deleteCategory(id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "Deleting this category may fail if assets are currently assigned to it.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#6b7280',
                confirmButtonText: 'Yes, try to delete!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/settings/categories/${id}`,
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
                        },
                        error: function(xhr) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Cannot Delete',
                                text: xhr.responseJSON.message || 'An error occurred.'
                            });
                        }
                    });
                }
            });
        }
    </script>
</x-app-layout>
