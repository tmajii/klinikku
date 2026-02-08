<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Manajemen User</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="spa-link" data-title="Dashboard">Home</a></li>
                    <li class="breadcrumb-item active">Users</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalUser" onclick="addUser()">
                    <i class="fas fa-plus"></i> Tambah User
                </button>
            </div>
            <div class="card-body">
                <table id="tableUser" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Nama Lengkap</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Last Login</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Modal User -->
<div class="modal fade" id="modalUser" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalUserTitle">Tambah User</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="formUser" class="ajax-form">
                <input type="hidden" id="user_id" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Username <span class="text-danger">*</span></label>
                        <input type="text" name="username" id="username" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label>Email <span class="text-danger">*</span></label>
                        <input type="email" name="email" id="email" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label>Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" name="full_name" id="full_name" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label>Password <span class="text-danger" id="password_required">*</span></label>
                        <input type="password" name="password" id="password" class="form-control">
                        <small class="form-text text-muted" id="password_hint">Kosongkan jika tidak ingin mengubah password</small>
                    </div>
                    <div class="form-group">
                        <label>Role <span class="text-danger">*</span></label>
                        <select name="role_id" id="role_id" class="form-control" >
                            <option value="">-- Pilih Role --</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Status</label>
                        <select name="is_active" id="is_active" class="form-control">
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
// Destroy existing DataTable if exists
if ($.fn.DataTable.isDataTable('#tableUser')) {
    $('#tableUser').DataTable().destroy();
}

// Load roles list
loadRolesList();

// Initialize DataTable
$('#tableUser').DataTable({
        processing: false,
        serverSide: false,
        ajax: {
            url: '<?= base_url('users/datatable') ?>',
            type: 'POST',
            dataSrc: 'data'
        },
        columns: [
            { 
                data: null,
                sortable: false,
                render: function(data, type, row, meta) {
                    return meta.row + 1;
                }
            },
            { data: 'username' },
            { data: 'email' },
            { data: 'full_name' },
            { data: 'role_name' },
            { 
                data: 'is_active',
                render: function(data) {
                    if (data == 1) {
                        return '<span class="badge badge-success">Aktif</span>';
                    } else {
                        return '<span class="badge badge-danger">Tidak Aktif</span>';
                    }
                }
            },
            { 
                data: 'last_login',
                render: function(data) {
                    if (data) {
                        return new Date(data).toLocaleString('id-ID');
                    }
                    return '-';
                }
            },
            { 
                data: null,
                sortable: false,
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-sm btn-warning" onclick="editUser(${row.id})" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deleteUser(${row.id})" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    `;
                }
            }
        ],
        order: [[1, 'asc']],
        language: {
            search: "Cari:",
            lengthMenu: "Tampilkan _MENU_ data per halaman",
            zeroRecords: "Data tidak ditemukan",
            info: "Menampilkan halaman _PAGE_ dari _PAGES_",
            infoEmpty: "Tidak ada data yang tersedia",
            infoFiltered: "(difilter dari _MAX_ total data)",
            paginate: {
                first: "Pertama",
                last: "Terakhir",
                next: "Selanjutnya",
                previous: "Sebelumnya"
            }
        }
    });
    
// Form submit handler
$('#formUser').attr('action', '<?= base_url('users/save') ?>');

function loadRolesList() {
    $.ajax({
        url: '<?= base_url('users/get-roles') ?>',
        type: 'GET',
        success: function(response) {
            const select = $('#role_id');
            select.find('option:not(:first)').remove();
            response.forEach(function(role) {
                select.append(`<option value="${role.id}">${role.role_name}</option>`);
            });
        }
    });
}

function addUser() {
    $('#modalUserTitle').text('Tambah User');
    $('#formUser')[0].reset();
    $('#user_id').val('');
    // $('#password').prop('required', true);
    $('#password_required').show();
    $('#password_hint').hide();
}

function editUser(id) {
    $.ajax({
        url: '<?= base_url('users/get') ?>/' + id,
        type: 'GET',
        success: function(response) {
            $('#modalUserTitle').text('Edit User');
            $('#user_id').val(response.id);
            $('#username').val(response.username);
            $('#email').val(response.email);
            $('#full_name').val(response.full_name);
            $('#role_id').val(response.role_id);
            $('#is_active').val(response.is_active);
            $('#password').prop('required', false);
            $('#password_required').hide();
            $('#password_hint').show();
            $('#modalUser').modal('show');
        }
    });
}

function deleteUser(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data user yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= base_url('users/delete') ?>/' + id,
                type: 'POST',
                success: function(response) {
                    if (response.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Terhapus!',
                            text: response.message,
                            timer: 2000,
                            showConfirmButton: false
                        });
                        $('#tableUser').DataTable().ajax.reload(null, false);
                    }
                },
                error: function(xhr) {
                    const response = xhr.responseJSON;
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: response?.message || 'Terjadi kesalahan saat menghapus data',
                        confirmButtonColor: '#3085d6'
                    });
                }
            });
        }
    });
}
</script>
