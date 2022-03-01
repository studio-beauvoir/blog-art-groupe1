function findCommentEl(numArt, numSeqCom) {
    const commentElData = document.querySelector(`data[value="comment-${numArt}-${numSeqCom}"`);
    return commentElData?commentElData.parentElement:false;
}

function setCommentData(commentEl, comment) {
    commentEl.querySelector('.comment-id').value = `comment-${comment.numArt}-${comment.numSeqCom}`;
    commentEl.querySelector('.comment-author').innerHTML = comment.pseudoMemb;
    commentEl.querySelector('.comment-created-at').innerText = `Créé le ${simpleDate(comment.dtCreCom)}`;
    commentEl.querySelector('.comment-modified-at').innerText = `Modifié le ${simpleDate(comment.dtModCom)}`;
    commentEl.querySelector('.comment-content').innerHTML = comment.libCom;

    commentEl.querySelector('.comment-action-like-count').innerText = ':n personne(s) aime(nt)'.singularise(comment.nblike || 0);
    setCommentLiked(commentEl, false);
}

function setCommentLiked(commentEl, liked) {
    commentEl.querySelector('.comment-action-like-btn.liked').classList.toggle('hidden', !liked);
    commentEl.querySelector('.comment-action-like-btn.like').classList.toggle('hidden', liked);
}

function addComment(comment) {
    const template = document.getElementById("template-comment");
    const commentEl = document.importNode(template.content, true);


    setCommentData(commentEl, comment);

    // actions
    commentEl.querySelector('.comment-action-like')
        .addEventListener('click', ()=>toggleLike(comment.numArt, comment.numSeqCom) );

    commentsEl.appendChild(commentEl);
}

function updateComment(comment) {
    const commentEl = findCommentEl(comment.numArt,comment.numSeqCom);
    
    setCommentData(commentEl, comment);
}

function updateCommentLike(comment) {
    const commentEl = findCommentEl(comment.numArt,comment.numSeqCom);
    
    setCommentLiked(commentEl, true);
}


function setCommentPlus(commentPlus) {
    const commentEl = findCommentEl(commentPlus.numArtR, commentPlus.numSeqComR);
    const commentPlusEl = findCommentEl(commentPlus.numArt, commentPlus.numSeqCom);
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
                fetchLikesMember();
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


function fetchLikesMember() {
    $.get( 
        urlFetchLikesMember,
        {},
        function(data) {
            console.log('e');
            if(!data.errors && data.result && data.result.likes) {
                for(const commentEl of document.querySelectorAll('.comment')) {
                    setCommentLiked(commentEl, false);
                }
                for(const like of data.result.likes) {
                    const commentEl = findCommentEl(like.numArt, like.numSeqCom);
                    setCommentLiked(commentEl, like['likeC']==='1');
                }
            }
        } 
    );
}

function toggleLike(numArt, numSeqCom) {
    const data = { 
        numArt,
        numSeqCom
    };

    $.post( 
        urlToggleLike,
        data,
        function(data) {
            if(!data.errors && data.result && data.result.comment) {                
                updateComment(data.result.comment);
                fetchLikesMember();
            }
        } 
    );
}