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



const keywordInput = document.getElementById('keywords');
const keywordEl = document.getElementById('keywords-control');
const keywordSelectedEl = document.getElementById('keywords-selected');
const keywordAvailablesEl = document.getElementById('keywords-availables');

const oldKeywordInput = document.getElementById('oldKeywords');
var keywordsSelected = JSON.parse(oldKeywordInput.value);

function getNewKeywordEl(keyword) {
    const keywordEl = document.createElement('button');
    keywordEl.classList.add('keywordChips');
    keywordEl.innerHTML = keyword.libMotCle;
    keywordEl.dataset.numMotCle = keyword.numMotCle;

    return keywordEl;
}

function computeKeywordsInput() {
    let keywordsArray = [];
    for(let keywordEl of keywordSelectedEl.children) {
        keywordsArray.push(parseInt(keywordEl.dataset.numMotCle));
    }
    keywordInput.value = JSON.stringify(keywordsArray.sort());
}

function toggleState(keywordEl) {
    let isSelected = keywordEl.parentElement.id === keywordSelectedEl.id;
    keywordEl.classList.toggle('available', isSelected);
    keywordEl.classList.toggle('selected', !isSelected);

    if(isSelected) {
        keywordAvailablesEl.appendChild(keywordEl);
    } else {
        keywordSelectedEl.appendChild(keywordEl);
    }
}


function fetchMotsCles() {
    
    const data = { 
        numLang: langueSelect.value
    };

    $.get( 
        urlFetchMotsCles,
        data,
        function(data) {
            if(data.errors || !data.result) return;            
                
            if(data.result.motscles) {
                removeChilds(keywordAvailablesEl);
                removeChilds(keywordSelectedEl);
                // removeChilds(angleSelect);
                const motscles = data.result.motscles;
                for(let motcle of motscles) {
                    let el = getNewKeywordEl(motcle);
                    el.addEventListener('click', e=>{
                        e.preventDefault();
                        toggleState(e.target);
                        computeKeywordsInput();
                    });

                    if(keywordsSelected.includes(parseInt(motcle.numMotCle))) {
                        el.classList.add('selected');
                        keywordSelectedEl.appendChild(el);
                    } else {
                        el.classList.add('available');
                        keywordAvailablesEl.appendChild(el);
                    }
                }
                computeKeywordsInput();
            }
        } 
    );

}

