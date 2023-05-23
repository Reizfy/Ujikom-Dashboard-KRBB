$(document).ready(function() {
    // Initialize DataTables
    $('#membersTable').DataTable({
        "paging": false, // Disable pagination as Laravel's pagination will be used
        "info": false, // Disable showing information about the table
        "searching": false, // Disable search feature as a separate search form is already provided
        "order": [], // Disable initial sorting
        "columnDefs": [
            { "orderable": false, "targets": -1 } // Disable sorting for the last column (actions)
        ],
        "language": {
            "emptyTable": "No members found",
            "zeroRecords": "No matching members found"
        }
    });

    // Live search functionality
    var dataTable = $('#membersTable').DataTable(); // Store the DataTable instance

    $('#searchInput').on('input', function() {
        dataTable.search(this.value).draw();
    });
});
