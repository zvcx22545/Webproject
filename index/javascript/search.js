document.addEventListener('DOMContentLoaded', function () {

    function filterTableRows(searchInputId, tableId, cellIndex) {
        var searchQuery = document.getElementById(searchInputId).value.toLowerCase();
        var tableRows = document.getElementById(tableId).getElementsByTagName('tbody')[0].getElementsByTagName('tr');

        for (var i = 0; i < tableRows.length; i++) {
            var currentRow = tableRows[i];
            var cellContent = currentRow.cells[cellIndex].textContent.toLowerCase() || currentRow.cells[cellIndex].innerText.toLowerCase();
            if (cellContent.includes(searchQuery)) {
                currentRow.style.display = '';
            } else {
                currentRow.style.display = 'none';
            }
        }
    }

    var searchInput1 = document.querySelector('#searchInput1');
    var searchInput = document.querySelector('#searchInput');

    if (searchInput1) {
        searchInput1.addEventListener('input', function () {
            filterTableRows('searchInput1', 'tableCom', 0); 
            filterTableRows('searchInput1', 'resultsTable', 0);
        });
    }

    if (searchInput) {
        searchInput.addEventListener('input', function () {
            filterTableRows('searchInput', 'teamTable', 1);
        });
    }

  	const table = document.getElementById('teamTable');
    const rowCount = table.getElementsByTagName('tr').length - 1; // Subtract 1 for excluding the header row
    document.getElementById('rowCount').textContent = rowCount;
  
});
