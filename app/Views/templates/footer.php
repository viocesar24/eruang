</div>
<!-- Link ke file JavaScript jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
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
            order: [[4, 'desc'], [5, 'desc']],
            orderCellsTop: true
        });
    });
</script>
</body>

</html>