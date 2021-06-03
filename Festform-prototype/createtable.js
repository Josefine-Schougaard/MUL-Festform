//  Create shift table

// Data der skal vises i vagtskemaet, indskrives i dette array
const scheduleDataDraft = [
    {Title: 'Mandag',Times:['08 - 12','12 - 16']},
    {Title: 'Tirsdag',Times:['08 - 12','12 - 16','16 - 18']},
    {Title: 'Onsdag',Times:['08 - 12','12 - 16']}
]

// variabel til at lave tomme celler senere i createTable funktionen
const emptyTableCell = '<td>-</td>';

// Sætter korrekt antal rows op i tabellen.
const checkTable = (scheduleData) => {
    scheduleData.forEach(element => {
        const times = element.Times;
        let rowCount = document.querySelectorAll('.shift-table tbody tr').length;
        const timesCount = times.length;
        while (rowCount < timesCount){
            const trElemnt = '<tr></tr>';
            document.querySelector('.shift-table tbody').innerHTML += trElemnt;
            rowCount = document.querySelectorAll('.shift-table tbody tr').length;
        }
    });
};

// Toggler om en celle er selected
const scheduleClick = (cell) =>{
    cell.classList.toggle('isSelected');

}

// Tegner tabellen med data fra arrayet i toppen. Assigner event click til cellerne
const createTable = (scheduleData) => {
    checkTable(scheduleData);
    scheduleData.forEach(element => {
        const title = element.Title;
        const tdElement = '<td>'+title+'</td>';
        document.querySelector('.shift-table thead tr').innerHTML += tdElement;
        const times = element.Times; 
        const tableRows = document.querySelectorAll('.shift-table tbody tr');
        for(let i=0; i < tableRows.length; i++){
            const tableRow = tableRows[i];
            if(i < times.length){
                const time = times[i];
                tableRow.innerHTML += '<td data-day="'+title+'" class="clickable">'+time+'</td>';
            }
            else{
                tableRow.innerHTML += emptyTableCell;
            }
        }
    });
    document.querySelectorAll('.shift-table tbody tr td.clickable').forEach(cell => {
        cell.addEventListener('click', () => {
            scheduleClick(cell);
        });
    });
};

createTable(scheduleDataDraft);
