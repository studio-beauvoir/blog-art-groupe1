function getSelectionText() {
    var text = "";
    if (window.getSelection) {
        text = window.getSelection().toString();
    } else if (document.selection && document.selection.type != "Control") {
        text = document.selection.createRange().text;
    }
    return text;
}

function getSelectionHtml() {
    var html = "";
    if (typeof window.getSelection != "undefined") {
        var sel = window.getSelection();
        if (sel.rangeCount) {
            var container = document.createElement("div");
            for (var i = 0, len = sel.rangeCount; i < len; ++i) {
                container.appendChild(sel.getRangeAt(i).cloneContents());
            }
            html = container.innerHTML;
        }
    } else if (typeof document.selection != "undefined") {
        if (document.selection.type == "Text") {
            html = document.selection.createRange().htmlText;
        }
    }
    return html;
}

class bbEditor {
    constructor(input) {
        this.DOM = {
            input
        };

        this.actions = [
            {
                name: 'bold',
                title: 'Gras',
                element: 'span',
                bbElement: 'b',
                icon: `<path d="M5.10505 12C4.70805 12 4.4236 11.912 4.25171 11.736C4.0839 11.5559 4 11.2715 4 10.8827V4.11733C4 3.72033 4.08595 3.43588 4.25784 3.26398C4.43383 3.08799 4.71623 3 5.10505 3C6.42741 3 8.25591 3 9.02852 3C10.1373 3 11.0539 3.98153 11.0539 5.1846C11.0539 6.08501 10.6037 6.81855 9.70327 7.23602C10.8657 7.44851 11.5176 8.62787 11.5176 9.48128C11.5176 10.5125 10.9902 12 9.27734 12C8.77742 12 6.42626 12 5.10505 12ZM8.37891 8.00341H5.8V10.631H8.37891C8.9 10.631 9.6296 10.1211 9.6296 9.29877C9.6296 8.47643 8.9 8.00341 8.37891 8.00341ZM5.8 4.36903V6.69577H8.17969C8.53906 6.69577 9.27734 6.35939 9.27734 5.50002C9.27734 4.64064 8.48047 4.36903 8.17969 4.36903H5.8Z" fill="currentColor"></path>`
            },
            {
                name: 'heading',
                title: 'Titre',
                element: 'span',
                bbElement: 'heading',
                icon: `<path d="M8.75432 2.0502C8.50579 2.0502 8.30432 2.25167 8.30432 2.5002C8.30432 2.74873 8.50579 2.9502 8.75432 2.9502H9.94997V7.05004H5.04997V2.9502H6.25432C6.50285 2.9502 6.70432 2.74873 6.70432 2.5002C6.70432 2.25167 6.50285 2.0502 6.25432 2.0502H2.75432C2.50579 2.0502 2.30432 2.25167 2.30432 2.5002C2.30432 2.74873 2.50579 2.9502 2.75432 2.9502H3.94997V12.0502H2.75432C2.50579 12.0502 2.30432 12.2517 2.30432 12.5002C2.30432 12.7487 2.50579 12.9502 2.75432 12.9502H6.25432C6.50285 12.9502 6.70432 12.7487 6.70432 12.5002C6.70432 12.2517 6.50285 12.0502 6.25432 12.0502H5.04997V7.95004H9.94997V12.0502H8.75432C8.50579 12.0502 8.30432 12.2517 8.30432 12.5002C8.30432 12.7487 8.50579 12.9502 8.75432 12.9502H12.2543C12.5028 12.9502 12.7043 12.7487 12.7043 12.5002C12.7043 12.2517 12.5028 12.0502 12.2543 12.0502H11.05V2.9502H12.2543C12.5028 2.9502 12.7043 2.74873 12.7043 2.5002C12.7043 2.25167 12.5028 2.0502 12.2543 2.0502H8.75432Z" fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"></path>`
            },
            {
                name: 'clear',
                title: 'Effacer le formatage',
                element: 'span',
                icon: `<path d="M13.3536 2.35355C13.5488 2.15829 13.5488 1.84171 13.3536 1.64645C13.1583 1.45118 12.8417 1.45118 12.6464 1.64645L11.9291 2.36383C11.9159 2.32246 11.897 2.28368 11.8732 2.24845C11.7923 2.12875 11.6554 2.05005 11.5001 2.05005H3.50005C3.29909 2.05005 3.1289 2.18178 3.07111 2.3636C3.05743 2.40665 3.05005 2.45249 3.05005 2.50007V4.50001C3.05005 4.74854 3.25152 4.95001 3.50005 4.95001C3.74858 4.95001 3.95005 4.74854 3.95005 4.50001V2.95005H6.95006V7.34284L1.64645 12.6464C1.45118 12.8417 1.45118 13.1583 1.64645 13.3536C1.84171 13.5488 2.15829 13.5488 2.35355 13.3536L6.95006 8.75705V12.0501H5.7544C5.50587 12.0501 5.3044 12.2515 5.3044 12.5001C5.3044 12.7486 5.50587 12.9501 5.7544 12.9501H9.2544C9.50293 12.9501 9.7044 12.7486 9.7044 12.5001C9.7044 12.2515 9.50293 12.0501 9.2544 12.0501H8.05006V7.65705L13.3536 2.35355ZM8.05006 6.24284L11.0501 3.24283V2.95005H8.05006V6.24284Z" fill="currentColor" fill-rule="evenodd" clip-rule="evenodd"></path>`
            }
        ]
        return this;
    }


    createDOM() {
        this.DOM.container = document.createElement('div');
        this.DOM.container.classList.add('bbeditor');
        this.DOM.container.classList.add('bb-container');
        this.DOM.input.after(this.DOM.container);
        this.DOM.container.appendChild(this.DOM.input);

        this.createDOMActions();

        this.DOM.editor = document.createElement('div');
        this.DOM.editor.classList.add('bbeditor');
        this.DOM.editor.classList.add('bb-editor');
        this.DOM.editor.setAttribute('contenteditable', 'true');
        this.DOM.container.appendChild(this.DOM.editor);

        this.DOM.editor.addEventListener('keyup', e=>{
            this.stringifyContent();
        })

        this.parseValue();
        return this;
    }

    createDOMActions() {
        this.DOM.actions = document.createElement('div');
        this.DOM.actions.classList.add('bb-actions');
        this.DOM.container.appendChild(this.DOM.actions);

        for(let action of this.actions) {
            this.createDOMAction(action);
        }
    }

    createDOMAction(action) {
        let actionEl = document.createElement('button');
        actionEl.classList.add('bb-action');
        actionEl.classList.add(`bb-action-${action.name}`);
        actionEl.title=action.title;
        actionEl.innerHTML = `<svg width="20" height="20" viewBox="0 0 15 15" fill="none" xmlns="http://www.w3.org/2000/svg">${action.icon}</svg>`
        actionEl.addEventListener('click', e=>{
            e.preventDefault();
            this.handleAction(action, e);
        })
        this.DOM.actions.appendChild(actionEl);
    }

    handleAction(action) {
        const selection = window.getSelection();
        const range = selection.getRangeAt(0);
        console.log(selection);
        console.log(range);

        // on save la sélection avant de modifier le dom
        const selectionText = selection.toString();

        if(!this.DOM.editor.isEqualNode(range.startContainer.parentElement.parentElement)) return;


        
        if(!range.startContainer.isEqualNode(range.endContainer)) {
            // cas où la sélection prend plusieurs éléments

            // récupération des index pour la suppression future de anciens éléments
            const elementsArray = Array.from(this.DOM.editor.children);
            const startContainerIndex = elementsArray.indexOf(range.startContainer.parentElement);
            const endContainerIndex = elementsArray.indexOf(range.endContainer.parentElement);

            // ajout de la sélection
            const newElement = document.createElement(action.element);
            newElement.classList.add(`bb-element`);
            newElement.classList.add(`bb-element-${action.name}`);
            newElement.innerText = selectionText;

            range.startContainer.parentElement.after(newElement);


            // coupure du premier élément
            range.startContainer.parentElement.innerText = range.startContainer.parentElement.innerText.substring(0, range.startOffset);

            // coupure du dernier élément
            range.endContainer.parentElement.innerText = range.endContainer.parentElement.innerText.substring(range.endOffset);

            // suppression des anciens éléments
            for(let i=startContainerIndex+1; i<endContainerIndex; i++) {
                console.log(elementsArray[i], i);
                elementsArray[i].remove();
            }
            selection.removeAllRanges();

            // sélection du text formaté
            selection.removeAllRanges();
            const newRange = document.createRange();
            newRange.selectNodeContents(newElement);
            selection.addRange(newRange);
        } else {
            // cas inverse :
            // la sélection prend un seul élément

            if (range.startContainer.parentElement.classList.contains(`bb-element-${action.name}`)) 
            {
                // la sélection est déjà formatée
                // on la dé-formate
                const replacement = document.createElement('span');
                replacement.innerText = range.startContainer.parentElement.innerText;
                this.DOM.editor.replaceChild(replacement, range.startContainer.parentElement);
                selection.removeAllRanges();
            }
            else
            {
                // cas inverse :
                // la sélection n'est pas encore formatée

                const startOffset = range.startOffset;
                const endOffset = range.endOffset;

                // coupure de l'élément
                const newEndContainer = range.startContainer.parentElement.cloneNode(true);
                console.log(newEndContainer);
                range.startContainer.parentElement.after(newEndContainer);

                range.startContainer.parentElement.innerText = range.startContainer.parentElement.innerText.substring(0, startOffset);
                newEndContainer.innerText = newEndContainer.innerText.substring(endOffset);

                // ajout de la sélection
                const newElement = document.createElement(action.element);
                newElement.classList.add(`bb-element`);
                newElement.classList.add(`bb-element-${action.name}`);
                newElement.innerText = selectionText;

                console.log(range.startContainer);
                range.startContainer.after(newElement);

                // sélection du text formaté
                selection.removeAllRanges();
                const newRange = document.createRange();
                newRange.selectNodeContents(newElement);
                selection.addRange(newRange);
            }
        }
        this.stringifyContent();
    }

    stringifyContent() {
        var content = "";
        const actionsWithBBEl = this.actions.filter(action=>action.bbElement!==undefined);
 
        for(let part of this.DOM.editor.children) {
            // nettoyage des balises vides
            if(part.innerText=="") {
                part.remove();
                continue;
            }

            let contentBefore = "";
            let contentAfter = "";
            for(let action of actionsWithBBEl) {
                if (part.classList.contains(`bb-element-${action.name}`)) {
                    contentBefore = `[${action.bbElement}]`;
                    contentAfter = `[/${action.bbElement}]`;
                    break;
                }
            }
            content += contentBefore+part.innerText+contentAfter;
        }
        this.DOM.input.value = content;
    }

    parseValue() {
        let value = `<span>${this.DOM.input.value}</span>`;
        for(let action of this.actions) {
            if(action.element) {
                // ouverture de la balise
                value = value.replace(new RegExp(`\\[${action.bbElement}\\]`), `</span><${action.element} class="bb-element bb-element-${action.name}">`);

                // fermeture de la balise
                value = value.replace(new RegExp(`\\[\\/${action.bbElement}\\]`), `</${action.element}><span>`);
            }
        }
        this.DOM.editor.innerHTML = value;
    }
}


window.addEventListener('DOMContentLoaded', function() {
    const editorEls = document.querySelectorAll('input[type="hidden"][bbeditor]');
    const editors = [];
    for(let editorEl of editorEls) {
        let editor = new bbEditor(editorEl);
        editors.push(
            editor.createDOM()
        );
    }
});