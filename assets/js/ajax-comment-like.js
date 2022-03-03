function findCommentEl(numArt, numSeqCom) {
    const commentElData = document.querySelector(`data[value="comment-${numArt}-${numSeqCom}"`);
    return commentElData?commentElData.parentElement:false;
}

function setCommentData(commentEl, comment) {
    commentEl.querySelector('.comment-id').value = `comment-${comment.numArt}-${comment.numSeqCom}`;
    commentEl.querySelector('.comment-author').innerHTML = comment.pseudoMemb;
    commentEl.querySelector('.comment-created-at').innerText = `Créé le ${simpleDate(comment.dtCreCom)}`;
    commentEl.querySelector('.comment-modified-at').innerText = `Modifié le ${simpleDate(comment.dtModCom)}`;
    commentEl.querySelector('.comment-content').innerHTML = comment.libCom.replace(/^(@\S+):/, '<span class="mention">Réponse à  $1</span><br/>');

    let likeCount = commentEl.querySelector('.comment-action-like-count');
    if(likeCount) likeCount.innerText = ':n personne(s) aime(nt)'.singularise(comment.nblike || 0);
    setCommentLiked(commentEl, false);
}

function setCommentLiked(commentEl, liked) {
    let commentActions = commentEl.querySelector('.comment-actions');
    if(commentActions) {
        commentEl.querySelector('.comment-action-like-icon.liked').classList.toggle('hidden', !liked);
        commentEl.querySelector('.comment-action-like-icon.like').classList.toggle('hidden', liked);
    }
}

function addComment(comment) {
    const template = document.getElementById("template-comment");
    const commentEl = document.importNode(template.content, true);


    setCommentData(commentEl, comment);

    // actions
    let commentActions = commentEl.querySelector('.comment-actions');
    if(commentActions) {
        console.log(commentEl.querySelector('.comment-action-answer'));
        commentEl.querySelector('.comment-action-answer').addEventListener('click', ()=>openFormAnswer(comment.numArt, comment.numSeqCom) );
        commentEl.querySelector('.comment-action-like').addEventListener('click', ()=>toggleLikeCom(comment.numArt, comment.numSeqCom) );
    }

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

function openFormAnswer(numArt, numSeqCom) {
    if(!formCommentAnswer.classList.contains('hidden')) {
        hideFormCommentAnswer();
        return;
    }
    const commentEl = findCommentEl(numArt, numSeqCom);
    commentEl.querySelector('.comment-actions').after(formCommentAnswer);

    // pseudo de l'auteur du commentaire auquel on répond
    const pseudoMemberOfCommentEl = commentEl.querySelector('.comment-author').innerText;

    formCommentAnswer.querySelector('.form-comment-title').innerText = `Répondre à ${pseudoMemberOfCommentEl}`;
    // formCommentAnswer.querySelector('.form-comment-textarea').value = `@${pseudoMemberOfCommentEl} `;
    formCommentAnswer.querySelector('.form-comment-textarea').dataset.numArt = numArt;
    formCommentAnswer.querySelector('.form-comment-textarea').dataset.numSeqCom = numSeqCom;

    formCommentAnswer.classList.remove('hidden');
    formCommentAnswer.querySelector('.form-comment-textarea').focus();
}

function hideFormCommentAnswer() {
    formCommentAnswer.classList.add('hidden');
    document.querySelector('.comments-container').appendChild(formCommentAnswer);
}

function updateLikeArt(nbLikes) {
    document.querySelector('.article-like-count').innerText = ':n personne(s) aime(nt) cet article'.singularise(nbLikes || 0);
}
function setArticleLiked(liked) {
    document.querySelector('.article-like-icon.liked').classList.toggle('hidden', !liked);
    document.querySelector('.article-like-icon.like').classList.toggle('hidden', liked);
}

// api functions --------------

function fetchComments() {
    hideFormCommentAnswer();
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
                fetchLikesComMember();
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
    hideFormCommentAnswer();
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
            if(data.errors && data.code===1) {
                window.location.href = urlConnexion;
            }
            if(data.errors || !data.result) return;            
                
            formCommentTextArea.value = "";
            fetchComments();
        } 
    );
}

function postCommentAnswer() {
    hideFormCommentAnswer();
    const data = { 
        numArt,
        libCom: formCommentAnswerTextArea.value,
        numSeqComR: formCommentAnswer.querySelector('.form-comment-textarea').dataset.numSeqCom,
        numArtR: formCommentAnswer.querySelector('.form-comment-textarea').dataset.numArt
    };
    if(data.libCom.trim().length === 0) {
        formCommentAnswerTextArea.value = "";
        return;
    }

    $.post( 
        urlPostCommentPlus,
        data,
        function(data) {
            if(data.errors && data.code===1) {
                window.location.href = urlConnexion;
            }
            if(data.errors || !data.result) return;            
                
            formCommentAnswerTextArea.value = "";
            fetchComments();
        } 
    );
}


function fetchLikesComMember() {
    hideFormCommentAnswer();
    $.get( 
        urlFetchLikesComMember,
        {},
        function(data) {
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

function fetchArticleLikedByMember() {
    const data = {
        numArt
    };
    $.get( 
        urlFetchArticleLikedByMember,
        data,
        function(data) {
            if(!data.errors && data.result) {
                console.log(data.result);
                setArticleLiked(data.result.hasLiked);
            }
        } 
    );
}

function toggleLikeCom(numArt, numSeqCom) {
    const data = { 
        numArt,
        numSeqCom
    };

    $.post( 
        urlToggleLikeCom,
        data,
        function(data) {
            if(data.errors && data.code===1) {
                window.location.href = urlConnexion;
            } else if(!data.errors && data.result && data.result.comment) {                
                updateComment(data.result.comment);
                fetchLikesComMember();
            }
        } 
    );
}

function toggleLikeArt(numArt) {
    const data = { 
        numArt
    };

    $.post( 
        urlToggleLikeArt,
        data,
        function(data) {
            if(data.errors && data.code===1) {
                window.location.href = urlConnexion;
            } else if(!data.errors && data.result && data.result.nbLikes) {
                updateLikeArt(data.result.nbLikes);
                fetchArticleLikedByMember();
            }
        } 
    );
}