document.addEventListener('DOMContentLoaded', function () {
    let card = document.querySelectorAll('.openDetails');
    let contentDiv = document.querySelector('#detailInfo');

    // handle showing recipes
    card.forEach(element => {
        element.addEventListener('click', async function () {
            let id = element.getAttribute('data-id');
            let response = await fetch(`../html/recipeDetail.php/?id=${id}`).catch(function () {
                alert('Es ist ein Fehler aufgetreten. Laden Sie die Seite erneut.');
            });
            contentDiv.innerHTML = await response.text();
        });
    });

    // handle adding new recipes
    document.querySelector('#ingredientSelectElement').addEventListener('change', function () {
        console.log('unga bunga');
    });
});