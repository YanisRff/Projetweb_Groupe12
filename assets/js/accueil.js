document.addEventListener('DOMContentLoaded', function() {
  test();
});

function test(){
  ajaxRequest('GET', './php/request.php/test', function (data) {
        let table = document.getElementById('zone-test');
        // clear existing table rows
        while (table.firstChild) {
            table.removeChild(table.firstChild);
        }

        // create table header
        let headerRow = document.createElement('tr');

        let headers = Object.keys(data[0]);
        headers.forEach(header => {
            let th = document.createElement('th');
            th.textContent = header;
            headerRow.appendChild(th);
        });
        table.appendChild(headerRow);

        // create table rows
        data.forEach(data => {
            let row = document.createElement('tr');
            Object.values(data).forEach(value => {
                let td = document.createElement('td');
                td.textContent = value;
                row.appendChild(td);
            });
            table.appendChild(row);
        });
    });
}
