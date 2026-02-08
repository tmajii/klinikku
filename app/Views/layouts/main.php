<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title id="page-title">Dashboard | AdminLTE</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/dataTables.bootstrap4.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <!-- AdminLTE -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    
    <style>
        /* Loading overlay */
        .loading-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0,0,0,0.3);
            z-index: 9999;
            justify-content: center;
            align-items: center;
        }
        .loading-overlay.show {
            display: flex;
        }
        .spinner-border-custom {
            width: 3rem;
            height: 3rem;
            border: 0.3em solid rgba(255,255,255,0.3);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
        }
        @keyframes spin {
            to { transform: rotate(360deg); }
        }
        /* Smooth transition */
        .content-wrapper {
            transition: opacity 0.2s ease-in-out;
        }
        .content-wrapper.loading {
            opacity: 0.5;
        }
        /* DataTables custom */
        .dataTables_wrapper .dataTables_processing {
            background: rgba(255,255,255,0.9);
            border: 1px solid #ddd;
        }
        /* Invalid field styling */
        .is-invalid {
            border-color: #dc3545 !important;
            padding-right: calc(1.5em + 0.75rem);
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right calc(0.375em + 0.1875rem) center;
            background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        }
        .is-invalid:focus {
            border-color: #dc3545;
            box-shadow: 0 0 0 0.2rem rgba(220, 53, 69, 0.25);
        }
        /* SweetAlert2 custom */
        .swal2-popup {
            font-size: 0.9rem;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <?= $this->include('layouts/header') ?>
    
    <?= $this->include('layouts/sidebar') ?>

    <!-- Content Wrapper -->
    <div class="content-wrapper" id="main-content">
        <?= $this->renderSection('content') ?>
    </div>

    <?= $this->include('layouts/footer') ?>

</div>

<!-- Loading Overlay -->
<div class="loading-overlay" id="loading-overlay">
    <div class="spinner-border-custom"></div>
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.7/js/dataTables.bootstrap4.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

<!-- SPA Navigation Script -->
<script>
// Prevent multiple initialization
if (typeof window.spaInitialized === 'undefined') {
    window.spaInitialized = true;
    
    $(document).ready(function() {
        // Check if SweetAlert2 is loaded
        if (typeof Swal !== 'undefined') {
            console.log('✓ SweetAlert2 loaded successfully');
        } else {
            console.error('✗ SweetAlert2 not loaded!');
        }
        
        // Base URL
        const baseUrl = '<?= base_url() ?>';
        
        // Handle navigation clicks - use .off() to prevent duplicate handlers
        $(document).off('click', 'a.spa-link').on('click', 'a.spa-link', function(e) {
            e.preventDefault();
            const url = $(this).attr('href');
            const title = $(this).data('title') || 'Page';
            loadPage(url, title);
        });

        // Load page via AJAX
        function loadPage(url, title) {
            // Show loading
            $('#main-content').addClass('loading');
            
            // Update active menu
            $('.nav-sidebar .nav-link').removeClass('active');
            $('a[href="' + url + '"]').addClass('active');
            
            $.ajax({
                url: url,
                type: 'GET',
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                },
                success: function(response) {
                    $('#main-content').html(response);
                    $('#page-title').text(title + ' | AdminLTE');
                    
                    // Update URL without reload
                    window.history.pushState({url: url, title: title}, title, url);
                    
                    // Remove loading
                    $('#main-content').removeClass('loading');
                    
                    // Reinitialize AdminLTE components
                    $('[data-widget="treeview"]').Treeview('init');
                },
                error: function(xhr) {
                    $('#main-content').removeClass('loading');
                    if (xhr.status === 401) {
                        window.location.href = baseUrl + '/login';
                    } else {
                        alert('Error loading page. Please try again.');
                    }
                }
            });
        }

        // Handle browser back/forward
        window.addEventListener('popstate', function(e) {
            if (e.state && e.state.url) {
                loadPage(e.state.url, e.state.title);
            }
        });

        // Handle form submissions via AJAX - use .off() to prevent duplicate handlers
        $(document).off('submit', 'form.ajax-form').on('submit', 'form.ajax-form', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const form = $(this);
            const url = form.attr('action');
            const method = form.attr('method') || 'POST';
            
            console.log('Form submitted:', url);
            
            // Validate required fields
            let isValid = true;
            let firstInvalidField = null;
            let emptyFields = [];
            
            form.find('[required]').each(function() {
                const field = $(this);
                const value = field.val();
                const fieldName = field.attr('name') || field.attr('id') || 'Field';
                
                if (!value || value.toString().trim() === '') {
                    isValid = false;
                    field.addClass('is-invalid');
                    emptyFields.push(fieldName);
                    
                    if (!firstInvalidField) {
                        firstInvalidField = field;
                    }
                } else {
                    field.removeClass('is-invalid');
                }
            });
            
            if (!isValid) {
                console.log('Validation failed. Empty fields:', emptyFields);
                
                // Check if Swal is loaded
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validasi Gagal',
                        text: 'Mohon lengkapi semua field yang wajib diisi!',
                        confirmButtonColor: '#3085d6',
                        confirmButtonText: 'OK'
                    });
                } else {
                    alert('Mohon lengkapi semua field yang wajib diisi!');
                }
                
                if (firstInvalidField) {
                    firstInvalidField.focus();
                }
                
                return false;
            }
            
            console.log('Validation passed. Submitting form...');
            
            const formData = new FormData(this);
            $('#loading-overlay').addClass('show');
            
            $.ajax({
                url: url,
                type: method,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    console.log('Success response:', response);
                    $('#loading-overlay').removeClass('show');
                    
                    if (response.success) {
                        // Close modal if exists
                        $('.modal').modal('hide');
                        
                        // Show success message with SweetAlert
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: response.message || 'Data berhasil disimpan',
                                timer: 2000,
                                showConfirmButton: false
                            });
                        } else {
                            alert(response.message || 'Data berhasil disimpan');
                        }
                        
                        // Reload DataTable if exists
                        if ($.fn.DataTable && $('.dataTable').length) {
                            $('.dataTable').DataTable().ajax.reload(null, false);
                        }
                        
                        // Reset form
                        form[0].reset();
                        form.find('.is-invalid').removeClass('is-invalid');
                    }
                },
                error: function(xhr) {
                    console.error('Error response:', xhr);
                    $('#loading-overlay').removeClass('show');
                    const response = xhr.responseJSON;
                    
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: response?.message || 'Terjadi kesalahan. Silakan coba lagi.',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        alert(response?.message || 'Terjadi kesalahan. Silakan coba lagi.');
                    }
                }
            });
        });
        
        // Remove invalid class on input - use .off() to prevent duplicate handlers
        $(document).off('input change', '.is-invalid').on('input change', '.is-invalid', function() {
            $(this).removeClass('is-invalid');
        });
        
        // Show alert function (legacy support)
        function showAlert(type, message) {
            const icon = type === 'danger' ? 'error' : type;
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: icon,
                    title: icon === 'success' ? 'Berhasil!' : 'Perhatian!',
                    text: message,
                    timer: 3000,
                    showConfirmButton: false
                });
            } else {
                alert(message);
            }
        }
    });
}
</script>

<?= $this->renderSection('scripts') ?>
</body>
</html>
