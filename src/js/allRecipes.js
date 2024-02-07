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
    let selectElement = document.querySelector('.ingredientSelectElement');
    selectElement.addEventListener('change', async function () {
        let id = selectElement.value;
        let response = await fetch(`../html/ingredientSelectRow.php/?id=${id}`).catch(function () {
            alert('Es ist ein Fehler aufgetreten. Laden Sie die Seite erneut.');
        })

        document.querySelector(".targetIngredientRow").insertAdjacentHTML('beforebegin', await response.text());
    });

    // handle resetting modal
    document.querySelector('#resetRecipeAddModal').addEventListener('click', removeAllIngredients);
});

function removeAllIngredients() {
    document.querySelectorAll('.recipeIngredientRow').forEach(element => {
        element.remove();
    })
}