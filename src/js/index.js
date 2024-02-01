document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.sort-submit').forEach(element => {
        element.addEventListener('click', function () {
            let sort = element.getAttribute('data-sort');
            let order = element.getAttribute('data-order');

            document.querySelector('#sort-filter').value = sort;
            document.querySelector('#order-filter').value = order;
            document.querySelector('#main-table').submit();
        });
    });
    document.querySelectorAll('input').forEach(element => {
        element.addEventListener('keypress', function (event) {
            if (event.key === 'Enter') {
                document.querySelector('#main-table').submit();
            }
        })
    });
})