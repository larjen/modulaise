
Module
===============================================================================

Understanding how modules are created and works is imperative to working with
the Modulaise tools suite. Fortunately, the module structure is not rocket
science, the anatomy of modules are made explicitly simple as to simplify
working with them.


Table of Contents
-------------------------------------------------------------------------------

*   [Definition of a Module](#module_definition)
*   [Global modules or included modules, what is the difference?](#global_or_common_modules)
*   [Creating a Module](#module_create)
*   [Module Directory Structure](#module_dir)
*   [Strategies for encapsulating your Modules](#module_encapsulation)
    *   [CSS encapsulation](#css_encapsulation)
    *   [Use global modules for global stuff like typography, boxes and buttons](#lateral_modules)
    *   [JavaScript encapsulation](#js_encapsulation)
*   [Using CSS Media Queries in your Modules](#media_queries)
*   [Module Boilerplates](#boilerplate_modules)
*   [Module examples](#module_examples)
    *   [0_js_jQuery](#0_js_jQuery)
    *   [0-gr-grid-cssgrid.net](#0-gr-grid-cssgrid.net)
*   [Revision History](#revision_history)


<a name="module_definition"/>

Definition of a Module
-------------------------------------------------------------------------------

By default a Module is defined as the contents of it's folder, usually placed
inside the ``../WebContent/sc/`` folder.

For reusability and maintainability purposes put all image files, flash files,
photoshop files and so on inside this folder.


<a name="global_or_common_modules"/>

Global modules or included modules, what is the difference?
-------------------------------------------------------------------------------

Some modules you will always need to include in your page, for instance jQuery 
would always be needed to be included in your page, thus we will distinguish 
between global and normal modules.

Another way of putting it is that normal modules are only included in a 
specific page, while global modules are silently included on all pages.

Global modules has a name that starts with "0" (zero), normal modules have names
that starts with anything else.

An edge case is the "excluded" module that starts with a "-" (hyphen), this
module is excluded from being included in any CSS and JS concatination and
minification process.

    Modulename: "0_js_jQuery"
    
                Global module included on every page.
    
    Modulename: "foo_fooBar"
                
                Normal module, only included specifically.
                
    Modulename: "_compiled"
                
                Excluded module, never included in any
                concatination and minification procedures.


<a name="module_create"/>

Creating a Module
-------------------------------------------------------------------------------

Follow these steps to create a new module.

1.  In your Eclipse Project Explorer pane, locate the build.xml file
    in the root folder of your "tutorial" project.
    
    Run the task "New Module".
    
2.  Choose the template "bla_blank".

3.  Input short name as "foo".

4.  Input long name as "fooBar"

5.  Choose yes to create your new module.

    This copies files from the folder:

        ../modulaise/boilerplates/modules/bla_blank/*
    
    Into:
    
        ../tutorial/WebContent/sc/foo_fooBar/*
    
    While also replacing a number of text-strings. By exploring the
    boilerplate folder, you can see how modules can be made, thus
    making your modules portable between projects.

If you follow these steps, you have put a new folder into your ``sc``
folder called ``foo_fooBar`` containing all the stuff that makes
a module.

Please note, that you could also have just created a new folder and
populated it with contents without running the Ant task from the
build.xml file.


<a name="module_dir"/>

Module Directory Structure
-------------------------------------------------------------------------------

It is highly recommended for you to take a look at the [anatomy of an HTML-page][1]
before proceeding furter, which gives you an understanding of the rationale of
the anatomy of the module.

Let us take at look at the annotated module. In the tutorial you created a 
module called "foo_fooBar".

This module was placed into your ``sc`` folder, and it had a folder structure
like this:

                                                                       | Targetpane              | Common     | Global     |
                                                                       +-------------------------+------------+------------+
    foo_fooBar/  - - - - Name of the module. In this case the          |                         |            |            |
    |                    module has a shortname of "foo" and a         |                         |            |            |
    |                    long name of "fooBar".                        |                         |            |            |
    |                                                                  |                         |            |            |
    + css/ - - - - - - - CSS files with a priority of                  | PANE_CSS                | Always     | Always     |
    |                    default = 75                                  |                         |            |            |
    |                                                                  |                         |            |            |
    + css_10/  - - - - - CSS files with a priority = 10                | PANE_CSS                | Always     | Always     |
    |                                                                  |                         |            |            |
    + css_90/  - - - - - CSS files with a priority = 90                | PANE_CSS                | Always     | Always     |
    |                                                                  |                         |            |            |
    + html/  - - - - - - HTML files                                    | user specified          | n/a        | n/a        |
    |                                                                  |                         |            |            |
    + html_foot/ - - - - HTML files for inclusion in foot pane         | PANE_HTML_FOOT_LAST     | If present | Always     |
    |                    with priority of default = 75                 |                         |            |            |
    |                                                                  |                         |            |            |
    + html_foot_10/  - - HTML files for inclusion in foot pane         | PANE_HTML_FOOT_FIRST    | If present | Always     |
    |                    with a priority of 10                         |                         |            |            |
    |                                                                  |                         |            |            |
    + html_foot_90/  - - HTML files for inclusion in foot pane         | PANE_HTML_FOOT_LAST     | If present | Always     |
    |                    with a priority of 90                         |                         |            |            |
    |                                                                  |                         |            |            |
    + html_head/ - - - - HTML head files with a priority of            | PANE_HTML_HEAD_LAST     | If present | Always     |
    |                    default = 75                                  |                         |            |            |
    |                                                                  |                         |            |            |
    + html_head_10/  - - HTML foot files with a priority of 10         | PANE_HTML_HEAD_FIRST    | If present | Always     |
    |                                                                  |                         |            |            |
    + html_head_90/  - - HTML foot files with a priority of 90         | PANE_HTML_HEAD_LAST     | If present | Always     |
    |                                                                  |                         |            |            |
    + img/ - - - - - - - Images                                        | n/a                     |            |            |
    |                                                                  |                         |            |            |
    + js_foot/ - - - - - JS foot files with a priority of              | PANE_JS_FOOT            | Always     | Always     |
    |                    default = 75                                  |                         |            |            |
    |                                                                  |                         |            |            |
    + js_foot_10/  - - - JS foot files with a priority of 10           | PANE_JS_FOOT            | Always     | Always     |
    |                                                                  |                         |            |            |
    + js_foot_90/  - - - JS foot files with a priority of 90           | PANE_JS_FOOT            | Always     | Always     |
    |                                                                  |                         |            |            |
    + js_head/ - - - - - JS head files with a priority of              | PANE_JS_HEAD            | Always     | Always     |
    |                    default = 75                                  |                         |            |            |
    |                                                                  |                         |            |            |
    + js_head_10/  - - - JS head files with a priority of 10           | PANE_JS_HEAD            | Always     | Always     |
    |                                                                  |                         |            |            |
    + js_head_90/  - - - JS head files with a priority of 90           | PANE_JS_HEAD            | Always     | Always     |

All of these folders are optional. Only include the ones you need, or if you
are starting from one of the boilerplate modules, delete all of the unneeded
folders.

When the concatination process begins, or when the page is constructed, the
system will automatically concatinate and minify the CSS and JS in the order
of priority.

The HTML snippets are not concatinated, but the priority value is then used
to determine the order in which the snippets are printed.


<a name="module_encapsulation"/>

Strategies for encapsulating your Modules
-------------------------------------------------------------------------------

If you want to be able to maintain and debug frontend code, especially as you
develop in collaboration with other team members, it will be instrumental to
lay down some common ground rules, and make your own up as you go along.

By using [http://html5boilerplate.com/][3] as a starting point for your 
project, you are off to a good start. Also consider adhering to these
[front-end coding standards and best practices][5], so as to minimuze the
effort of taking over eachothers code.

Apart from dividing your front end code into modules by modularization, 
I highly recommend that you consider using these strategies to further 
take advantage of the Modulaise modules system.


<a name="css_encapsulation"/>

### CSS encapsulation

When you created your module using the build.xml file you were given an
opportunity to give the module a shortname.

You could use this shortname to prefix all of your CSS rules, that way
whenever you see a CSS class in your code, you will immediately know
in which module it is declared.

This could look something like this:

    .bla {
	    width: 30%;
    }
    
    .bla-alt {
	    background-color: yellow;
    }
    
    .bla-inner {
	    border: 2px dotted red;
    } 

Also seriously consider to wrap you HTML module markup inside a div
with a class of the shortname. For instance:

    <div class="bla bla-alt">
        <h3>This is the module</h3>
        <a class="btn-callTo">Click to say hello</a>
    </div> 

That way you could target the ``h3`` element within your css file like this:

    .bla h3 {margin:10px;}

However performance wise, this may not be your best option for 
[browser rendering speed][4].


<a name="lateral_modules"/>

### Use global modules for global stuff like typography, boxes and buttons

When designing front end code, some elements tends to live globally. For
instance typography, boxes and buttons.

By all means create global modules to help you construct these elements.

For buttons you could create a module called ``btn-buttons``, and set up
the styles for buttons inside this module.


<a name="js_encapsulation"/>

### JavaScript encapsulation

Prefixing your JavaScript functions with the shortname also makes it
easier for you to figure out where to look when you are debugging.

Also keep in mind, that ALL JavaScript files in the JavaScript folders
are imported into your project, making it obvious for yout to split
your JavaScript files into sensible files.


<a name="media_queries"/>

Using CSS Media Queries in your Modules
-------------------------------------------------------------------------------

Creating a responsive webpage using [media queries][2] is built into the 
Modulaise tools suite.

If you take a look at the ``css`` folders in the "foo_fooBar" module you
created in the tutorial, you will see the following files:

    # /css/ (remember this folder has a default priority id of 75)
    
    all.css
    all and (orientation..landscape).css
    all and (orientation..portrait).css
    handheld.css
    print.css
    screen and (max-device-width..480px).css
    screen and (max-width..600px).css
    
    # /css_10/
    
    all.css
    
    # /css_90/
    
    all.css
    screen and (max-width..300px).css

As you can probably guess each of these files corresponds to a CSS media
query, just strip the ``.css`` from the end of the file and replace the
``..`` with a colon (:).

Notice that we have a folder css_90 for including the max-width: 300px
stylesheet. This stylesheet gets imported after the stylesheet with
max-width: 600px, and here the order of inclusion really matters.

If we imported them in reverse order, and we had a screen size below
300px wide, the 300px wide stylesheet would not override the 600px wide
stylesheet, thus making the browser ignore it!


<a name="boilerplate_modules"/>

Module Boilerplates
-------------------------------------------------------------------------------

If you use the build.xml file to create a new module, it automatically gives
you the option to create your new module from one of the boilerplate modules
in the folder ``../modulaise/boilerplates/modules/``.

You may create a new boilerplate by placing a new module complete with all
subdirectories in this folder.

A few pointers though, in able to create the new module a set of variables
are being renamed in all files inside your boilerplate module. To make
sure the module is set up for immediate use, refer to this table
to get the variable naming correct:

    __MODULE_SHORTNAME__   is replaced by    The short name for the module
    __MODULE_LONGNAME__    is replaced by    The long name of the module
    __MODULE_FULLNAME__    is replaced by    The full name of the module


<a name="module_examples"/>

Module examples
-------------------------------------------------------------------------------

These are couple of examples of modules.


<a name="0_js_jQuery"/>

### 0_js_jQuery

This module, when present in your ``sc`` folder will include the JQuery
JavaScript framework on all pages.

These are the files in the module:

    0_js_jQuery/
    |
    + html_foot_00/index.html  - - - HTML file.
    |
    + js_x/jquery-1.4.2.min.js - - - Minified JavaScript file.

If we take a look at the ``index.html`` file it contains:

    <?php ModulaiseController::printComment("Grab Google CDN's jQuery. fall back to local if necessary"); ?>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.js"></script> 
    <script>!window.jQuery && document.write(unescape('%3Cscript src="<?php ModulaiseController::printStaticContentPath(); ?>0_js_jQuery/js_x/jquery-1.4.2.min.js"%3E%3C/script%3E'))</script> 

As you may recognize this is lovingly lifted from the [html5boilerplate][3]
project.

The first line is a php call that prints a comment in the page. On the next
line we try to include the JQuery framework from Google's CDN, in case that
fails, the fallback is to include it from the local repository.

This happens in line 3. Please notice the command to print the static content
path in line 3:

    <?php ModulaiseController::printStaticContentPath(); ?>

This ensures the right path is printed, according to your wishes.

The folder named ``html_foot_00`` will always place the HTML-snippets inside
at the very beginning of the pane called ``PANE_HTML_FOOT_FIRST``.

If we want to swith the inclusion to inside the <head> element, simply rename
the folder to ``html_head_00`` and reload your page - the module should now
have switched.

Also note the JS folder is called ``js_x``, this is to prevent the folder
from being included in any concatination and minification build procedures.
When included in your ``sc`` folder this module, since it is global will
always be included on your pages.


<a name="0-gr-grid-cssgrid.net"/>

### 0-gr-grid-cssgrid.net

This module, when present in your ``sc`` folder will include a css grid
for all of your pages.

These are the files in the module:

    0-gr-grid-cssgrid.net/
    |
    + css_10/all.css - - - - - - - - - - - - - - - - - - - - - - - CSS file.
    |
    + css_10/handheld, only screen and (max-width.. 767px).css - - CSS file with @media handheld, only screen and (max-width: 767px)
    |
    + css_10/only screen and (max-width.. 1023px).css  - - - - - - CSS file with @media only screen and (max-width: 1023px)

This module has no HTML contents.


<a name="revision_history"/>

Revision History
-------------------------------------------------------------------------------

*   20110108, [Lars Jensen](mailto:lars.jensen@exenova.dk)

    Created the document.

[1]:  https://github.com/larjen/modulaise/blob/master/docs/template.md#annotated_html_layout
      "Annotated HTML-page" 
[2]:  http://www.w3.org/TR/css3-mediaqueries/#media0
      "Media Queries, W3C Candidate Recommendation"
[3]:  http://html5boilerplate.com
      "HTML5 - BOILERPLATE"
[4]:  http://code.google.com/speed/page-speed/docs/rendering.html
      "Browser rendering speed"
[5]:  http://na.isobar.com/standards/
      "Front-end coding standards and best practices"