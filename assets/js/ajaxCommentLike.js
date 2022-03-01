function findCommentEl(numSeqCom, numArt) {
    const commentElData = document.querySelector(`data[value="comment-${numSeqCom}-${numArt}"`);
    return commentElData?commentElData.parentElement:false;
}

function addComment(comment) {
    const template = document.getElementById("template-comment");
    const commentEl = document.importNode(template.content, true);


    commentEl.querySelector('.comment-id').value = `comment-${comment.numSeqCom}-${comment.numArt}`;
    commentEl.querySelector('.comment-author').innerHTML = comment.pseudoMemb;
    commentEl.querySelector('.comment-action-likesCount').innerText = ':n personne(s) aime(nt)'.singularise(comment.nblike);
    commentEl.querySelector('.comment-created-at').innerText = `Créé le ${simpleDate(comment.dtCreCom)}`;
    commentEl.querySelector('.comment-modified-at').innerText = `Modifié le ${simpleDate(comment.dtModCom)}`;
    commentEl.querySelector('.comment-content').innerHTML = comment.libCom;

    commentsEl.appendChild(commentEl);
}

function updateComment(comment) {
    const commentElData = document.querySelector(`data[value="comment-${comment.numSeqCom}-${comment.numArt}"`);
    const commentEl = commentElData.parentElement;

    commentEl.querySelector('.comment-author').innerHTML = comment.pseudoMemb;
    commentEl.querySelector('.comment-created-at').innerText = `Créé le ${comment.dtCreCom}`;
    commentEl.querySelector('.comment-modified-at').innerText = `Modifié le ${comment.dtModCom}`;
    commentEl.querySelector('.comment-content').innerHTML = comment.libCom;
}

function setCommentPlus(commentPlus) {
    const commentEl = findCommentEl(commentPlus.numSeqComR, commentPlus.numArtR);
    const commentPlusEl = findCommentEl(commentPlus.numSeqCom, commentPlus.numArt);
    if(!commentEl || !commentPlusEl) return;

    commentEl.querySelector('.comment-answers').appendChild(commentPlusEl);
}

function fetchComments() {
    const data = { 
        numArt,
    };

    $.get( 
        urlFetchComment,
        data,
        function(data) {
            if(!data.errors && data.result && data.result.comments) {
                removeChilds(commentsEl);

                for(const comment of data.result.comments) {
                    addComment(comment);
                }

                fetchCommentsPlus();
            }
        } 
    );

}





function fetchCommentsPlus() {
    const data = { 
        numArt,
    };

    $.get( 
        urlFetchCommentPlus,
        data,
        function(data) {
            if(!data.errors && data.result && data.result.commentsplus) {
                for(const commentPlus of data.result.commentsplus) {
                    setCommentPlus(commentPlus);
                }
            }
        } 
    );
}


function postComment() {
    const data = { 
        numArt,
        libCom: formCommentTextArea.value
    };
    if(data.libCom.trim().length === 0) {
        formCommentTextArea.value = "";
        return;
    }

    $.post( 
        urlPostComment,
        data,
        function(data) {
            if(data.errors || !data.result) return;            
                
            formCommentTextArea.value = "";
            fetchComments();
        } 
    );
}