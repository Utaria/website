window.addEventListener("load", function () {
    var comments = document.querySelectorAll(".comment");

    for (var i = 0; i < comments.length; i++) {
        var comment = comments[i];
        var triggerResponse = comment.querySelector("#response_trigger");
        if (triggerResponse == null) continue;

        triggerResponse.addEventListener("click", onResponseTriggerClick);
    }


    document.getElementById("postcomment").addEventListener("submit", function () {
        var textarea = document.getElementById("content");

        if (localStorage)
            localStorage.setItem("lastcomment_form_devblog", textarea.value);
    });

    var lastComment = localStorage.getItem("lastcomment_form_devblog");
    if (lastComment != null && document.getElementById("playername").parentNode.classList.contains("error"))
        document.getElementById("content").innerHTML = lastComment;
});

function onResponseTriggerClick () {
    var comment = recursiveParent(this, 3);
    if (comment == null || comment.className != "comment") return false;

    var postFormParentContent = document.getElementById("postform_parent_comment");
    if (postFormParentContent == null) return false;

    var commentHtml = comment.innerHTML + "";

    commentHtml = commentHtml.replace("\n", "")
        .replace(/<div class="subcomments">[\s\S]*<\/div>/, "")
        .replace(/<span class="send_response"[\s\S]*<\/span>/, "");


    postFormParentContent.parentNode.style.display = "block";
    postform_parent_comment.innerHTML = commentHtml;
    document.getElementById("parent_comment_id_input").value = this.dataset.commentid;

    window.location.hash = "postcomment_form";
}

function recursiveParent (element, n) {
    var el = element;

    for (var i = n; i > 0; i--)
        if (el.parentNode != null)
            el = el.parentNode;

    return el;
}
