<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="base-url" content="{{ url('/') }}">
    <link rel="icon" href="{{ asset('/assets/favicon.ico') }}" sizes="16x16">
    <link rel="manifest" href="/manifest.json" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <style>
        .vh {
            min-height: 100vh;
        }
        .vh-50 {
            position: fixed;
            right: 0;
            top:50%;
            transform: translate(0, -50%);
        }
        .weight-25 {
            width:25px;
            text-align: center;
        }
        .height-25 {
            height:25px;
            line-height: 25px;
        }
        .grad {
            background-image: linear-gradient(to right, #B6793F, #ff59af);
        }
        .text-warning-deep {
            color: #B6793F;
        }
        .text-danger-deep {
            color: #ff59af;
        }
        .bg-warning-deep {
            background: #B6793F;
        }
        .border-warning-deep {
            border-color: #B6793F !important;
            border-width:2px !important;
        }
    </style>
</head>
<body>
<div id="app" class="bg-dark">
    <div class="container bg-secondary vh">
        <div class="row">
            <div class="col-12">
                <router-view :key="$route.fullPath"></router-view>
            </div>
        </div>
    </div>
    <cart></cart>
</div>
<script src="/js/app.js?{{ time() }}"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
