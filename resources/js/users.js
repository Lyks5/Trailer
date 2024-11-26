document.addEventListener('DOMContentLoaded', () => {
    const searchInput = document.getElementById('search');
    const sortByNameBtn = document.getElementById('sortByName');
    const sortByEmailBtn = document.getElementById('sortByEmail');
    const showBlockedBtn = document.getElementById('showBlocked');
    const rows = document.querySelectorAll('tbody tr');

    searchInput.addEventListener('input', () => filterRows(searchInput.value.toLowerCase()));
    sortByNameBtn.addEventListener('click', () => sortTable(1));
    sortByEmailBtn.addEventListener('click', () => sortTable(2));
    showBlockedBtn.addEventListener('click', toggleBlocked);

    function filterRows(query) {
        rows.forEach(row => {
            const name = row.children[1].textContent.toLowerCase();
            const email = row.children[2].textContent.toLowerCase();
            const id = row.children[0].textContent.toLowerCase();
            row.style.display = name.includes(query) || email.includes(query) || id.includes(query) ? '' : 'none';
        });
    }

    function sortTable(column) {
        const rowsArray = Array.from(rows).sort((a, b) => {
            const aText = a.children[column].textContent.toLowerCase();
            const bText = b.children[column].textContent.toLowerCase();
            return aText.localeCompare(bText);
        });
        const tbody = document.querySelector('tbody');
        rowsArray.forEach(row => tbody.appendChild(row));
    }

    let showBlocked = false;

    function toggleBlocked() {
        showBlocked = !showBlocked;
        showBlockedBtn.textContent = showBlocked ? 'Показать все' : 'Показать заблокированных';
        showBlockedBtn.classList.toggle('bg-blue-500', showBlocked);
        showBlockedBtn.classList.toggle('bg-red-500', !showBlocked);

        rows.forEach(row => {
            const blocked = row.children[3].textContent.toLowerCase().includes('заблокирован');
            row.style.display = showBlocked ? (blocked ? '' : 'none') : '';
        });
    }
});