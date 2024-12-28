document.getElementById('logSearch').addEventListener('input', function() {
    filterLogs();
});

document.getElementById('logFilter').addEventListener('change', function() {
    filterLogs();
});

function filterLogs() {
    const searchQuery = document.getElementById('logSearch').value.toLowerCase();
    const filterValue = document.getElementById('logFilter').value;
    const tableRows = document.querySelectorAll('#logTableBody tr');

    tableRows.forEach(row => {
        const logType = row.cells[1].innerText.toLowerCase();
        const logMessage = row.cells[2].innerText.toLowerCase();

        const matchesSearch = logMessage.includes(searchQuery);
        const matchesFilter = filterValue === '' || logType.includes(filterValue);

        if (matchesSearch && matchesFilter) {
            row.style.display = '';
        } else {
            row.style.display = 'none';
        }
    });
}
