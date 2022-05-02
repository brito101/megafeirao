const megalike = JSON.parse(localStorage.getItem("megalike"));
if (megalike) {
    $(megalike).each((e, val) => {
        $(".icon-heart-o").each((el, value) => {
            if (val.id === $(value).data().id) {
                $(value).removeClass("icon-heart-o").addClass("icon-heart");
            }
        });
    });
}

$(".heart-like").click(function (e) {
    e.preventDefault();
    el = $(this);
    if (el.hasClass("icon-heart-o")) {
        el.removeClass("icon-heart-o").addClass("icon-heart");
        if (localStorage.getItem("megalike")) {
            const item = JSON.parse(localStorage.getItem("megalike"));
            item.push(el.data());
            localStorage.setItem("megalike", JSON.stringify(item));
        } else {
            localStorage.setItem("megalike", JSON.stringify(Array(el.data())));
        }
    } else {
        el.removeClass("icon-heart").addClass("icon-heart-o");
        let rem = JSON.parse(localStorage.getItem("megalike"));
        rem = rem.filter(function (item) {
            return item.id !== el.data().id;
        });
        localStorage.setItem("megalike", JSON.stringify(rem));
    }
});
