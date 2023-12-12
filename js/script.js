document.addEventListener("DOMContentLoaded", () => {
    const urlParams = new URLSearchParams(window.location.search);
    const errorMessage = urlParams.get("error");
    let toast = document.getElementById("error-toast");
    if (errorMessage) {
        toast.style.opacity = 1;
    } else {
        document.getElementById("toast-container").style.display = "none";
        toast.style.opacity = 0;
    }
});

function hideErrorToast() {
    let toast = document.getElementById("error-toast");
    document.getElementById("toast-container").style.display = "none";
    toast.style.opacity = 0;
}

function setArticleId(article_id) {
    if(article_id) {
        window.articleId = article_id;
    } else {
        window.articleId = document.querySelector("[data-article-id]").getAttribute("data-article-id");
    }
}

function getArticleId() {
    if(document.getElementById("modalArticleId")) {
        document.getElementById("modalArticleId").value = window.articleId;
    }
    // if(document.getElementById("loginArticleId")) {
    //     document.getElementById("loginArticleId").value = articleId
    // }
    // if(document.getElementById("registerArticleId")) {
    //     document.getElementById("registerArticleId").value = articleId
    // }
}

function showAmendments(articleId, amendmentDetails) {
    document.getElementById("modalArticleId").value = articleId;

    let amendmentsData = JSON.parse(amendmentDetails);

    document.getElementById("amendmentText").value = amendmentsData.text;
    document.getElementById("submitBtn").disabled = true;

    $("#amendmentModal").modal("show");
}

document.querySelectorAll(".show-amendments").forEach(button => {
    button.addEventListener("click", function (event) {
        event.preventDefault();
        const articleId = this.getAttribute("data-article-id");
        const amendmentDetails = this.getAttribute("data-amendment-details");
        showAmendments(articleId, amendmentDetails);
    });
});

function resetModalFields() {
    document.getElementById("modalArticleId").value = "";
    document.getElementById("amendmentText").value = "";
    document.getElementById("submitBtn").disabled = false;
}

$("#amendmentModal").on("hidden.bs.modal", function () {
    resetModalFields();
});


function populateArticleModal(articleIDetails, amendmentId) {
    console.log(articleIDetails)

    let articleData = JSON.parse(articleIDetails);

    document.getElementById("update_title").value = articleData.title;
    document.getElementById("update_content").value = articleData.content;

    let categorySelect = document.getElementById("update_category_id");
    for (let i = 0; i < categorySelect.options.length; i++) {
        if (categorySelect.options[i].value == articleData["category_id"]) {
            categorySelect.options[i].selected = true;
            break;
        }
    }
    document.getElementById("update_article_id").value = articleData.id;
    document.getElementById("update_amendment_id").value = amendmentId;
}

document.querySelectorAll("[data-toggle='modal']").forEach(button => {
    button.addEventListener("click", function (event) {
        event.preventDefault();

        let articleDetails = this.getAttribute("data-article-details");
        let amendmentId = this.getAttribute("data-amendment-id");

        populateArticleModal(articleDetails, amendmentId);

        $("#submitArticleModal").modal("show");
    });
});

$("#submitArticleModal").on("hidden.bs.modal", function () {
    document.getElementById("update_title").value = "";
    document.getElementById("update_content").value = "";
    document.querySelector("#update_category_id option").value = "";
    document.getElementById("update_article_id").value = "";
    document.getElementById("update_amendment_id").value = "";
});


