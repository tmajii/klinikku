<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Asesmen</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="spa-link" data-title="Dashboard">Home</a></li>
                    <li class="breadcrumb-item active">Asesmen</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalAsesmen" onclick="addAsesmen()">
                    <i class="fas fa-plus"></i> Tambah Asesmen
                </button>
                <button type="button" class="btn btn-success" onclick="printRekapAsesmen()">
                    <i class="fas fa-file-pdf"></i> Cetak Rekap PDF
                </button>
            </div>
            <div class="card-body">
                <table id="tableAsesmen" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No. Registrasi</th>
                            <th>No. RM</th>
                            <th>Nama Pasien</th>
                            <th>Jenis Kunjungan</th>
                            <th>Keluhan Utama</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Modal Asesmen -->
<div class="modal fade" id="modalAsesmen" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalAsesmenTitle">Tambah Asesmen</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="formAsesmen" class="ajax-form">
                <input type="hidden" id="asesmen_id" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Kunjungan <span class="text-danger">*</span></label>
                        <select name="kunjunganid" id="kunjunganid" class="form-control" >
                            <option value="">-- Pilih Kunjungan --</option>
                        </select>
                        <small class="form-text text-muted">Format: No. Reg - No. RM - Nama - Jenis Kunjungan</small>
                    </div>
                    <div class="form-group">
                        <label>Keluhan Utama <span class="text-danger">*</span></label>
                        <textarea name="keluhan_utama" id="keluhan_utama" class="form-control" rows="4"  placeholder="Tuliskan keluhan utama pasien..."></textarea>
                    </div>
                    <div class="form-group">
                        <label>Keluhan Tambahan</label>
                        <textarea name="keluhan_tambahan" id="keluhan_tambahan" class="form-control" rows="3" placeholder="Tuliskan keluhan tambahan jika ada..."></textarea>
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
if ($.fn.DataTable.isDataTable('#tableAsesmen')) {
    $('#tableAsesmen').DataTable().destroy();
}

// Load kunjungan list
loadKunjunganList();

// Initialize DataTable
$('#tableAsesmen').DataTable({
        processing: false,
        serverSide: false,
        ajax: {
            url: '<?= base_url('asesmen/datatable') ?>',
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
                data: 'keluhan_utama',
                render: function(data) {
                    return data.length > 50 ? data.substring(0, 50) + '...' : data;
                }
            },
            { 
                data: null,
                sortable: false,
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-sm btn-info" onclick="printAsesmen(${row.id})" title="Cetak PDF">
                            <i class="fas fa-print"></i>
                        </button>
                        <button class="btn btn-sm btn-warning" onclick="editAsesmen(${row.id})" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deleteAsesmen(${row.id})" title="Hapus">
                            <i class="fas fa-trash"></i>
                        </button>
                    `;
                }
            }
        ],
        order: [[0, 'desc']],
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
$('#formAsesmen').attr('action', '<?= base_url('asesmen/save') ?>');

function loadKunjunganList() {
    $.ajax({
        url: '<?= base_url('asesmen/get-kunjungan-list') ?>',
        type: 'GET',
        success: function(response) {
            const select = $('#kunjunganid');
            select.find('option:not(:first)').remove();
            response.forEach(function(kunjungan) {
                const tgl = new Date(kunjungan.tglkunjungan).toLocaleDateString('id-ID');
                select.append(`<option value="${kunjungan.id}">${kunjungan.noregistrasi} - ${kunjungan.norm} - ${kunjungan.nama} - ${kunjungan.jeniskunjungan} (${tgl})</option>`);
            });
        }
    });
}

function addAsesmen() {
    $('#modalAsesmenTitle').text('Tambah Asesmen');
    $('#formAsesmen')[0].reset();
    $('#asesmen_id').val('');
}

function editAsesmen(id) {
    $.ajax({
        url: '<?= base_url('asesmen/get') ?>/' + id,
        type: 'GET',
        success: function(response) {
            $('#modalAsesmenTitle').text('Edit Asesmen');
            $('#asesmen_id').val(response.id);
            $('#kunjunganid').val(response.kunjunganid);
            $('#keluhan_utama').val(response.keluhan_utama);
            $('#keluhan_tambahan').val(response.keluhan_tambahan);
            $('#modalAsesmen').modal('show');
        }
    });
}

function deleteAsesmen(id) {
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
                url: '<?= base_url('asesmen/delete') ?>/' + id,
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
                        $('#tableAsesmen').DataTable().ajax.reload(null, false);
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

function printAsesmen(id) {
    window.open('<?= base_url('asesmen/pdf') ?>/' + id, '_blank');
}

function printRekapAsesmen() {
    window.open('<?= base_url('asesmen/pdf-rekap') ?>', '_blank');
}
</script>
