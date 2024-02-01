document.addEventListener('DOMContentLoaded', function () {
    // Handle sort buttons
    document.querySelectorAll('.sort-submit').forEach(element => {
        element.addEventListener('click', function () {
            let sort = element.getAttribute('data-sort');
            let order = element.getAttribute('data-order');

            document.querySelector('#sort-filter').value = sort;
            document.querySelector('#order-filter').value = order;
            document.querySelector('#main-table').submit();
        });
    });

    // handle search by Enter press
    document.querySelectorAll('input').forEach(element => {
        element.addEventListener('keypress', function (event) {
            if (event.key === 'Enter') {
                document.querySelector('#main-table').submit();
            }
        })
    });

    // handle modal popup
    document.querySelector('#addIngredient').addEventListener('click', async function () {
        let response = await fetch(`../html/ingredientModal.php`).catch(function () {
            alert('Ihre Session ist abgelaufen. Laden Sie die Seite erneut.');
        });
        document.querySelector('#detailInfo').innerHTML = await response.text();
    });
})