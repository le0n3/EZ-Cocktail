document.addEventListener('DOMContentLoaded', function () {
    let card = document.querySelectorAll('.openDetails');
    let contentDiv = document.querySelector('#detailInfo');

    card.forEach(element => {
        element.addEventListener('click', async function () {
            let id = element.getAttribute('data-id');
            let response = await fetch(`../html/recipeDetail.php/?id=${id}`).catch(function () {
                alert('Ihre Session ist abgelaufen. Laden Sie die Seite erneut.');
            });
            contentDiv.innerHTML = await response.text();
        });
    });
})