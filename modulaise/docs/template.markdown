
Template, Page and Pane
===============================================================================

This chapter outlines how to work with templates and panes and how the HTML
page is set up. The specific references in this chapter are made to the 
tutorial project, substitute these for your own project where applicable.


Table of Contents
-------------------------------------------------------------------------------

*   [HTML-pages and Panes](#html_page_layout)
    *   [Panes](#panes)
    *   [Resources](#resources)    
    *   [Order of inclusion](#order_of_inclusion)
    *   [Annotated detailed HTML-page anatomy](#annotated_html_layout)
*   [Working with templates](#working_with_templates)
    *   [An example Template](#example_template)
    *   [Header and Footer](#head_and_foot)
*   [Working with Pages](#working_with_pages)
    *   [Creating a Page](#creating_a_page)
    *   [An example Page](#example_page)
*   [Working with Panes](#working_with_panes)
    *   [Creating a Pane](#creating_a_pane)
    *   [Printing a Pane](#printing_a_pane)
    *   [System Panes](#system_panes)
        *   [``PANE_CSS``](#PANE_CSS)
        *   [``PANE_HTML_HEAD_FIRST``](#PANE_HTML_HEAD_FIRST)
        *   [``PANE_JS_HEAD``](#PANE_JS_HEAD)
        *   [``PANE_HTML_HEAD_LAST``](#PANE_HTML_HEAD_LAST)
        *   [``PANE_HTML_FOOT_FIRST``](#PANE_HTML_FOOT_FIRST)
        *   [``PANE_JS_FOOT``](#PANE_JS_FOOT)
        *   [``PANE_HTML_FOOT_LAST``](#PANE_HTML_FOOT_LAST)
*   [Revision History](#revision_history)


<a name="html_page_layout"/>

HTML-pages and Panes
-------------------------------------------------------------------------------

This briefly outlines the anatomy of a webpage. In this chapter you will get
a basic understanding for the building blocks of a webpage.

You will get a very rough idea about the order of inclusion of static content,
and be presented with the concept of "panes".


<a name="panes"/>

### Panes

A pane is just a blank placeholder in the page, where any arbitrary number of 
HTML-snippets (modules) can be placed. When we are talking about panes
and the anatomy of an HTML-page, keep in mind that the HTML-page is plain
old text that gets parsed by your browser - nothing more nothing less.

Take for instance a 2-column blog page, with a main column containing blog 
posts, and a side column containing calendar, searchbox, cloadtags and so 
on. What I propose is the idea that there is a main pane and a right-pane 
where these respective modules sits in.

But for the regular 2-column blog page I would further chop it up into a 
"head" pane, typically consisting of two modules – the blog name logo and the 
blog main navigation. 

Then there is the footer, if you go with an advanced 3 column footer, thats 3 
extra panes right there – plus for instance a fourth pane at the very bottom 
for legal text or info about the page.

    +-------------------------------------------------------------------+
    |                                                                   |
    |    Pane: "head"                                                   |
    |                                                                   |
    |    * Title                                                        |
    |    * Horizontal Navigation                                        |
    |                                                                   |
    +--------------------------------------------+----------------------+
    |                                            |                      |
    |    Pane: "main"                            |    Pane: "sidebar"   |
    |                                            |                      |
    |    * Blog post 1                           |    * Search          |
    |    * Blog post 2                           |    * Tag Cloud       |
    |    * Blog post 3                           |    * Newsletter      |
    |    * Blog post 4                           |      Signup          |
    |    * Blog post 5                           |    * Calendar        |
    |                                            |                      |
    |                                            |                      |
    |                                            |                      |
    |                                            |                      |
    |                                            |                      |
    |                                            |                      |
    |                                            |                      |
    +----------------------+---------------------+----------------------+
    |                      |                     |                      |
    |    Pane: "foot1"     |    Pane: "foot2"    |    Pane: "foot3"     |
    |                      |                     |                      |
    |    * Blogroll        |    * Affiliates     |    * Contact info    |
    |                      |                     |                      |
    +----------------------+---------------------+----------------------+
    |                                                                   |
    |    Pane: "subfoot"                                                |
    |                                                                   |
    |    * Copyright notice                                             |
    |                                                                   |
    +-------------------------------------------------------------------+

Apart from the panes you can see in the page, the actual contents of the page, 
there are the panes for including css, and the panes for including javascript 
either as imports or as HTML-fragments.

So the number of panes for a simple page, could go high. However there is 
always some compromise to strike here as it takes a little bit of common sense 
to define the panes. 

To few and you risk cornering yourself from being able to put in the right 
content in the right pane, too many and you may bloat the page unnecessary.


<a name="resources"/>

### Resources

HTML-pages can utilize a variety of different types of resources, to name the 
most common ones:

*   CSS
*   JavaScript
*   Images
*   Flash
*   Favicons

All of these resources are linked from within the HTML-page itself. For 
instance css_stylesheets are usually imported in the head section of the 
HTML page using something like this:

    <link rel="stylesheet" href="/path/to/your/stylesheet.css" />

By definition I will refer to "all elements imported or included from the 
HTML-page" as "static content".


<a name="order_of_inclusion"/>

### Order of inclusion

The order of importing these resources are important, for css files later 
parsed CSS declarations takes precedence and JavaScript may require a 
previously loaded JavaScript file.

Apart from the order in which the various resources are imported, the exact 
location in the HTML-page where the resources are imported can greatly affect 
the performance and users percieved experience of the page.

For instance the browser will halt rendering of the page, while it is waiting
for a JavaScript resource to download to the client, thus making it appear to
the user, that the page is loading slowly.

This is a rough annotated sketch of where the different resources in the page
should be loaded.

    <!doctype html>
    <head>

    1. CSS file imports
    ---------------
    CSS files are imported first, as the browser can load
    these asynchronously.
    
    2. JavaScript file imports
    ---------------------
    Import of JavaScript libraries that are necessary for
    the functionality of the page. These are loaded
    here, and should be kept to a minimum since they
    will halt browser rendering of the page.
    
    The modernizr.js file falls into this category, however
    you could defer loading of the JQuery JavaScript
    framework to just before the closing body element, if
    you have constructed your page correctly.

    </head>
    <body>

    3.  Actual page content
    ------------------
    This is where the contents of your HTML page goes. This
    could be header, footer and so on.
    
    If you omit any explicit JavaScript calls in this
    section, and you should, you will be able to defer all
    JavaScript includes until the page is almost fully
    rendered.
    
    From the example above the inclusion order could be:
    
    Pane: "head"
        * Title
        * Horizontal Navigation
    
    Pane: "main"
        * Blog post 1
        * Blog post 2
        * Blog post 3
        * Blog post 4
        * Blog post 5
    
    Pane: "sidebar"
        * Search
        * Tag Cloud 
        * Newsletter Signup
        * Calendar
        
    Pane: "foot1"
        * Blogroll
        
    Pane: "foot2"
        * Affiliates
        
    Pane: "foot3"
        * Contact info
        
    Pane: "subfoot"
        * Copyright notice
    
    4.  Deferred JS imports
    -------------------
    Since importing JavaScripts halts the browser
    rendering until the resource is available this is
    where we want to import the bulk of our js files.
    
    This is also the recommended slot in the HTML-page
    for including JQuery framework.

    5.  Deferred JavaScript snippets
    ----------------------------
    These are the code fragments that executes the
    JavaScript on the page.
    
    The Google Analytics tracker JavaScript snippet
    would normally be placed here.

    </body>
    </html>

However why not think of the entire HTML-page in terms of "panes". That way
there will be a "pane" for including CSS, a pane for including "JavaScript" and
so on.

This is exactly how the Modulaise tools suite is build, by creating a page
template that has only panes in it, which in turn has modules in them.


<a name="annotated_html_layout"/>

### Annotated detailed HTML-page anatomy

This is the Layout of a Modulaise HTML-page. You will notice that there are
specific references in this figure to module folders.

This will become clearer, after seeing the anatomy of a module in play, for
now take a look at the panes:

    <!doctype html>
    <head>
    
    Pane: "PANE_CSS" - module/css
    
          Either printing each CSS import statement (development mode)
          or printing one CSS import statements to a concatinated and 
          minified CSS file (export build mode).
          
          Inclusion scope: All CSS inside all modules are included.
    
          
    Pane: "PANE_HTML_HEAD_FIRST" - module/html_head_x, x < 50
          
          Printing HTML snippets placed in the module folder
          "html_head_00" to "html_head_49". Included for added 
          flexibility, i.e. you may print CSS imports, JavaScript
          snippets or JS import statements that does not fit
          into the Modulaise suite.
          
          Inclusion scope: Only global modules, and included modules.
    
    
    Pane: "PANE_JS_HEAD" - module/js_head
    
          Either printing each JS import statement (development mode)
          or printing one JS import statement to a concatinated and 
          minified JS file (export build mode).
          
          Inclusion scope: All JS inside all modules are included.
    
    
    Pane: "PANE_HTML_HEAD_LAST" - module/html_head_x, x > 49
          
          Printing HTML snippets placed in the module folder
          "html_head" and "html_head_50" to "html_head_99". Included 
          for added flexibility, i.e. you may print CSS imports, 
          JavaScript snippets or JS import statements that does not fit
          into the Modulaise suite.

          Inclusion scope: Only global modules, and included modules.
    
    </head>
    <body>
    
    Pane: "head"
    Pane: "main"
    Pane: "sidebar"
    Pane: "foot1"
    Pane: "foot2"
    Pane: "foot3"
    Pane: "subfoot"
    
    
    Pane: "PANE_HTML_FOOT_FIRST" - module/html_foot_x, x < 50
    
          Printing HTML snippets placed in the module folder
          "html_foot_00" to "html_foot_49". Included 
          for added flexibility, i.e. you may print JavaScript snippets
          or JS import statements that does not fit into the Modulaise suite.

          Inclusion scope: Only global modules, and included modules.
    
              
    Pane: "PANE_JS_FOOT" - module/js_foot

          Either printing each JS import statement (development mode)
          or printing one JS import statement to a concatinated and 
          minified JS file (export build mode).

          Inclusion scope: All JS inside all modules are included.
    
    
    Pane: "PANE_HTML_FOOT_LAST" - module/html_foot_x, x > 49

          Printing HTML snippets placed in the module folder
          "html_foot" and "html_foot_50" to "html_foot_99". Included 
          for added flexibility, i.e. you may print JavaScript snippets
          or JS import statements that does not fit into the Modulaise suite.

          Inclusion scope: Only global modules, and included modules.
              
    </body>
    </html>

You may notice, that there are several extra panes for importing HTML snippets,
these are included to make sure the suite is as flexible as possible.


<a name="working_with_templates"/>

Working with templates
-------------------------------------------------------------------------------

In order to render a page, you are going to need a template, it allows you to 
render an HTML-page as seen above.

By using the "panes" metaphore it also forces you to think about what kind of
content is placed in your page.

The templates are placed in the ``../WebContent/templates/`` folder, and they
are ordinary PHP files.


<a name="example_template"/>

### An example Template

In the tutorial you used the template ``../WebContent/templates/wide.php`` 
to render your page:

    <?php include '_head.php';?>
    <?php ModulaiseController::printPane("head"); ?>
    <?php ModulaiseController::printPane("main"); ?>
    <br clear="all" />
    <hr />
    <h2>Footer</h2>
    <?php ModulaiseController::printPane("foot"); ?>
    <?php  if (ModulaiseController::paneHasContent("extra")){ ?>
    <br clear="all" />
    <div class="pane-extra">
    <h2>Extra</h2>
    <?php ModulaiseController::printPane("extra"); ?>
    </div>
    <?php } ?>
    <?php include '_foot.php';?>

As you can see there's a few PHP functions being called.

The ``include '_head.php';`` and ``include '_foot.php';`` are standard PHP
inclusion calls, that includes a standard "header" and "footer" for the
page.

Also note that we are printing the pane "extra" only if it has content, for
an overview functions are available from within the ``ModulaiseController``
please refer to the [ModulaiseController documentation][1].

This is handy, if you want to create a single unified template for all
of your publishing needs, this can make the integration into a backend system
easier.


<a name="head_and_foot"/>

### Header and footer

If you are going to work on several templates, this divison makes sense
since you are probably going to want the same head and bottom part of
your html page.

Then there are the PHP calls ``ModulaiseController::printPane("head");``,
these calls prints out one of the panes you have defined in your page.

It is up to you to put the pane contents inside meaningfull HTML-markup,
right now any page printed with this template gets the ``<h2>Footer</h2>``
html-tag right before the "foot" pane.

Take a look at the ``_head.php`` and ``_foot.php``:

    # _head.php file
    
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
    <title><?php ModulaiseController::printPageTitle(); ?></title>
    <meta name="description" content="">
    <meta name="author" content="">
    <?php ModulaiseController::printComment("Mobile viewport optimized: j.mp/bplateviewport"); ?>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php ModulaiseController::printComment("Import css stylesheets"); ?>
    <?php ModulaiseController::printPane(PANE_CSS); ?>
    <?php ModulaiseController::printComment("Print first HTML head snippets"); ?>
    <?php ModulaiseController::printPane(PANE_HTML_HEAD_FIRST); ?>
    <?php ModulaiseController::printComment("Import head javascript javascripts"); ?>
    <?php ModulaiseController::printPane(PANE_JS_HEAD); ?>
    <?php ModulaiseController::printComment("Print last HTML snippets"); ?>
    <?php ModulaiseController::printPane(PANE_HTML_HEAD_LAST); ?>
    
    </head>
    <body>
    
    # _foot.php file
    
    <?php ModulaiseController::printComment("Print first HTML snippets"); ?>
    <?php ModulaiseController::printPane(PANE_HTML_FOOT_FIRST); ?>
    <?php ModulaiseController::printComment("Import FOOT JavaScript"); ?>
    <?php ModulaiseController::printPane(PANE_JS_FOOT); ?>
    <?php ModulaiseController::printComment("Print last HTML snippets"); ?>
    <?php ModulaiseController::printPane(PANE_HTML_FOOT_LAST); ?>
    </body>
    </html>

As you can see we are actually printing the system panes here. The [System
Panes](#system_panes) will be detailed at the end of this page.

<a name="system_panes"/>

### System Panes

Now things get a little more interesting, here we are actually starting the
HTML-page and printing out the System Panes:

    <?php ModulaiseController::printPane(PANE_CSS); ?>
    <?php ModulaiseController::printPane(PANE_HTML_HEAD_FIRST); ?>
    <?php ModulaiseController::printPane(PANE_JS_HEAD); ?>
    <?php ModulaiseController::printPane(PANE_HTML_HEAD_LAST); ?>
    <?php ModulaiseController::printPane(PANE_HTML_FOOT_FIRST); ?>
    <?php ModulaiseController::printPane(PANE_JS_FOOT); ?>
    <?php ModulaiseController::printPane(PANE_HTML_FOOT_LAST); ?>

These panes are all system panes constructed from the contents of the modules 
in your projects ``sc`` folder. You may also see the
[Annotated detailed HTML-page anatomy](#annotated_html_layout) to get a feel
for the different System Panes.


<a name="working_with_pages"/>

Working with Pages
-------------------------------------------------------------------------------

Every module you make goes into a pane, panes are put into pages and pages
are rendered using templates. This chapter outlines how to work with pages.


<a name="creating_a_page"/>

### Creating a Page

Follow these steps to create a new page.

1.  In your Eclipse Project Explorer pane, locate the build.xml file
    in the root folder of your tutorial project.
    
    Run the task "New Page".

2.  Call your page "blank_d", and choose "yes" to create the page.

    This copies the file from the folder:

       ../modulaise/boilerplates/pages/blank/index.php

    Into:
        
        ../tutorial/WebContent/pages/blank_d.php
    
    This is handy as you may define your own page templates in this
    folder for rapid pagetemplating.

3.  Browse to [http://tutorial.localhost](http://tutorial.localhost)
    and check out your new page by clicking "blank_d".
    
That is it, you succesfully created a page.


<a name="example_page"/>

### An example Page

Let's check out the contents of your newly created page:

    <?php 
    
    // Include controller
    require_once ($_SERVER["DOCUMENT_ROOT"].DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."modulaise".DIRECTORY_SEPARATOR."scripts".DIRECTORY_SEPARATOR."php".DIRECTORY_SEPARATOR."modulaise-controller.php");
        
    // Create a page using one of the template files from the templates folder
    ModulaiseController::createPage("wide.php",basename(__FILE__,".php"));
    
    // define page contents
    ModulaiseController::addModule("head","bla_blank","alternative.html");
    ModulaiseController::addModule("head","bla_blank");
    
    // define page contents
    ModulaiseController::addModule("foot","bla_blank","alternative.html");
    ModulaiseController::addModule("foot","bla_blank");
    ModulaiseController::addModule("foot","bla_blank","alternative.html");
    ModulaiseController::addModule("foot","bla_blank");
    ModulaiseController::addModule("foot","bla_blank","alternative.html");
    ModulaiseController::addModule("foot","bla_blank");
    
    // print the page
    ModulaiseController::printPage();
    
    ?>

This is plain PHP, and I will go through each of the different calls used
here.

The following commands sets up the Modulaise environment, and should not
be modified:

    // Include controller
    require_once ($_SERVER["DOCUMENT_ROOT"].DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."modulaise".DIRECTORY_SEPARATOR."scripts".DIRECTORY_SEPARATOR."php".DIRECTORY_SEPARATOR."modulaise-controller.php");

To create a new page, you use this command:

    // Create a page using one of the template files from the templates folder
    ModulaiseController::createPage("wide.php",basename(__FILE__,".php"));

This creates a new page using the ``wide.php`` template from the ``templates``
folder and gives the page the name of the current executing PHP script file.
In this case ``blank_d``.

This section adds modules to your page:

    // define page contents
    ModulaiseController::addModule("head","bla_blank","alternative.html");
    ModulaiseController::addModule("head","bla_blank");
    
    // define page contents
    ModulaiseController::addModule("foot","bla_blank","alternative.html");
    ModulaiseController::addModule("foot","bla_blank");
    ModulaiseController::addModule("foot","bla_blank","alternative.html");
    ModulaiseController::addModule("foot","bla_blank");
    ModulaiseController::addModule("foot","bla_blank","alternative.html");
    ModulaiseController::addModule("foot","bla_blank");

<a name="working_with_panes"/>

Working with Panes 
-------------------------------------------------------------------------------

In the [Working with templates](#working_with_templates) and
[Working with Pages](#working_with_pages) you have seen how to add modules to
Panes and how to print Panes.

This is repeated here for referral.


<a name="creating_a_pane"/>

### Creating a Pane

You will usually create a Pane in your Page file. You don't need to do anything
before setting up your pane, just add the module like this, and the Pane
``head`` is automatically created if it didn't exist:

    // define page contents
    ModulaiseController::addModule("head","bla_blank","alternative.html");

The ``ModulaiseController::addModule($paneId,$moduleId,$overrideHtmlSnippet=NULL);``
call adds module ``$moduleId`` to pane ``$paneId`` and if there is a third
argument passed to this function it uses the ``$overrideHtmlSnippet`` to render
the module in the pane.

So the call ``ModulaiseController::addModule("head","bla_blank","alternative.html");``
adds the ``bla_blank`` module to the pane ``head`` and when the module is
rendered in the page by a call to  ``<?php ModulaiseController::printPane("head"); ?>``
it uses the ``alternative-html`` from the ``html`` folder in the module folder
to render the module.

Also any payloads in the ``html_head`` and ``html_foot`` folders fromt the
``bla_blank`` module folder gets included into the System Panes automatically
when this module is being added to the pane.


<a name="printing_a_pane"/>

### Printing a Pane
 
You will usually print your pane in your Template, by calling something like
this:

    <?php ModulaiseController::printPane(PANE_CSS); ?>

This prints the System Pane ``PANE_CSS`` containing import statements to your
stylesheets.

To print a Pane you defined yourself, do something like this:

    <?php  if (ModulaiseController::paneHasContent("extra")){ ?>
    <br clear="all" />
    <div class="pane-extra">
    <h2>Extra</h2>
    <?php ModulaiseController::printPane("extra"); ?>
    </div>
    <?php } ?>

This prints the Pane "extra" with some HTML-markup around it, if and only if
the Pane "extra" has contents in it.


<a name="system_panes"/>

### System Panes

The modules you are including into your page may depend on CSS and
JavaScript to work as intended. 

But we don't want module specific code to be placed anywhere but
inside the module folder.

That is exactly why we have the System Panes, these Panes includes all
the resources from the module.

You may want to add a JavaScript snippet at the end of the HTML-page
initializing your module? No problem - in your module create a folder 
``html_foot`` and place an HTML file inside it. When including said
module into your page, that HTML file gets printed at the bottom of
your HTML-page.

Basically there are two kinds of modules you should be aware of,
the "global" modules, which are included on every page, and the 
"common" modules that are only included on the pages if you
include them. Read the [online documentation][3] for further
information about modules.

Here is a list of the System Panes, and what goes into the System
Panes.


<a name="PANE_CSS"/>

#### ``PANE_CSS``

Either printing each CSS import statement (development mode) or printing one
CSS import statements to a concatinated and minified CSS file (export 
build mode). This free's you from thinking about how to import your
stylesheets, and makes it a easy to debug your CSS as all the origin of any
style can be traced to a specific stylesheet in tools like [Firebug][2].


All CSS inside the all modules in your module folder ``sc`` is included in
this pane.

The order of inclusion can be determined by adding a number to your ``css`` 
folders inside your module. For instance the styles in folder ``css_34`` 
are included before the styles in folder ``css_45``.


<a name="PANE_HTML_HEAD_FIRST"/>

#### ``PANE_HTML_HEAD_FIRST``

Printing HTML snippets placed in the module folder ``html_head_00`` to 
``html_head_49``. Included for added flexibility, i.e. you may print CSS 
imports, JavaScript snippets or JS import statements that does not fit
into the Modulaise suite.
  
Only HTML snippets from global modules and modules specifically included
in the page is being rendered in this pane.


<a name="PANE_JS_HEAD"/>

#### ``PANE_JS_HEAD``

Either printing each JS import statement (development mode) or printing 
one JS import statement to a concatinated and minified JS file 
(export build mode).

All JavaScript inside the ``js_head`` folders in your module folder ``sc``
are included in this pane.

The order of inclusion can be determined by adding a number to your 
``js_head`` folders inside your module. For instance the styles in folder 
``js_head_34`` are included before the styles in folder ``js_head_45``.


<a name="PANE_HTML_HEAD_LAST"/>

#### ``PANE_HTML_HEAD_LAST``

Printing HTML snippets placed in the module folder ``html_head_50`` to 
``html_head_99``. Included for added flexibility, i.e. you may print CSS 
imports, JavaScript snippets or JS import statements that does not fit
into the Modulaise suite.
  
Only HTML snippets from global modules and modules specifically included
in the page is being rendered in this pane.


<a name="PANE_HTML_FOOT_FIRST"/>

#### ``PANE_HTML_FOOT_FIRST``

Printing HTML snippets placed in the module folder ``html_foot_00`` to 
``html_foot_49``. Included for added flexibility, i.e. you may print CSS 
imports, JavaScript snippets or JS import statements that does not fit
into the Modulaise suite.
  
Only HTML snippets from global modules and modules specifically included
in the page is being rendered in this pane.


<a name="PANE_JS_FOOT"/>

#### ``PANE_JS_FOOT``

Either printing each JS import statement (development mode) or printing 
one JS import statement to a concatinated and minified JS file 
(export build mode).

All JavaScript inside the ``js_foot`` folders in your module folder ``sc``
are included in this pane.

The order of inclusion can be determined by adding a number to your 
``js_foot`` folders inside your module. For instance the styles in folder 
``js_foot_34`` are included before the styles in folder ``js_foot_45``.


<a name="PANE_HTML_FOOT_LAST"/>

#### ``PANE_HTML_FOOT_LAST``

Printing HTML snippets placed in the module folder ``html_foot_50`` to 
``html_foot_99``. Included for added flexibility, i.e. you may print CSS 
imports, JavaScript snippets or JS import statements that does not fit
into the Modulaise suite.
  
Only HTML snippets from global modules and modules specifically included
in the page is being rendered in this pane.


<a name="revision_history"/>

Revision History 
-------------------------------------------------------------------------------

*   20110108, [Lars Jensen](mailto:lars.jensen@exenova.dk)

    Created the document.


[1]:  https://github.com/larjen/modulaise/blob/master/docs/modulaise_controller.md
      "Modulaise Controller Documentation"
[2]:  http://getfirebug.com/
      "Get Firebug"
[3]:  https://github.com/larjen/modulaise/blob/master/docs/module.md
      "Module Documentation"