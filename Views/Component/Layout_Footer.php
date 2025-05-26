        </div>

        <footer class="main-footer">
            <strong>Copyright &copy; 2014-2021 <a href="https://adminlte.io">AdminLTE.io</a>.</strong>
            All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <b>Version</b> 3.2.0
            </div>
        </footer>
    </div>

    <!-- jQuery -->
    <script src="<?= BASE_URL ?>Public/Assets/plugins/jquery/jquery.min.js"></script>
    <!-- jQuery UI 1.11.4 -->
    <script src="<?= BASE_URL ?>Public/Assets/plugins/jquery-ui/jquery-ui.min.js"></script>
    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button)
    </script>
    <!-- Bootstrap 4 -->
    <script src="<?= BASE_URL ?>Public/Assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
    <!-- DataTables  & Plugins -->
    <script src="<?= BASE_URL ?>Public/Assets/plugins/datatables/jquery.dataTables.min.js"></script>
    <script src="<?= BASE_URL ?>Public/Assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= BASE_URL ?>Public/Assets/plugins/datatables-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= BASE_URL ?>Public/Assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js"></script>
    <script src="<?= BASE_URL ?>Public/Assets/plugins/datatables-buttons/js/dataTables.buttons.min.js"></script>
    <script src="<?= BASE_URL ?>Public/Assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js"></script>
    <script src="<?= BASE_URL ?>Public/Assets/plugins/jszip/jszip.min.js"></script>
    <script src="<?= BASE_URL ?>Public/Assets/plugins/pdfmake/pdfmake.min.js"></script>
    <script src="<?= BASE_URL ?>Public/Assets/plugins/pdfmake/vfs_fonts.js"></script>
    <script src="<?= BASE_URL ?>Public/Assets/plugins/datatables-buttons/js/buttons.html5.min.js"></script>
    <script src="<?= BASE_URL ?>Public/Assets/plugins/datatables-buttons/js/buttons.print.min.js"></script>
    <script src="<?= BASE_URL ?>Public/Assets/plugins/datatables-buttons/js/buttons.colVis.min.js"></script>
    <!-- Bootstrap4 Duallistbox -->
    <script src="<?= BASE_URL ?>Public/Assets/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js"></script>
    <!-- InputMask -->
    <script src="<?= BASE_URL ?>Public/Assets/plugins/moment/moment.min.js"></script>
    <script src="<?= BASE_URL ?>Public/Assets/plugins/inputmask/jquery.inputmask.min.js"></script>
    <!-- date-range-picker -->
    <script src="<?= BASE_URL ?>Public/Assets/plugins/daterangepicker/daterangepicker.js"></script>
    <!-- Tempusdominus Bootstrap 4 -->
    <script src="<?= BASE_URL ?>Public/Assets/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
    <!-- bs-custom-file-input -->
    <script src="<?= BASE_URL ?>Public/Assets/plugins/bs-custom-file-input/bs-custom-file-input.min.js"></script>
    <!-- AdminLTE App -->
    <script src="<?= BASE_URL ?>Public/Assets/dist/js/adminlte.js"></script>
    <!-- Toastr -->
    <script src="<?= BASE_URL ?>Public/Assets/plugins/toastr/toastr.min.js"></script>
    <?php if (isset($_SESSION['toast'])): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                $(document).Toasts('create', {
                    class: 'bg-<?= $_SESSION['toast']['type'] ?>',
                    title: '<?= $_SESSION['toast']['title'] ?>',
                    subtitle: '<?= $_SESSION['toast']['subtitle'] ?>',
                    body: '<?= $_SESSION['toast']['body'] ?>'
                });
            });
        </script>
        <?php unset($_SESSION['toast']); ?>
    <?php endif; ?>
    <script>
        $(function () {
            bsCustomFileInput.init();
        });
        $('#tanggal-penitipan').datetimepicker({
            icons: { time: 'far fa-clock' },
            format: 'YYYY-MM-DD HH:mm:ss'
        });
        $('#tanggal-pengambilan').datetimepicker({
            icons: { time: 'far fa-clock' },
            format: 'YYYY-MM-DD HH:mm:ss'
        });

        $(function () {
            $('#data-user').DataTable({
                "paging": true,
                "lengthChange": true,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
            });
        });

        document.addEventListener("DOMContentLoaded", function () {
            let barangWrapper = document.getElementById("barang-wrapper");
            let addBtn = document.getElementById("add-barang");
            let form = document.querySelector("form");

            function updateTotalBerat() {
                let total = 0;

                document.querySelectorAll(".berat-barang").forEach(input => {
                    let berat = parseFloat(input.value) || 0;
                    total += berat;
                });

                document.getElementById("total-berat").value = total.toFixed(2);
                updateLokerStatus(total);
            }

            addBtn.addEventListener("click", function () {
                let item = document.querySelector(".barang-item").cloneNode(true);
                item.querySelectorAll("input, select, textarea").forEach(el => el.value = "");
                barangWrapper.appendChild(item);
                bindRemoveEvents();
            });

            function bindRemoveEvents() {
                document.querySelectorAll(".remove-barang").forEach(btn => {
                    btn.onclick = function () {
                        if (document.querySelectorAll(".barang-item").length > 1) {
                            btn.closest(".barang-item").remove();
                            updateTotalBerat();
                        }
                    }
                });
            }

            // Update total when berat changes
            barangWrapper.addEventListener("input", function (e) {
                if (e.target.classList.contains("berat-barang")) {
                    updateTotalBerat();
                }
            });

            function updateLokerStatus(totalBerat) {
                document.querySelectorAll(".card-loker").forEach(card => {
                    let kapasitas = parseFloat(card.dataset.kapasitas);
                    if (kapasitas < totalBerat) {
                        card.classList.add("bg-danger", "text-white");
                        card.classList.remove("bg-success");
                    } else {
                        card.classList.remove("bg-danger");
                    }
                });
            }

            bindRemoveEvents();
            updateTotalBerat();

            // Tambahkan event listener untuk validasi sebelum submit
            form.addEventListener("submit", function(e) {
                let idLoker = document.getElementById('id_loker').value;
                if (!idLoker) {
                    e.preventDefault(); // cegah submit form

                    // Tampilkan toast peringatan
                    $(document).Toasts('create', {
                        class: 'bg-warning',
                        title: 'Validasi Form',
                        body: 'Silakan pilih nomor loker sebelum mengirim data.'
                    });
                }
            });
        });

        function selectLoker(el) {
            const status = el.getAttribute('data-status');
            const kapasitas = parseFloat(el.getAttribute('data-kapasitas'));
            const totalBerat = parseFloat(document.getElementById('total-berat').value) || 0;

            if (status === 'booked') {
                $(document).Toasts('create', {
                    class: 'bg-warning',
                    title: 'Tempat Penyimpanan',
                    body: 'Loker tersebut sudah diisi.'
                });
                return;
            }

            if (totalBerat > kapasitas) {
                $(document).Toasts('create', {
                    class: 'bg-danger',
                    title: 'Kapasitas Melebihi',
                    body: `Total berat (${totalBerat} kg) melebihi kapasitas loker (${kapasitas} kg).`
                });
                return;
            }

            const isSelected = el.classList.contains('bg-success');

            if (isSelected) {
                el.classList.remove('bg-success');
                el.classList.add('bg-secondary');

                document.getElementById('id_loker').value = '';
                document.getElementById('nomor_loker').value = '';

                return;
            }

            // Reset semua loker kecuali yang booked
            document.querySelectorAll('.card-loker').forEach(card => {
                if (card.getAttribute('data-status') === 'kosong') {
                    card.classList.remove('bg-success');
                    card.classList.add('bg-secondary');
                }
            });

            // Tandai loker baru sebagai dipilih
            el.classList.remove('bg-secondary');
            el.classList.add('bg-success');

            // Set input hidden
            document.getElementById('id_loker').value = el.getAttribute('data-id');
            document.getElementById('nomor_loker').value = el.getAttribute('data-nomor');
        }
    </script>
</body>
</html>
