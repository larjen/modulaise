<!doctype html>  
<?php ModulaiseController::printComment("paulirish.com/2008/conditional-stylesheets-vs-css_hacks-answer-neither/"); ?>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]>    <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]>    <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]><!--> <html lang="en" class="no-js"> <!--<![endif]-->
<head>
<meta charset="utf-8">
<?php ModulaiseController::printComment("Always force latest IE rendering engine (even in intranet) & Chrome Frame Remove this if you use the .htaccess"); ?>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title><?php ModulaiseController::printPageTitle() ?></title>
<meta name="description" content="">
<meta name="author" content="">
<?php ModulaiseController::printComment("Mobile viewport optimized: j.mp/bplateviewport"); ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php ModulaiseController::printComment("Import css stylesheets"); ?>
<?php ModulaiseController::printPane(PANE_CSS); ?>
<?php ModulaiseController::printPane(PANE_HTML_HEAD_FIRST); ?>

<?php ModulaiseController::printComment("Import javascripts"); ?>
<?php ModulaiseController::printPane(PANE_JS_HEAD); ?>

<?php ModulaiseController::printComment("Print HTML snippets"); ?>
<?php ModulaiseController::printPane(PANE_HTML_HEAD_LAST); ?>

</head>
<body>