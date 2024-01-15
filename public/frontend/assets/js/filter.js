$(function () {
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
    });

    //Preço
    $("#price-range").slider({
        range: true,
        min: 0,
        max: 200000,
        values: [0, 200000],
        slide: function (event, ui) {
            $("#price_base_input").val(
                ui.values[0].toLocaleString("pt-BR", {
                    style: "currency",
                    currency: "BRL",
                })
            );
            $("#price_limit_input").val(
                ui.values[1].toLocaleString("pt-BR", {
                    style: "currency",
                    currency: "BRL",
                })
            );

            if (ui.handleIndex == 0) {
                let search = $("#base");
                $.post(search.data("action"), {
                    search: ui.values[0],
                });
            }

            if (ui.handleIndex == 1) {
                let search = $("#limit");
                $.post(search.data("action"), {
                    search: ui.values[1],
                }).done(function (res) {
                    let numbers = res.data;

                    function findNumbers(value) {
                        if (!isNaN(value)) return value;
                    }
                    let itens = numbers.filter(findNumbers);

                    let minItens = itens.reduce(function (a, b) {
                        return Math.min(a, b);
                    }, itens[0]);
                    let maxItens = itens.reduce(function (a, b) {
                        return Math.max(a, b);
                    }, itens[0]);

                    $("#year-range").slider({
                        range: true,
                        min: minItens,
                        max: maxItens,
                        values: [minItens, maxItens],
                        slide: function (event, ui) {
                            $("#year_base_input").val(ui.values[0]);
                            $("#year_limit_input").val(ui.values[1]);
                        },
                    });
                    $("#year_base_input").val(
                        $("#year-range").slider("values", 0)
                    );
                    $("#year_limit_input").val(
                        $("#year-range").slider("values", 1)
                    );
                });
            }
        },
    });
    $("#price_base_input").val(
        $("#price-range").slider("values", 0).toLocaleString("pt-BR", {
            style: "currency",
            currency: "BRL",
        })
    );
    $("#price_limit_input").val(
        $("#price-range").slider("values", 1).toLocaleString("pt-BR", {
            style: "currency",
            currency: "BRL",
        })
    );

    //Ano
    $("#year-range").slider({
        range: true,
        min: 1980,
        max: new Date().getFullYear() + 1,
        values: [0, 9999],
        slide: function (event, ui) {
            $("#year_base_input").val(ui.values[0]);
            $("#year_limit_input").val(ui.values[1]);

            if (ui.handleIndex == 0) {
                let search = $("#year_base");
                $.post(search.data("action"), {
                    search: ui.values[0],
                });
            }

            if (ui.handleIndex == 1) {
                let search = $("#year_limit");
                $.post(search.data("action"), {
                    search: ui.values[1],
                });
            }
        },
    });
    $("#year_base_input").val($("#year-range").slider("values", 0));
    $("#year_limit_input").val($("#year-range").slider("values", 1));

    //Quilometragem
    let mileageMax = parseFloat($("#mileageMax").text()) || 200000;
    $("#mileage-range").slider({
        range: false,
        min: 0,
        max: mileageMax,
        values: [mileageMax],
        slide: function (event, ui) {
            $("#mileage_input").val(
                Intl.NumberFormat("pt-BR").format(ui.values[0])
            );

            let search = $("#mileage");
            $.post(search.data("action"), {
                search: ui.values[0],
            });
        },
    });
    $("#mileage_input").val(
        Intl.NumberFormat("pt-BR").format(
            $("#mileage-range").slider("values", 0)
        )
    );

    $(".check_filter").change(function () {
        let items = [];
        $(".check_filter input:checked").each(function () {
            items.push(this.value);
        });

        if (items.length > 0) {
            $.ajaxSetup({
                headers: {
                    "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr(
                        "content"
                    ),
                },
            });
            let search = $(this);
            $.post(search.data("action"), {
                search: items,
            });
        }
    });
});

//Change img
// $(function () {
//     $("[data-img_filter]").hover(function () {
//         $(this).addClass("d-none");
//         let img = $(this).data("img_filter");
//         $(`.${img}`).removeClass("d-none");
//     });
// });
