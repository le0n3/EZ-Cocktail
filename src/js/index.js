document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('input').forEach(element => {
        element.addEventListener('keypress', function (event) {
            if (event.key === 'Enter') {
                document.querySelector('#main-table').submit();
            }
        })
    });
})