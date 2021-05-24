<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- provide the csrf token -->
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <link href="{{ asset('css/app.css') }}" rel="stylesheet" type="text/css" />
	<!--favicon-->
	<link rel="icon" href="{{ asset('frontend/images/favicon-32x32.png') }}" type="image/png" />
	<!--plugins-->
	<link href="{{ asset('frontend/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
	<link href="{{ asset('frontend/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
	<link href="{{ asset('frontend/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
	<!-- loader-->
	<link href="{{ asset('frontend/css/pace.min.css') }}" rel="stylesheet" />
	<script src="{{ asset('frontend/js/pace.min.js') }}"></script>
	<!-- Bootstrap CSS -->
	<link href="{{ asset('frontend/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="{{ asset('frontend/css/app.css') }}" rel="stylesheet">
	<link href="{{ asset('frontend/css/icons.css') }}" rel="stylesheet">
	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="{{ asset('frontend/css/dark-theme.css') }}" />
	<link rel="stylesheet" href="{{ asset('frontend/css/semi-dark.css') }}" />
	<link rel="stylesheet" href="{{ asset('frontend/css/header-colors.css') }}" />
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
	<title>Syndron - Bootstrap5 Admin Template</title>

	<script type='text/javascript'>var CSRF_TOKEN = "{{ csrf_token() }}"</script>
</head>
<body>
	<!--wrapper-->
	<div id="app" class="wrapper">