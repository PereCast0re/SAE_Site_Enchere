const template = document.querySelector("#comment-template");
const commentsListEl = document.querySelector("#comments");
const commentCounter = document.querySelector("#comments-counter");

function getComments(id_product) {
    return fetch(`index.php?action=getComments&id_product=${id_product}`)
        .then((response) => response.json());
}

async function addComment(comment, prepend = false) {
    const commentEl = document.importNode(template.content, true);

    commentEl.querySelector(".comment-content").innerText = comment["comment"];
    commentEl.querySelector(".comment-author-name").innerText = comment["full_name"];

    const userID = document.querySelector('#userID').value;

    if (userID == comment["id_user"]) {
        commentEl.querySelector(".comment-container").classList.add("comment-seller");
            commentEl.querySelector(".comment-author-name").innerText = comment["full_name"] + " (vendeur)";
    } else {
        commentEl.querySelector(".comment-container").classList.add("comment-user");
    }

    if (prepend) {
        commentsListEl.prepend(commentEl);
    } else {
        commentsListEl.append(commentEl);
    }
}

window.addEventListener("load", async function () {
    const comments = await getComments(this.document.querySelector('#idProduct').value);

    console.log(comments);

    await Promise.all(comments.map((comment) => addComment(comment)));

    commentCounter.innerText = comments.length;
});
