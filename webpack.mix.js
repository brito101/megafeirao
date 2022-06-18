const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix

    //Assets Web
    .sass(
        "resources/views/web/assets/scss/bootstrap_person.scss",
        "public/frontend/assets/css/bootstrap.css"
    )

    .styles(
        [
            // 'resources/views/web/assets/libs/lightbox/ekko-lightbox.css'
            "resources/views/web/assets/libs/jquery-ui/jquery-ui.css",
        ],
        "public/frontend/assets/libs/libs.css"
    )

    .sass(
        "resources/views/web/assets/scss/app.scss",
        "public/frontend/assets/css/app.css"
    )

    .scripts(
        ["node_modules/jquery/dist/jquery.min.js"],
        "public/frontend/assets/js/jquery.js"
    )

    .scripts(
        ["node_modules/bootstrap/dist/js/bootstrap.bundle.js"],
        "public/frontend/assets/js/bootstrap.js"
    )

    // .scripts([
    //     'resources/views/web/assets/libs/lightbox/ekko-lightbox.min.js'
    // ], 'public/frontend/assets/libs/libs.js')

    .scripts(
        [
            "node_modules/bootstrap-select/dist/js/bootstrap-select.min.js",
            "node_modules/bootstrap-select/dist/js/i18n/defaults-pt_BR.min.js",
        ],
        "public/frontend/assets/js/libs.js"
    )

    .scripts(
        ["resources/views/web/assets/js/scripts.js"],
        "public/frontend/assets/js/scripts.js"
    )

    .scripts(
        ["resources/views/web/assets/js/like.js"],
        "public/frontend/assets/js/like.js"
    )

    .scripts(
        ["resources/views/web/assets/js/jquery-ui.js"],
        "public/frontend/assets/js/jquery-ui.js"
    )

    .scripts(
        ["resources/views/web/assets/js/filter.js"],
        "public/frontend/assets/js/filter.js"
    )

    .copyDirectory(
        "resources/views/web/assets/css/fonts",
        "public/frontend/assets/css/fonts"
    )
    .copyDirectory(
        "resources/views/web/assets/images",
        "public/frontend/assets/images"
    )

    //Assets Admin
    .sass(
        "resources/views/admin/assets/scss/reset.scss",
        "public/backend/assets/css/reset.css"
    )
    .sass(
        "resources/views/admin/assets/scss/boot.scss",
        "public/backend/assets/css/boot.css"
    )
    .sass(
        "resources/views/admin/assets/scss/login.scss",
        "public/backend/assets/css/login.css"
    )
    .sass(
        "resources/views/admin/assets/scss/style.scss",
        "public/backend/assets/css/style.css"
    )

    .styles(
        [
            "resources/views/admin/assets/js/datatables/css/jquery.dataTables.min.css",
            "resources/views/admin/assets/js/datatables/css/responsive.dataTables.min.css",
            "resources/views/admin/assets/js/select2/css/select2.min.css",
        ],
        "public/backend/assets/css/libs.css"
    )

    .scripts(
        ["node_modules/jquery/dist/jquery.min.js"],
        "public/backend/assets/js/jquery.js"
    )

    .scripts(
        ["resources/views/admin/assets/js/login.js"],
        "public/backend/assets/js/login.js"
    )

    .scripts(
        [
            "resources/views/admin/assets/js/datatables/js/jquery.dataTables.min.js",
            "resources/views/admin/assets/js/datatables/js/dataTables.responsive.min.js",
            "resources/views/admin/assets/js/select2/js/select2.min.js",
            "resources/views/admin/assets/js/select2/js/i18n/pt-BR.js",
            "resources/views/admin/assets/js/jquery.form.js",
            "resources/views/admin/assets/js/jquery.mask.js",
        ],
        "public/backend/assets/js/libs.js"
    )

    .scripts(
        ["resources/views/admin/assets/js/scripts.js"],
        "public/backend/assets/js/scripts.js"
    )

    .copyDirectory(
        "resources/views/admin/assets/js/tinymce",
        "public/backend/assets/js/tinymce"
    )
    .copyDirectory(
        "resources/views/admin/assets/js/datatables",
        "public/backend/assets/js/datatables"
    )
    .copyDirectory(
        "resources/views/admin/assets/js/select2",
        "public/backend/assets/js/select2"
    )

    .copyDirectory(
        "resources/views/admin/assets/css/fonts",
        "public/backend/assets/css/fonts"
    )
    .copyDirectory(
        "resources/views/admin/assets/images",
        "public/backend/assets/images"
    )
    //Templates
    .sass(
        "resources/views/web/templates/template-1/assets/scss/style.scss",
        "public/company-template/assets/css/style.css"
    )
    .sass(
        "resources/views/web/templates/template-1/assets/scss/color.scss",
        "public/company-template/assets/css/color.css"
    )
    .copyDirectory(
        "resources/views/web/templates/template-1/assets/img",
        "public/company-template/assets/img"
    )
    .styles(
        [
            "resources/views/web/templates/template-1/assets/css/bootstrap.css",
            "resources/views/web/templates/template-1/assets/css/bootstrap-theme.css",
            "resources/views/web/templates/template-1/assets/css/custom.css",
        ],
        "public/company-template/assets/css/lib.css"
    )
    .styles(
        ["resources/views/web/templates/template-1/assets/css/carousel.css"],
        "public/company-template/assets/css/carousel.css"
    )
    .scripts(
        [
            "resources/views/web/templates/template-1/assets/js/jquery-3.6.0.min.js",
        ],
        "public/company-template/assets/js/jquery.js"
    )
    .scripts(
        [
            "resources/views/web/templates/template-1/assets/js/jquery-ui.min.js",
        ],
        "public/company-template/assets/js/jquery-ui.js"
    )
    .scripts(
        [
            "resources/views/web/templates/template-1/assets/js/owl.carousel.min.js",
        ],
        "public/company-template/assets/js/carousel.js"
    )
    .scripts(
        ["resources/views/web/templates/template-1/assets/js/bootstrap.js"],
        "public/company-template/assets/js/bootstrap.js"
    )
    .scripts(
        ["resources/views/web/templates/template-1/assets/js/init.js"],
        "public/company-template/assets/js/init.js"
    )
    .scripts(
        [
            "resources/views/web/templates/template-1/assets/js/jquery.flexslider.js",
        ],
        "public/company-template/assets/js/flexslider.js"
    )
    .options({
        processCssUrls: false,
    })
    .version();
