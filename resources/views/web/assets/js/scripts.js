$(function () {
    // $("body").on("click", '[data-toggle="lightbox"]', function (event) {
    //     event.preventDefault();
    //     $(this).ekkoLightbox();
    // });
    // $(".open_filter").on("click", function (event) {
    //     event.preventDefault();

    //     box = $(".form_advanced");
    //     button = $(this);

    //     if (box.css("display") !== "none") {
    //         button.text("Filtro Avançado ↓");
    //     } else {
    //         button.text("✗ Fechar");
    //     }

    //     box.slideToggle();
    // });

    $("body").on("change", 'select[name*="filter_"]', function () {
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        var search = $(this);
        var nextIndex = $(this).data("index") + 1;

        $.post(
            search.data("action"),
            { search: search.val() },
            function (response) {
                if (response.status === "success") {
                    $('select[data-index="' + nextIndex + '"]').empty();

                    $.each(response.data, function (key, value) {
                        $('select[data-index="' + nextIndex + '"]').append(
                            $("<option>", {
                                value: value,
                                text: value,
                            })
                        );
                    });

                    $.each(
                        $('select[name*="filter_"]'),
                        function (index, element) {
                            if ($(element).data("index") >= nextIndex + 1) {
                                $(element)
                                    .empty()
                                    .append(
                                        $("<option>", {
                                            text: "Selecione o filtro anterior",
                                            disabled: true,
                                        })
                                    );
                            }
                        }
                    );

                    $(".selectpicker").selectpicker("refresh");

                    //Preços
                    if (nextIndex === 4) {
                        let numbers = response.data;
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

                        $(function () {
                            $("#price-range").slider({
                                range: true,
                                min: minItens,
                                max: maxItens,
                                values: [minItens, maxItens],
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
                                            let itens =
                                                numbers.filter(findNumbers);

                                            let minItens = itens.reduce(
                                                function (a, b) {
                                                    return Math.min(a, b);
                                                },
                                                itens[0]
                                            );
                                            let maxItens = itens.reduce(
                                                function (a, b) {
                                                    return Math.max(a, b);
                                                },
                                                itens[0]
                                            );

                                            $("#year-range").slider({
                                                range: true,
                                                min: minItens,
                                                max: maxItens,
                                                values: [minItens, maxItens],
                                                slide: function (event, ui) {
                                                    $("#year_base_input").val(
                                                        ui.values[0]
                                                    );
                                                    $("#year_limit_input").val(
                                                        ui.values[1]
                                                    );
                                                    if (ui.handleIndex == 0) {
                                                        let search =
                                                            $("#year_base");
                                                        $.post(
                                                            search.data(
                                                                "action"
                                                            ),
                                                            {
                                                                search: ui
                                                                    .values[0],
                                                            }
                                                        );
                                                    }

                                                    if (ui.handleIndex == 1) {
                                                        let search =
                                                            $("#year_limit");
                                                        $.post(
                                                            search.data(
                                                                "action"
                                                            ),
                                                            {
                                                                search: ui
                                                                    .values[1],
                                                            }
                                                        );
                                                    }
                                                },
                                            });
                                            $("#year_base_input").val(
                                                $("#year-range").slider(
                                                    "values",
                                                    0
                                                )
                                            );
                                            $("#year_limit_input").val(
                                                $("#year-range").slider(
                                                    "values",
                                                    1
                                                )
                                            );
                                        });
                                    }
                                },
                            });
                            $("#price_base_input").val(
                                $("#price-range")
                                    .slider("values", 0)
                                    .toLocaleString("pt-BR", {
                                        style: "currency",
                                        currency: "BRL",
                                    })
                            );
                            $("#price_limit_input").val(
                                $("#price-range")
                                    .slider("values", 1)
                                    .toLocaleString("pt-BR", {
                                        style: "currency",
                                        currency: "BRL",
                                    })
                            );
                        });
                    }
                }

                if (response.status === "fail") {
                    $.each(
                        $('select[name*="filter_"]'),
                        function (index, element) {
                            if ($(element).data("index") >= nextIndex) {
                                $(element)
                                    .empty()
                                    .append(
                                        $("<option>", {
                                            text: "Selecione uma opção no filtro anterior.",
                                        })
                                    );
                            }
                        }
                    );
                    $(".selectpicker").selectpicker("refresh");
                }
            },
            "json"
        );
    });
});
