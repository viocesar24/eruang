</div>
<!-- Link ke file Popper -->
<script src="https://unpkg.com/@popperjs/core@2"></script>
<!-- Link ke file JavaScript jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<!-- Link ke file Bootstrap Datepicker jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/locales/bootstrap-datepicker.id.min.js"></script>
<!-- Link ke file JavaScript DataTables -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
<script>
    // Wait for the HTML document to finish loading
    $(document).ready(function() {
        // Inisialisasi DataTables
        var table = $('#myTable').DataTable({
            order: [
                [3, 'desc'],
                [4, 'desc']
            ],
            orderCellsTop: true
        });

        // Inisialisasi Bootstrap Datepicker
        $('.datepicker').datepicker({
            format: 'dd/mm/yyyy',
            autoclose: true,
            todayHighlight: true,
            language: 'id'
        });

        // Fungsi untuk filter berdasarkan rentang tanggal
        $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
            var minDate = $('#minDate').datepicker("getDate");
            var maxDate = $('#maxDate').datepicker("getDate");
            var startDate = new Date(data[3] || 0); // Menggunakan indeks kolom tanggal dari tabel Anda

            if (
                (minDate === null && maxDate === null) ||
                (minDate === null && startDate <= maxDate) ||
                (minDate <= startDate && maxDate === null) ||
                (minDate <= startDate && startDate <= maxDate)
            ) {
                return true;
            }
            return false;
        });

        // Event listener untuk perubahan nilai datepicker
        $('#minDate, #maxDate').change(function() {
            table.draw();
        });
    });
</script>
<!-- tableUserAdmin -->
<script>
    // Wait for the HTML document to finish loading
    $(document).ready(function() {
        // Initialize the DataTables plugin on the table with id "myTable"
        $('#tableUserAdmin').DataTable({
            order: [0, 'asc'],
            orderCellsTop: true
        });
    });
</script>
<script>
    function addActiveClass() {
        // Get the current URL.
        const currentUrl = window.location.href;

        // Get all of the <a> tags in the document.
        const aTags = document.querySelectorAll('a');

        // Iterate over the <a> tags.
        for (const aTag of aTags) {
            // If the href attribute of the <a> tag matches the current URL, add the 'active' class to it.
            if (aTag.href === currentUrl) {
                aTag.classList.add('active');
            }
        }
    }
    // Add the 'active' class to the <a> tag when the page loads.
    window.addEventListener('load', addActiveClass);
</script>
<script>
    $('.tanggal_peminjaman').datepicker({
        format: 'yyyy-mm-dd',
        daysOfWeekDisabled: [0, 6],
        startDate: '0d'
    });
</script>
<script>
    document.querySelectorAll('input[id="tanggal_peminjaman"]').forEach(input => {
        input.addEventListener('keydown', e => {
            e.preventDefault();
        });
    });
</script>
</body>

</html>