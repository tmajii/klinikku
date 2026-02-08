<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>
<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Kunjungan</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="spa-link" data-title="Dashboard">Home</a></li>
                    <li class="breadcrumb-item active">Kunjungan</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalKunjungan" onclick="addKunjungan()">
                    <i class="fas fa-plus"></i> Tambah Kunjungan
                </button>
                <button type="button" class="btn btn-success" onclick="printRekapKunjungan()">
                    <i class="fas fa-file-pdf"></i> Cetak Rekap PDF
                </button>
            </div>
            <div class="card-body">
                <table id="tableKunjungan" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No. Registrasi</th>
                            <th>No. RM</th>
                            <th>Nama Pasien</th>
                            <th>Jenis Kunjungan</th>
                            <th>Tgl. Kunjungan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Modal Kunjungan -->
<div class="modal fade" id="modalKunjungan" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalKunjunganTitle">Tambah Kunjungan</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="formKunjungan" class="ajax-form">
                <input type="hidden" id="kunjungan_id" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Pendaftaran <span class="text-danger">*</span></label>
                        <select name="pendaftaranpasienid" id="pendaftaranpasienid" class="form-control" required>
                            <option value="">-- Pilih Pendaftaran --</option>
                        </select>
                        <small class="form-text text-muted">Format: No. Reg - No. RM - Nama Pasien</small>
                    </div>
                    <div class="form-group">
                        <label>Jenis Kunjungan <span class="text-danger">*</span></label>
                        <select name="jeniskunjungan" id="jeniskunjungan" class="form-control" required>
                            <option value="">-- Pilih Jenis --</option>
                            <option value="Rawat Jalan">Rawat Jalan</option>
                            <option value="Rawat Inap">Rawat Inap</option>
                            <option value="IGD">IGD</option>
                            <option value="Kontrol">Kontrol</option>
                            <option value="Konsultasi">Konsultasi</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Tanggal Kunjungan <span class="text-danger">*</span></label>
                        <input type="date" name="tglkunjungan" id="tglkunjungan" class="form-control" required>
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
$(document).ready(function() {
    // Load pendaftaran list
    loadPendaftaranList();
    
    // Initialize DataTable
    const table = $('#tableKunjungan').DataTable({
        processing: false,
        serverSide: false,
        ajax: {
            url: '<?= base_url('kunjungan/datatable') ?>',
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
            { data: 'jeniskunjungan' },
            { 
                data: 'tglkunjungan',
                render: function(data) {
                    const date = new Date(data);
                    return date.toLocaleDateString('id-ID');
                }
            },
            { 
                data: null,
                sortable: false,
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-sm btn-info" onclick="printKunjungan(${row.id})" title="Cetak PDF">
                            <i class="fas fa-print"></i>
                        </button>
                        <button class="btn btn-sm btn-warning" onclick="editKunjungan(${row.id})" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deleteKunjungan(${row.id})" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    `;
                }
            }
        ],
        order: [[5, 'desc']],
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
    $('#formKunjungan').attr('action', '<?= base_url('kunjungan/save') ?>');
});

function loadPendaftaranList() {
    $.ajax({
        url: '<?= base_url('kunjungan/get-pendaftaran-list') ?>',
        type: 'GET',
        success: function(response) {
            const select = $('#pendaftaranpasienid');
            select.find('option:not(:first)').remove();
            response.forEach(function(pendaftaran) {
                select.append(`<option value="${pendaftaran.id}">${pendaftaran.noregistrasi} - ${pendaftaran.norm} - ${pendaftaran.nama}</option>`);
            });
        }
    });
}

function addKunjungan() {
    $('#modalKunjunganTitle').text('Tambah Kunjungan');
    $('#formKunjungan')[0].reset();
    $('#kunjungan_id').val('');
    $('#tglkunjungan').val(new Date().toISOString().split('T')[0]);
}

function editKunjungan(id) {
    $.ajax({
        url: '<?= base_url('kunjungan/get') ?>/' + id,
        type: 'GET',
        success: function(response) {
            $('#modalKunjunganTitle').text('Edit Kunjungan');
            $('#kunjungan_id').val(response.id);
            $('#pendaftaranpasienid').val(response.pendaftaranpasienid);
            $('#jeniskunjungan').val(response.jeniskunjungan);
            $('#tglkunjungan').val(response.tglkunjungan);
            $('#modalKunjungan').modal('show');
        }
    });
}

function deleteKunjungan(id) {
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
                url: '<?= base_url('kunjungan/delete') ?>/' + id,
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
                        $('#tableKunjungan').DataTable().ajax.reload(null, false);
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

function printKunjungan(id) {
    window.open('<?= base_url('kunjungan/pdf') ?>/' + id, '_blank');
}

function printRekapKunjungan() {
    window.open('<?= base_url('kunjungan/pdf-rekap') ?>', '_blank');
}
</script>
<?= $this->endSection() ?>
