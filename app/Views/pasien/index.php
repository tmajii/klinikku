<?= $this->extend('layouts/main') ?>

<?= $this->section('title') ?>
Data Pasien
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Pasien</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="spa-link" data-title="Dashboard">Home</a></li>
                    <li class="breadcrumb-item active">Pasien</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalPasien" onclick="addPasien()">
                    <i class="fas fa-plus"></i> Tambah Pasien
                </button>
                <button type="button" class="btn btn-success" onclick="printRekapPasien()">
                    <i class="fas fa-file-pdf"></i> Cetak Rekap PDF
                </button>
            </div>
            <div class="card-body">
                <table id="tablePasien" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No. RM</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Modal Pasien -->
<div class="modal fade" id="modalPasien" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalPasienTitle">Tambah Pasien</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="formPasien" class="ajax-form">
                <input type="hidden" id="pasien_id" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>No. RM <span class="text-danger">*</span></label>
                        <input type="text" name="norm" id="norm" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Nama <span class="text-danger">*</span></label>
                        <input type="text" name="nama" id="nama" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Alamat</label>
                        <textarea name="alamat" id="alamat" class="form-control" rows="3"></textarea>
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
<?= $this->endSection() ?>

<?= $this->section('scripts') ?>
<script>
$(document).ready(function() {
    // Initialize DataTable
    const table = $('#tablePasien').DataTable({
        processing: false,
        serverSide: false,
        ajax: {
            url: '<?= base_url('pasien/datatable') ?>',
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
            { data: 'norm' },
            { data: 'nama' },
            { data: 'alamat' },
            { 
                data: null,
                sortable: false,
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-sm btn-info" onclick="printPasien(${row.id})" title="Cetak PDF">
                            <i class="fas fa-print"></i>
                        </button>
                        <button class="btn btn-sm btn-warning" onclick="editPasien(${row.id})" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deletePasien(${row.id})" title="Hapus">
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
    $('#formPasien').attr('action', '<?= base_url('pasien/save') ?>');
});

function addPasien() {
    $('#modalPasienTitle').text('Tambah Pasien');
    $('#formPasien')[0].reset();
    $('#pasien_id').val('');
}

function editPasien(id) {
    $.ajax({
        url: '<?= base_url('pasien/get') ?>/' + id,
        type: 'GET',
        success: function(response) {
            $('#modalPasienTitle').text('Edit Pasien');
            $('#pasien_id').val(response.id);
            $('#norm').val(response.norm);
            $('#nama').val(response.nama);
            $('#alamat').val(response.alamat);
            $('#modalPasien').modal('show');
        }
    });
}

function deletePasien(id) {
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
                url: '<?= base_url('pasien/delete') ?>/' + id,
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
                        $('#tablePasien').DataTable().ajax.reload(null, false);
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

function printPasien(id) {
    // Open PDF in new tab
    window.open('<?= base_url('pasien/pdf') ?>/' + id, '_blank');
}

function printRekapPasien() {
    // Open Rekap PDF in new tab
    window.open('<?= base_url('pasien/pdf-rekap') ?>', '_blank');
}
</script>
<?= $this->endSection() ?>
