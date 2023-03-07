<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>ZAdmin</title>

    <!-- Bootstrap core CSS -->
    <link href="/admin_assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="/admin_assets/css/flatpickr.min.css" rel="stylesheet">
    <link href="/admin_assets/css/style.css" rel="stylesheet">

    <style>
        .bd-placeholder-img {
            font-size: 1.125rem;
            text-anchor: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        @media (min-width: 768px) {
            .bd-placeholder-img-lg {
                font-size: 3.5rem;
            }
        }
    </style>
    <!-- Custom styles for this template -->
    <link href="/admin_assets/css/dashboard.css" rel="stylesheet">
    <link href="/admin_assets/libs/fontawesome/css/all.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark fixed-top bg-dark flex-md-nowrap p-0 shadow">
    <a class="navbar-brand col-sm-3 col-md-2 mr-0" href="#">ZAdmin</a>
    <ul class="navbar-nav px-3">
        <li class="nav-item text-nowrap">
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                <button type="submit" class="btn btn-outline-light">Выход</button>
                @csrf
            </form>
        </li>
    </ul>
</nav>

<div class="container-fluid">
    <div class="row">
        <nav class="col-md-2 d-none d-md-block bg-light sidebar">
            <div class="sidebar-sticky">
                {!! $menu !!}
            </div>
        </nav>

        <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
            @if (session('message'))
                <div class="alert {{session('message')['class']}}">
                    {{ session('message')['text'] }}
                </div>
            @endif
            {!! $content !!}
        </main>
    </div>

</div>
<script src="/admin_assets/js/jquery-3.6.3.min.js"></script>
<script>
    $(document).ready(function(){

        $('body').on('click','.delete-tag',function (e){
            e.preventDefault();
            var data = new FormData();
            var button = $(this);
            let url = button.attr('data-url');
            let news_id = button.attr('data-news_id');
            let tag_id = button.attr('data-tag_id');

            data.append('news_id', news_id);
            data.append('tag_id', tag_id);

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                method: "POST",
                url: url,
                data: data,
                dataType: 'json',
                contentType: false,
                processData: false,
                cache: false,
                beforeSend: function () {
                },
                success: function (responseData) {
                }
            }).done(function (data) {
                window.location.reload();
            }).fail(function (data) {
            });


        })

    });
</script>
<script src="/admin_assets/js/bootstrap.bundle.min.js"></script>
<script src="/admin_assets/libs/tinymce/tinymce.min.js"></script>
<script src="/admin_assets/js/slug.js"></script>
<script src="/admin_assets/js/flatpickr.js"></script>
<script src="/admin_assets/js/flatpickr_ru.js"></script>
<script>

    tinymce.init({
        selector: '.mce', plugins: ['lists','link','code','table'],
        toolbar: 'numlist bullist link code',
        forced_root_block : "",
        height : "480"
    });
</script>
<script>
    $(document).ready(
        function(){
            $(('[data-slug-from]')).each(function(){
                var $original = $(this);
                var id = $(this).data('slug-from');
                $(document).on('keyup', '#' + id, function () {
                    $original.val(url_slug($(this).val()));
                });
            });

            $('.date').flatpickr({
                "locale": "ru",
                "dateFormat": "d.m.Y"
            });
        }
    );
</script>
</body>
</html>
