<!DOCTYPE html>
<html>
<head>
	<title></title>
	<style type="text/css">
		/* Base */

		body,
		body *:not(html):not(style):not(br):not(tr):not(code) {
		    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif,
		        'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol';
		    box-sizing: border-box;
		}

		body {
		    background-color: white;
		    color: rgba(0,0,0,0.6);
		    height: 100%;
		    hyphens: auto;
		    line-height: 1.4;
		    margin: 0;
		    -moz-hyphens: auto;
		    -ms-word-break: break-all;
		    width: 100% !important;
		    -webkit-hyphens: auto;
		    -webkit-text-size-adjust: none;
		    ord-break: break-all;
		    word-break: break-word;
		}

		.content-fluid{
			margin-left: 65px;
			margin-right: 65px;
			border-left: 1px solid #000;
			padding: 10px;
			line-height: 2em;
		}

		p,
		ul,
		ol,
		blockquote {
		    line-height: 1.4;
		    text-align: left;
		}

		a {
		    color: #00838f;
		    text-decoration:none;
		    font-weight: 600;
		}

		a img {
		    border: none;
		}

		img {
		    border: none;
		    padding-top: 160px;
		    padding-bottom: 60px;
		}


		/* Typography */

		h1 {
		    color: #3d4852;
		    font-size: 45px;
		    font-weight: bold;
		    margin-top: 0;
		    text-align: left;
		}

		h2 {
		    color: #3d4852;
		    font-size: 50px;
		    font-weight: bold;
		    margin-top: 0;
		    text-align: left;
		}

		h3 {
		    color: #3d4852;
		    font-size: 14px;
		    font-weight: bold;
		    margin-top: 0;
		    text-align: left;
		}

		p {
		    color: #000000;
		    font-size: 25px;
		    line-height: 1.5em;
		    margin-top: 0;
		    text-align: left;
		}

		small {

		    color: #000000;
		    font-size: 16px;
		    line-height: 1.5em;
		    margin-top: 0;
		    text-align: left;
		}
		
		.justify{
			text-align : justify;
		}

		p.sub {
		    font-size: 12px;
		}

		img {
		    max-width: 100%;
		}


		/* Layout */

		.wrapper {
		    background-color: #008981;
		    margin: 0;
		    padding: 0;
		    width: 100%;
		    -premailer-cellpadding: 0;
		    -premailer-cellspacing: 0;
		    -premailer-width: 100%;
		}

		.center, .center-align {
		    text-align: center;
		}

		

		.content {
		    margin: 0;
		    padding: 0;
		    width: 100%;
		    -premailer-cellpadding: 0;
		    -premailer-cellspacing: 0;
		    -premailer-width: 100%;
		}


		/* Header */

		.header {
		    padding: 25px 0;
		    text-align: center;
		}

		.header a {
		    color: #008981;
		    font-size: 19px;
		    font-weight: bold;
		    text-decoration: none;
		    text-shadow: 0 1px 0 white;
		}

		/* Body */


		.body {
		    background-color: #e0f2f1;
		    border-bottom: 1px solid #edeff2;
		    border-top: 1px solid #edeff2;
		    margin: 0;
		    padding: 0;
		    width: 100%;
		    -premailer-cellpadding: 0;
		    -premailer-cellspacing: 0;
		    -premailer-width: 100%;

		}

		.inner-body {
		    background-color: rgba(178, 223, 219, 0.2);
		    /*opacity:0.6;*/
		    border: 4px solid #009688;
		    margin: 0 auto;
		    padding: 0;
		    width: 570px;
		    -premailer-cellpadding: 0;
		    -premailer-cellspacing: 0;
		    -premailer-width: 570px;
		}

		/* Subcopy */

		.subcopy {
		    border-top: 1px solid #008981;
		    margin-top: 25px;
		    padding-top: 25px;
		}

		.subcopy p {
		    font-size: 12px;
		}

		/* Footer */

		.footer {
		    margin: 0 auto;
		    padding: 0;
		    text-align: center;
		    width: 570px;
		    -premailer-cellpadding: 0;
		    -premailer-cellspacing: 0;
		    -premailer-width: 570px;
		}

		.footer p {
		    color: white;
		    font-size: 13px;
		    text-align: center;
		}

		/* Tables */

		.table table {
		    margin: 30px auto;
		    width: 100%;
		    -premailer-cellpadding: 0;
		    -premailer-cellspacing: 0;
		    -premailer-width: 100%;
		}

		.table th {
		    border-bottom: 1px solid #00796b;
		    padding-bottom: 8px;
		    margin: 0;
		}

		.table td {
		    color: #000000;
		    font-size: 18px;
		    line-height: 18px;
		    padding: 10px 0;
		    margin: 0;
		    border: 4px;
		}

		.content-cell {
		    padding: 35px;
		    text-align: center;

		}



		/* Buttons */

		.action {
		    margin: 30px auto;
		    padding: 0;
		    text-align: center;
		    width: 100%;
		    -premailer-cellpadding: 0;
		    -premailer-cellspacing: 0;
		    -premailer-width: 100%;
		}

		.button {
		    border-radius: 3px;
		    box-shadow: 0 2px 3px rgba(0, 0, 0, 0.16);
		    color: #fff;
		    display: inline-block;
		    text-decoration: none;
		    -webkit-text-size-adjust: none;
		}

		.button-blue,
		.button-primary {
		    background-color: #008981;
		    border-top: 10px solid #008981;
		    border-right: 18px solid #008981;
		    border-bottom: 10px solid #008981;
		    border-left: 18px solid #008981;
		}

		.button-green,
		.button-success {
		    background-color: #38c172;
		    border-top: 10px solid #38c172;
		    border-right: 18px solid #38c172;
		    border-bottom: 10px solid #38c172;
		    border-left: 18px solid #38c172;
		}

		.button-red,
		.button-error {
		    background-color: #e3342f;
		    border-top: 10px solid #e3342f;
		    border-right: 18px solid #e3342f;
		    border-bottom: 10px solid #e3342f;
		    border-left: 18px solid #e3342f;
		}

		/* Panels */

		.panel {
		    margin: 0 0 21px;
		}

		.panel-content {
		    background-color: #f1f5f8;
		    padding: 16px;
		}

		.panel-item {
		    padding: 0;
		}

		.panel-item p:last-of-type {
		    margin-bottom: 0;
		    padding-bottom: 0;
		}

		/* Promotions */

		.promotion {
		    background-color: #ffffff;
		    border: 2px dashed #9ba2ab;
		    margin: 0;
		    margin-bottom: 25px;
		    margin-top: 25px;
		    padding: 24px;
		    width: 100%;
		    -premailer-cellpadding: 0;
		    -premailer-cellspacing: 0;
		    -premailer-width: 100%;
		}

		.promotion h1 {
		    text-align: center;
		}

		.promotion p {
		    font-size: 15px;
		    text-align: center;
		}

	</style>
</head>
<body>

	<div class="content-fluid">
		
		<center>
			<img src="http://drive.google.com/uc?export=view&id=1QLkYJuTk4JaT9nqHF7Rw6eF5p0G3or4C" width="600" height="169" class="center-align">
		</center>
		<h1 class="center">Certificado de Registro en el Sistema</h1>
		<p class="justify">La red</p>
		<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod
		tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam,
		quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo
		consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse
		cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non
		proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
	</div>
	
	
	
</body>
</html>