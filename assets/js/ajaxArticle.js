const langueSelect = document.getElementById('numLang');
const angleSelect = document.getElementById('numAngl');
const thematiqueSelect = document.getElementById('numThem');

function removeChilds(node) {
    while (node.firstChild) {
        node.removeChild(node.lastChild);
    }
}
function fetchLangAnglesAndKeywords() {
    
    const data = { 
        numLang: langueSelect.value
    };

    $.get( 
        urlFetchAnglAndThem,
        data,
        function(data) {
            if(data.errors || !data.result) return;            
                
            if(data.result.angles) {
                removeChilds(angleSelect);
                const angles = data.result.angles;
                for(let angle of angles) {
                    let optionEl = document.createElement('option');
                    optionEl.value = angle.numAngl;
                    optionEl.innerHTML = angle.libAngl;
                    angleSelect.appendChild(optionEl);
                }
            }

            if(data.result.thematiques) {
                removeChilds(thematiqueSelect);
                const thematiques = data.result.thematiques;
                for(let thematique of thematiques) {
                    let optionEl = document.createElement('option');
                    optionEl.value = thematique.numThem;
                    optionEl.innerHTML = thematique.libThem;
                    thematiqueSelect.appendChild(optionEl);
                }
            }
        } 
    );

}

fetchLangAnglesAndKeywords();
langueSelect.addEventListener('change', fetchLangAnglesAndKeywords);