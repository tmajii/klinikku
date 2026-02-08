<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Pendaftaran</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="spa-link" data-title="Dashboard">Home</a></li>
                    <li class="breadcrumb-item active">Pendaftaran</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <?php if (can_create('pendaftaran')): ?>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalPendaftaran" onclick="addPendaftaran()">
                    <i class="fas fa-plus"></i> Tambah Pendaftaran
                </button>
                <?php endif; ?>
                <button type="button" class="btn btn-success" onclick="printRekapPendaftaran()">
                    <i class="fas fa-file-pdf"></i> Cetak Rekap PDF
                </button>
            </div>
            <div class="card-body">
                <table id="tablePendaftaran" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No. Registrasi</th>
                            <th>No. RM</th>
                            <th>Nama Pasien</th>
                            <th>Tgl. Registrasi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Modal Pendaftaran -->
<div class="modal fade" id="modalPendaftaran" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPendaftaranTitle">Tambah Pendaftaran</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="formPendaftaran" class="ajax-form">
                <input type="hidden" id="pendaftaran_id" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>No. Registrasi <span class="text-danger">*</span></label>
                        <input type="text" name="noregistrasi" id="noregistrasi" class="form-control" >
                    </div>
                    <div class="form-group">
                        <label>Pasien <span class="text-danger">*</span></label>
                        <select name="pasienid" id="pasienid" class="form-control" >
                            <option value="">-- Pilih Pasien --</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Registrasi <span class="text-danger">*</span></label>
                        <input type="date" name="tglregistrasi" id="tglregistrasi" class="form-control" >
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
if ($.fn.DataTable.isDataTable('#tablePendaftaran')) {
    $('#tablePendaftaran').DataTable().destroy();
}

// Load pasien list
loadPasienList();

// Initialize DataTable
$('#tablePendaftaran').DataTable({
        processing: false,
        serverSide: false,
        ajax: {
            url: '<?= base_url('pendaftaran/datatable') ?>',
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
            { data: 'noregistrasi' },
            { data: 'norm' },
            { data: 'nama' },
            { 
                data: 'tglregistrasi',
                render: function(data) {
                    const date = new Date(data);
                    return date.toLocaleDateString('id-ID');
                }
            },
            { 
                data: null,
                sortable: false,
                render: function(data, type, row) {
                    let buttons = `
                        <button class="btn btn-sm btn-info" onclick="printPendaftaran(${row.id})" title="Cetak PDF">
                            <i class="fas fa-print"></i>
                        </button>
                    `;
                    
                    <?php if (can_edit('pendaftaran')): ?>
                    buttons += `
                        <button class="btn btn-sm btn-warning" onclick="editPendaftaran(${row.id})" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                    `;
                    <?php endif; ?>
                    
                    <?php if (can_delete('pendaftaran')): ?>
                    buttons += `
                        <button class="btn btn-sm btn-danger" onclick="deletePendaftaran(${row.id})" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    `;
                    <?php endif; ?>
                    
                    return buttons;
                }
            }
        ],
        order: [[1, 'desc']],
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
$('#formPendaftaran').attr('action', '<?= base_url('pendaftaran/save') ?>');

function loadPasienList() {
    $.ajax({
        url: '<?= base_url('pendaftaran/get-pasien-list') ?>',
        type: 'GET',
        success: function(response) {
            const select = $('#pasienid');
            select.find('option:not(:first)').remove();
            response.forEach(function(pasien) {
                select.append(`<option value="${pasien.id}">${pasien.norm} - ${pasien.nama}</option>`);
            });
        }
    });
}

function addPendaftaran() {
    $('#modalPendaftaranTitle').text('Tambah Pendaftaran');
    $('#formPendaftaran')[0].reset();
    $('#pendaftaran_id').val('');
    $('#tglregistrasi').val(new Date().toISOString().split('T')[0]);
}

function editPendaftaran(id) {
    $.ajax({
        url: '<?= base_url('pendaftaran/get') ?>/' + id,
        type: 'GET',
        success: function(response) {
            $('#modalPendaftaranTitle').text('Edit Pendaftaran');
            $('#pendaftaran_id').val(response.id);
            $('#noregistrasi').val(response.noregistrasi);
            $('#pasienid').val(response.pasienid);
            $('#tglregistrasi').val(response.tglregistrasi);
            $('#modalPendaftaran').modal('show');
        }
    });
}

function deletePendaftaran(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= base_url('pendaftaran/delete') ?>/' + id,
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
                        $('#tablePendaftaran').DataTable().ajax.reload(null, false);
                    }
                },
                error: function(xhr) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: 'Terjadi kesalahan saat menghapus data',
                        confirmButtonColor: '#3085d6'
                    });
                }
            });
        }
    });
}

function printPendaftaran(id) {
    window.open('<?= base_url('pendaftaran/pdf') ?>/' + id, '_blank');
}

function printRekapPendaftaran() {
    window.open('<?= base_url('pendaftaran/pdf-rekap') ?>', '_blank');
}
</script>
