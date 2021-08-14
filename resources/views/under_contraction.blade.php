@extends('layouts.app_master')
@section('title', 'Under Construction')
@section('css')
<style type="text/css">
	html, body {
		height: 100%;
	}
	body {
		font-family: sans-serif;
		font-size: 14px;
		background-color: #ffffff;
		color: #2F3230;
		padding: 0;
		margin: 0;
		overflow:hidden
	}
	section {
		display: block;
		padding: 0;
		margin: 0;
	}
	.container {
		margin-left: auto;
		margin-right: auto;
		padding: 0 10px;
	}
	.additional-info {
		background-repeat: no-repeat;
		background: linear-gradient(to bottom, rgba(44, 158, 142, 1) 0%, rgba(37, 72, 132, 1) 100%);
		color: #FFFFFF;
		position: relative;
		overflow: hidden;
		height: 100%;
		text-align: center;
		box-shadow: 0 -10px 109px 0 rgba(0, 0, 0, 0.2);
		border-top: 1px solid #fff;
	}
	.additional-info:after {
		content: "\f085";
		font-family: fontawesome;
		font-size: 25em;
		color: rgba(255, 255, 255, 0.15);
		position: absolute;
		top: -8%;
		left: -10%;
		z-index: 0;
	}
	.additional-info-items {
		padding: 20px;
		min-height: 193px;  
		text-shadow:0 2px 3px rgba(0,0,0,0.1);
	}
	.info-heading {
		font-weight: bold;
		word-break: break-all;
		width: 100%;
	}
	.status-reason {
		font-size: 4em;
		line-height: 1em;
		font-weight: bold;
		display: block;  
		text-align: center;
		padding: 1.5em 0; 
		background-color: rgb(28, 54, 76);
		color: transparent;
		text-shadow: 0px 2px 3px rgba(255,255,255,0.5);
		-webkit-background-clip: text;
		-moz-background-clip: text;
		background-clip: text;
	}
	.status-reason .fa {
		font-size: 60px;
		background-color: rgb(28, 54, 76);
		color: transparent;
		text-shadow: 0px 2px 3px rgba(255,255,255,0.5);
		-webkit-background-clip: text;
		-moz-background-clip: text;
		background-clip: text;
	}
	.reason-text {
		margin: 20px 0;
		font-size: 16px;
	}
	.info-heading {
		font-size: 190%;
	}

</style>
@endsection
@section('content')
<div class="container">
	<h1 class="status-reason">
		<i class="fa fa-exclamation-triangle fa-2x"></i> Under Construction
	</h1>
</div>
<section class="additional-info">
	<div class="container">
		<div class="additional-info-items">
			<h2 class="info-heading">
				Good news! we are working on your site.
			</h2>
			<div class="reason-text">
				Check back soon or contact us for more information.
			</div>
		</div>
	</div>
</section>
@endsection
