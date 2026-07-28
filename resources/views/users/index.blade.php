<x-app-layout>
    <div class="py-6">
        <div class="w-full px-4 sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="flex justify-between items-center mb-6 pb-4 border-b border-gray-200">
                        <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                            {{ __('User Management') }}
                        </h2>
                        <button onclick="openModal()" class="bg-primary-600 hover:bg-primary-700 text-white font-bold py-2 px-4 rounded shadow transition-colors">
                            + Create User
                        </button>
                    </div>
                    
                    <table id="usersTable" class="display w-full border-collapse">
                        <thead>
                            <tr class="bg-primary-50 text-primary-800">
                                <th class="p-3 border-b text-left">Full Name</th>
                                <th class="p-3 border-b text-left">Username</th>
                                <th class="p-3 border-b text-left">Email</th>
                                <th class="p-3 border-b text-left">Role</th>
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

    <!-- User Modal -->
    <div id="userModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 hidden overflow-y-auto h-full w-full z-50">
        <div class="relative top-20 mx-auto p-5 border w-full max-w-lg shadow-lg rounded-md bg-white">
            <div class="mt-3">
                <h3 class="text-lg leading-6 font-medium text-gray-900 border-b pb-2 mb-4" id="modalTitle">Create User</h3>
                <form id="userForm">
                    @csrf
                    <input type="hidden" id="user_id">
                    
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Full Name</label>
                            <input type="text" id="name" name="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Username</label>
                            <input type="text" id="username" name="username" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Email Address</label>
                            <input type="email" id="email" name="email" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Password</label>
                            <input type="password" id="password" name="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" placeholder="Leave blank to keep current password">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Role</label>
                            <select id="role" name="role" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" required>
                                <option value="Admin">Admin</option>
                                <option value="IT">IT</option>
                                <option value="Staff">Staff</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select id="status" name="status" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring-primary-500" required>
                                <option value="Active">Active</option>
                                <option value="Disabled">Disabled</option>
                            </select>
                        </div>
                    </div>

                    <div class="mt-4 border-t pt-4 flex justify-end space-x-2">
                        <button type="button" onclick="closeModal()" class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400">Cancel</button>
                        <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded hover:bg-primary-700">Save User</button>
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

            table = $('#usersTable').DataTable({
                ajax: '{{ route('users.index') }}',
                columns: [
                    { data: 'name' },
                    { data: 'username' },
                    { data: 'email' },
                    { 
                        data: 'roles',
                        render: function(data) {
                            return data.length > 0 ? data[0].name : 'N/A';
                        }
                    },
                    { 
                        data: 'status',
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
                                    <button onclick='editUser(${JSON.stringify(row)})' class="text-primary-600 hover:text-primary-900">Edit</button>
                                    <button onclick='deleteUser(${data})' class="text-accent-600 hover:text-accent-900">Delete</button>
                                </div>
                            `;
                        }
                    }
                ],
                "dom": '<"flex justify-between items-center mb-4"lf>rt<"flex justify-between items-center mt-4"ip>',
                "language": {
                    "search": "",
                    "searchPlaceholder": "Search users..."
                }
            });

            $('#userForm').on('submit', function(e) {
                e.preventDefault();
                let id = $('#user_id').val();
                let url = id ? `${window.AppUrl}/users/${id}` : '{{ route('users.store') }}';
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
            $('#userForm')[0].reset();
            $('#user_id').val('');
            $('#modalTitle').text('Create User');
            $('#password').prop('required', true);
            $('#userModal').removeClass('hidden');
        }

        function closeModal() {
            $('#userModal').addClass('hidden');
        }

        function editUser(data) {
            openModal();
            $('#modalTitle').text('Edit User');
            $('#user_id').val(data.id);
            $('#name').val(data.name);
            $('#username').val(data.username);
            $('#email').val(data.email);
            $('#status').val(data.status);
            if (data.roles && data.roles.length > 0) {
                $('#role').val(data.roles[0].name);
            }
            $('#password').prop('required', false);
        }

        function deleteUser(id) {
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
                        url: `${window.AppUrl}/users/${id}`,
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
    </script>
</x-app-layout>
