window.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('a').forEach(el=>{
        if(el.innerText.toLowerCase() === 'annuler') {
            el.addEventListener('click', function(e) {
                e.preventDefault();
                history.back();
            })
        }
    })
})