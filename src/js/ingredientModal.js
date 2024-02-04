document.addEventListener("DOMContentLoaded", function(){
    var btn = document.querySelector('.btn-primary');
    btn.addEventListener('click', sendData);
});

function sendData() {
    var zutat = document.querySelector('#Zutat').value;
    var menge = document.querySelector('#Menge').value;
    var einheitKürzel = document.querySelector('#EinheitKürzel').value;
    var einheit = document.querySelector('#Einheit').value;
    var typ = document.querySelector('#Typ').value;
    var beschreibung = document.querySelector('#Beschreibung').value;

    var data = 'Zutat=' + zutat
        + '&Menge=' + menge
        + '&EinheitKürzel=' + einheitKürzel
        + '&Einheit=' + einheit
        + '&Typ=' + typ
        + '&Beschreibung=' + beschreibung;

    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'ManipulateIngredient.php', true);
    xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');

    xhr.onload = function(){
        if(xhr.status == 200){
            alert('Daten erfolgreich gespeichert');
        } else {
            alert('An error occurred: ' + xhr.status);
        }
    }

    xhr.onerror = function(){
        alert('An error occurred');
    }

    xhr.send(data);
}