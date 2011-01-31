
Modulaise Controller
===============================================================================

This is a quickreference for the functions in the Modulaise Controller. 


Table of Contents
-------------------------------------------------------------------------------

*   [ModulaiseController::addModule($paneId,$moduleId,$overrideHtmlSnippet=NULL);](#addModule)    
*   [ModulaiseController::createPage($templateId,$pageTitle);](#createPage)
*   [ModulaiseController::getPaneNames(); returns Array](#getPaneNames)
*   [ModulaiseController::initialize();](#initialize)
*   [ModulaiseController::paneHasContent($paneId);](#paneHasContent)
*   [ModulaiseController::printComment($comment);](#printComment)
*   [ModulaiseController::printPage();](#printPage)
*   [ModulaiseController::printPageTitle();](#printPageTitle)
*   [ModulaiseController::printPane($paneId)](#printPane)
*   [ModulaiseController::printStaticContentPath();](#printStaticContentPath)
*   [Revision History](#revision_history)


<a name="addModule"/>

ModulaiseController::addModule($paneId,$moduleId,$overrideHtmlSnippet=NULL);
-------------------------------------------------------------------------------

Adds a module to a pane.

*   $paneId (string):
    
    The pane to which the module is added, if the pane does not exist it will 
    be created for you.
    
*   $moduleId (string): 
    
    The foldername of the modulename. This is the same as the foldername 
    containing the module.
     
*   $overrideHtmlSnippet (string): 
    
    Optional, if you omit this parameter the system will add the module to 
    the pane and try using the ``index.html`` file in the ``html`` folder to 
    print the module. If instead you want to print the ``alternative.html`` 
    file in the ``html`` use this parameter.
    
### Example usage

    // Add a module "p2-pepito" to the "head" pane. 
    ModulaiseController::addModule("head","p2-pepito");

### Example usage

    // Add a module "srch-searchBox" to the pane "main". Use the
    // "frontpage.html" to render the module.
    ModulaiseController::addModule("main","srch-searchBox","frontpage.html");


<a name="createPage"/>

ModulaiseController::createPage($templateId,$pageTitle);
-------------------------------------------------------------------------------

Creates a new page.

*  $templateId (string): 
   
   Name of the template php file from the ``templates`` folder used for 
   displaying the page.

*  $pageTitle (string):
   
   A title for the page.

Creates a new page, must be called before adding any modules to the panes in
the page.

### Example usage

    // Create a page using the "w.php" file from the "template" folder as
    // template for rendering the page. Give the page the same title
    // as the file. (In php __FILE__ refers to the current script file.)
    
    ModulaiseController::createPage("w.php",basename(__FILE__,".php"));

### Example usage

    // Create a page using the "index.php" file from the "template" folder as
    // template for rendering the page. Give the page the title "Frontpage"
    
    ModulaiseController::createPage("index.php","Frontpage");


<a name="getPaneNames"/>

ModulaiseController::getPaneNames(); returns Array
-------------------------------------------------------------------------------

Returns an array of all the pane names for the current page.

### Example usage

    // Print all the pane names
    
    <?php
    $panenames = ModulaiseController::getPaneNames();
    echo "<ul>";
    foreach($panenames as $panename){
      echo "<li>".$panename;
      if (!ModulaiseController::paneHasContent($panename)){
        echo " (empty)";
      }
      echo "</li>";
    }
    echo "</ul>";
    ?>


<a name="initialize"/>

ModulaiseController::initialize();
-------------------------------------------------------------------------------

Initializes the controller, reads all global modules and prepares the
controller to create new pages.


<a name="paneHasContent"/>

ModulaiseController::paneHasContent($paneId);
-------------------------------------------------------------------------------

Checks to see if the pane with $paneId has content, returns true if the pane
has contents, returns false if it is empty.

*   $paneId (string):
    
    The $paneId you want to check for contents.

### Example usage

    // Only print the pane "sidebar2" if the pane has content.
    <?php
    if (ModulaiseController::paneHasContent("sidebar2")){
      ModulaiseController::printPane("sidebar2");
    }
    ?>


<a name="printComment"/>

ModulaiseController::printComment($comment);
-------------------------------------------------------------------------------

Prints a comment.

*   $comment (string):
    
    The comment to print.

### Example usage

    // Print hello
    <?php ModulaiseController::printComment("hello"); ?>


<a name="printPage"/>

ModulaiseController::printPage();
-------------------------------------------------------------------------------

Prints the current page, makes the most sense to call after all of your modules
have been added to your panes.


<a name="printPageTitle"/>

ModulaiseController::printPageTitle();
-------------------------------------------------------------------------------

Prints the page title.


<a name="printPane"/>

ModulaiseController::printPane($paneId)
-------------------------------------------------------------------------------

Prints a pane.

*   $paneId (string):
    
    This prints the pane with $paneId.

### Example usage

The following snippet prints the CSS imports, please notice that this is a
systems pane, and it therefore is called using the constant ``PANE_CSS``.

    // Print the CSS imports
    <?php ModulaiseController::printPane(PANE_CSS); ?>

Here are all of the names for the system panes:

*   ``PANE_CSS``
*   ``PANE_HTML_HEAD_FIRST``
*   ``PANE_JS_HEAD``
*   ``PANE_HTML_HEAD_LAST``
*   ``PANE_HTML_FOOT_FIRST``
*   ``PANE_JS_FOOT``
*   ``PANE_HTML_FOOT_LAST``

As you may have guessed you are free to print these system panes anytime
you like in your templates.

### Example usage

    // Print the "main" pane
    <?php ModulaiseController::printPane("main"); ?>


<a name="printStaticContentPath"/>

ModulaiseController::printStaticContentPath();
-------------------------------------------------------------------------------

Prints the static content path. Please notice that you may want to check
the value ``PATH_MODULES_BUILD`` and ``PATH_MODULES_DEVELOPMENT`` in the 
config file at ``config-project/project.config``.

These are used to print the correct path to CSS, JavaScript and images when
the page is rendered.

You may change these settings to whatever you like, but the default values 
are set to:

    # Static path to pages when compiling static pages
    PATH_MODULES_BUILD = ../../sc/
    
    # Dynamic path to pages when creating them dynamically on the fly and serving them from server
    PATH_MODULES_DEVELOPMENT = /sc/

### Example usage

    // print the image "..sc/logo_ModulaiseLogo/img/logo-light-small.png"
    // and adjust the path automatically for build procedures
    <img class="logo-img" src="<?php ModulaiseController::printStaticContentPath(); ?>logo_ModulaiseLogo/img/logo-light-small.png" alt="Modulaise" width="129" height="20" />


<a name="revision_history"/>

Revision History
-------------------------------------------------------------------------------

*   20110106, [Lars Jensen](mailto:lars.jensen@exenova.dk)

    Created the document.

*   20110108, [Lars Jensen](mailto:lars.jensen@exenova.dk)

    Added table of contents.
  