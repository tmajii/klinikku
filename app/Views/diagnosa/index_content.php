<div class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1 class="m-0">Data Diagnosa</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="<?= base_url() ?>" class="spa-link" data-title="Dashboard">Home</a></li>
                    <li class="breadcrumb-item active">Diagnosa</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<section class="content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalDiagnosa" onclick="addDiagnosa()">
                    <i class="fas fa-plus"></i> Tambah Diagnosa
                </button>
                <button type="button" class="btn btn-success" onclick="printRekapDiagnosa()">
                    <i class="fas fa-file-pdf"></i> Cetak Rekap PDF
                </button>
            </div>
            <div class="card-body">
                <table id="tableDiagnosa" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>No. RM</th>
                            <th>Nama Pasien</th>
                            <th>Kode ICD</th>
                            <th>Nama Diagnosa</th>
                            <th>Jenis</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
</section>

<!-- Modal Diagnosa -->
<div class="modal fade" id="modalDiagnosa" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalDiagnosaTitle">Tambah Diagnosa</h5>
                <button type="button" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <form id="formDiagnosa" class="ajax-form">
                <input type="hidden" id="diagnosa_id" name="id">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Pilih Asesmen Pasien <span class="text-danger">*</span></label>
                        <select name="asesmenid" id="asesmenid" class="form-control" >
                            <option value="">-- Pilih Asesmen --</option>
                        </select>
                        <small class="form-text text-muted">Format: No. Reg - No. RM - Nama - Keluhan</small>
                    </div>
                    <div class="form-group">
                        <label>Kode ICD</label>
                        <input type="text" name="kode_icd" id="kode_icd" class="form-control" placeholder="Contoh: A00.0">
                    </div>
                    <div class="form-group">
                        <label>Nama Diagnosa <span class="text-danger">*</span></label>
                        <input type="text" name="nama_diagnosa" id="nama_diagnosa" class="form-control"  placeholder="Contoh: Kolera">
                    </div>
                    <div class="form-group">
                        <label>Jenis Diagnosa <span class="text-danger">*</span></label>
                        <select name="jenis_diagnosa" id="jenis_diagnosa" class="form-control" >
                            <option value="">-- Pilih Jenis --</option>
                            <option value="primer">Primer (Diagnosa Utama)</option>
                            <option value="sekunder">Sekunder (Diagnosa Tambahan)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea name="keterangan" id="keterangan" class="form-control" rows="3" placeholder="Keterangan tambahan..."></textarea>
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
if ($.fn.DataTable.isDataTable('#tableDiagnosa')) {
    $('#tableDiagnosa').DataTable().destroy();
}

// Load asesmen list
loadAsesmenList();

// Initialize DataTable
$('#tableDiagnosa').DataTable({
        processing: false,
        serverSide: false,
        ajax: {
            url: '<?= base_url('diagnosa/datatable') ?>',
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
            { data: 'kode_icd', defaultContent: '-' },
            { data: 'nama_diagnosa' },
            { 
                data: 'jenis_diagnosa',
                render: function(data) {
                    if (data == 'primer') {
                        return '<span class="badge badge-primary">Primer</span>';
                    } else {
                        return '<span class="badge badge-secondary">Sekunder</span>';
                    }
                }
            },
            { 
                data: null,
                sortable: false,
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-sm btn-info" onclick="printDiagnosa(${row.id})" title="Cetak PDF">
                            <i class="fas fa-print"></i>
                        </button>
                        <button class="btn btn-sm btn-warning" onclick="editDiagnosa(${row.id})" title="Edit">
                            <i class="fas fa-edit"></i>
                        </button>
                        <button class="btn btn-sm btn-danger" onclick="deleteDiagnosa(${row.id})" title="Hapus">
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
$('#formDiagnosa').attr('action', '<?= base_url('diagnosa/save') ?>');

function loadAsesmenList() {
    $.ajax({
        url: '<?= base_url('diagnosa/get-asesmen-list') ?>',
        type: 'GET',
        success: function(response) {
            const select = $('#asesmenid');
            select.find('option:not(:first)').remove();
            response.forEach(function(asesmen) {
                const tgl = new Date(asesmen.tglkunjungan).toLocaleDateString('id-ID');
                const keluhan = asesmen.keluhan_utama.length > 30 ? asesmen.keluhan_utama.substring(0, 30) + '...' : asesmen.keluhan_utama;
                select.append(`<option value="${asesmen.id}">${asesmen.noregistrasi} - ${asesmen.norm} - ${asesmen.nama} - ${keluhan}</option>`);
            });
        }
    });
}

function addDiagnosa() {
    $('#modalDiagnosaTitle').text('Tambah Diagnosa');
    $('#formDiagnosa')[0].reset();
    $('#diagnosa_id').val('');
}

function editDiagnosa(id) {
    $.ajax({
        url: '<?= base_url('diagnosa/get') ?>/' + id,
        type: 'GET',
        success: function(response) {
            $('#modalDiagnosaTitle').text('Edit Diagnosa');
            $('#diagnosa_id').val(response.id);
            $('#asesmenid').val(response.asesmenid);
            $('#kode_icd').val(response.kode_icd);
            $('#nama_diagnosa').val(response.nama_diagnosa);
            $('#jenis_diagnosa').val(response.jenis_diagnosa);
            $('#keterangan').val(response.keterangan);
            $('#modalDiagnosa').modal('show');
        }
    });
}

function deleteDiagnosa(id) {
    Swal.fire({
        title: 'Apakah Anda yakin?',
        text: "Data diagnosa yang dihapus tidak dapat dikembalikan!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Ya, Hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '<?= base_url('diagnosa/delete') ?>/' + id,
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
                        $('#tableDiagnosa').DataTable().ajax.reload(null, false);
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

function printDiagnosa(id) {
    window.open('<?= base_url('diagnosa/pdf') ?>/' + id, '_blank');
}

function printRekapDiagnosa() {
    window.open('<?= base_url('diagnosa/pdf-rekap') ?>', '_blank');
}
</script>
