</div>
<!-- Link ke file Popper -->
<script src="https://unpkg.com/@popperjs/core@2"></script>
<!-- Link ke file JavaScript jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<!-- Link ke file Bootstrap Datepicker jQuery -->
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/js/bootstrap-datepicker.min.js"></script>
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.10.0/locales/bootstrap-datepicker.id.min.js"></script>
<!-- Link ke file JavaScript DataTables -->
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
    crossorigin="anonymous"></script>
<script>
    // Wait for the HTML document to finish loading
    $(document).ready(function () {
        // Initialize the DataTables plugin on the table with id "myTable"
        $('#myTable').DataTable({
            order: [[3, 'desc'], [4, 'desc']],
            orderCellsTop: true
        });
    });
</script>
<!-- tableUserAdmin -->
<script>
    // Wait for the HTML document to finish loading
    $(document).ready(function () {
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