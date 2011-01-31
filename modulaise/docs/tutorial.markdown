
Tutorial
===============================================================================

This tutorial will take you around 20 - 30 minutes to complete, after which
you should have a basic insight into how the Modulaise tools suite can
effectlively help you organize your frontend coding.

If you haven't already installed the Modulaise tools suite, please refer to
[the installation instructions][4]


Table of Contents
-------------------------------------------------------------------------------

*  [Creating a new Project](#project_create)
*  [Creating a new page](#page_create)
*  [Creating a new module](#module_create)
*  [Modifying your module](#module_modify)
*  [Creating a build](#create_build)
*  [Deploying your build](#deploying_build)
    *  [Creating a new Deploy target](#create_deploy_target)
    *  [Deploying your build](#deploying_build)
*  [Revision History](#revision_history)


<a name="project_create"/>

Creating a new project
-------------------------------------------------------------------------------

I am going to assume, that you have a working copy of the Modulaise tools
suite, if not refer to the [installation instructions][1].

These steps will guide you through the creation of a new project.

1.  In your Eclipse Project Explorer pane, locate the build.xml file
    in the root folder of your modulaise project.

2.  Right click this file, and choose "Run as" -> "Ant Build..." 
    Select to run the "New Project" task.

    Instead of right clicking, you may open the build.xml
    file and locate the "Outline" tab present in the right pane
    of your Eclipse IDE. If you right click on the task "New Project"
    and choose "Run As" -> "Ant Build", the task will immediately
    commence.

3.  In the Create New Project wizard, input the name of your new
    project. We will call this project "tutorial" in small-caps.
    
    If there is already a directory in your workspace called
    "tutorial", the build will give you an error message in the
    Console window in the bottom of your Eclipse IDE.
    
4.  In the next step you will be prompted for which boilerplate
    you would like to use for creating your new project. In this
    case you should choose "blank" and click ok.
    
    The boilerplates are starting points for your new project,
    when you get comfortable using this suite of tools you can
    choose another boilerplate or start with a blank one.
    
5.  Create a new "Static Web Projects" called "tutorial".
    
    1.  Choose Eclipse menu: "File" -> "New" -> "Other..."
    2.  Choose "Static Web Project"
    3.  Name the project "tutorial" in small-caps

6.  Open your new project, and follow the instructions in the file 
    "README.markdown" in the root folder of your newly created project.
    
    This file contains information you need to put into your 
    Apache server and hosts file.
    
7.  Test your installation by browsing to 
    [http://tutorial.localhost](http://tutorial.localhost)
    
    If you are having trouble refer to the troubleshooting
    documentation.
    
If everything worked as intended, you have succesfully created a new
project. If you would like to know a little bit about the layout of
your new project, refer to the Project Layout documentation.


<a name="page_create"/>

Creating a new page  
-------------------------------------------------------------------------------

Follow these steps to create a new page.

1.  In your Eclipse Project Explorer pane, locate the build.xml file
    in the root folder of your tutorial project.
    
    Run the task "New Page".

2.  Call your page "blank_c", and choose "yes" to create the page.

    This copies the file from the folder:

       ../modulaise/boilerplates/pages/blank/index.php

    Into:
        
        ../tutorial/WebContent/modulaise/pages/blank_c.php
    
    This is handy as you may define your own page templates in this
    folder for rapid pagetemplating.

3.  Browse to [http://tutorial.localhost](http://tutorial.localhost)
    and check out your new page by clicking "blank_c".
    
    Keep this page open in your browser, as you are going to refresh
    it. Also take a look at the source code in the page to get a
    feel for what is going on.
    
    As this is a tutorial you will see a lot of narrative comments
    from the modules in the source code. These comments are there
    to help explaining what goes on in the page.
    
4.  In the Eclipse Explorer pane refresh your project, and open your
    new page:
        
        ../tutorial/WebContent/modulaise/pages/blank_c.php

5.  Delete these lines, and save your file:

        ModulaiseController::addModule("foot","bla_blank","alternative.html");
        ModulaiseController::addModule("foot","bla_blank");
        ModulaiseController::addModule("foot","bla_blank","alternative.html");
        ModulaiseController::addModule("foot","bla_blank");
        ModulaiseController::addModule("foot","bla_blank","alternative.html");
        ModulaiseController::addModule("foot","bla_blank");

6.  Refresh you page again. Congratulations you just removed 6 modules
    from the "foot" pane on that page.
    
That is it, you succesfully created a page. 


<a name="module_create"/>

Creating a new module 
-------------------------------------------------------------------------------

Follow these steps to create a new module.

1.  In your Eclipse Project Explorer pane, locate the build.xml file
    in the root folder of your "tutorial" project.
    
    Run the task "New Module".
    
2.  Choose the template "bla_blank".

3.  Select "Normal" for type.

4.  Input short name as "foo".

5.  Input long name as "fooBar"

6.  Choose yes to create your new module.

    This copies files from the folder:

        ../modulaise/boilerplates/modules/bla_blank/*
    
    Into:
    
        ../tutorial/WebContent/sc/foo_fooBar/*
    
    While also replacing a number of text-strings. By exploring the
    boilerplate folder, you can see how modules can be made, thus
    making your modules portable between projects.
    
    Refresh your project to see the newly created module.

7.  You will now add your newly created module to the "foot" pane.

    Add the this right before the ``ModulaiseController::printPage();``
    
        ModulaiseController::addModule("foot","foo_fooBar","alternative.html");
        
    Save your "blank_c.php" file, and reload your page.

Congratulations, you now see your new module in the "foot" pane.


<a name="module_modify"/>

Modifying your module 
-------------------------------------------------------------------------------

1.  In the Eclipse Explorer pane refresh your project, and open the module
    you just created:
        
        ../tutorial/WebContent/sc/foo_fooBar/*
        
2.  This is summary of the files in your newly created module:

        css          (css files with a priority default = 75)
        css_10       (css files with a priority of 10)
        css_90       (css files with a priority of 90)
        html         (html files)
        html_foot    (html foot files with a priority of default = 75)
        html_foot_10 (html foot files with a priority of 10)
        html_foot_90 (html foot files with a priority of 90)
        html_head    (html head files with a priority of default = 75)
        html_head_10 (html foot files with a priority of 10)
        html_head_90 (html foot files with a priority of 90)
        img          (images)
        js_foot      (js foot files with a priority of default = 75)
        js_foot_10   (js foot files with a priority of 10)
        js_foot_90   (js foot files with a priority of 90)
        js_head      (js head files with a priority of default = 75)
        js_head_10   (js head files with a priority of 10)
        js_head_90   (js head files with a priority of 90)

    This may look overwhelming at first glance, but you rarely need
    all of these folders. At most your module will contain 3 - 5
    subdirectories.

    Since the order of inclusion for CSS stylesheets and JavaScript
    code is significant, I am using priority id's to tell the
    system the order of inclusion.
    
    This means that the stylesheets in "css_90" comes last, and thus has
    the potential to override earlier stylesheets.
    
3.  Open the html file:

        ../tutorial/WebContent/sc/foo_fooBar/html/alternative.html
        
    And replace the contents with:
    
        <?php ModulaiseController::printComment("foo_fooBar/html/alternative.html: Says, hi!"); ?>
          <div class="foo foo-alt">
            <div class="foo-inner">
            <h1>THIS IS ME!!</h1><br />
            <img src="<?php ModulaiseController::printStaticContentPath(); ?>foo_fooBar/img/test.png" alt="Example Image" />
            <a class="foo-click tipsy-tip" href="#" title="First link">foo_foobar_jshead_default</a><br />
            <a class="foo-click tipsy-tip" href="#" title="Bingo!">HOVER HERE!</a><br />
          </div>
        </div>
    
    Try refreshing your browser. You should see the module 
    print "THIS IS ME!!" 
    
4.  Open the css file:
    
        ../tutorial/WebContent/sc/foo_fooBar/css/all.css
        
    Replace the contents with this:
    
        /* Stylesheet for foo_fooBar */
        
        .foo {
            width: 50%;
            display: block;
            float: left;
        }

        .foo-alt {
            background-color: blue;
        }

        .foo-inner {
            border: 2px dotted yellow;
            margin: 20px;
            padding: 20px;
        }

        .foo-click {
            display: inline-block;
            text-decoration: none;
            cursor: pointer;
            line-height: 18px;
            font-weight: bold;
            color: black;
            font-size: 12px;
            background-color: yellow;
            padding: 20px;
            margin: 10px;
            color: #444 !important;
            -moz-border-radius: 6px;
            -webkit-border-radius: 6px;
        }
        
        .foo-click:hover{
            background-color: green;
        }

    Refresh your page, and you should immediately see the changes.
    
5.  Add the module ``0_tipsy_TipsyToolTips`` to your "tutorial" 
    project.

    Leave all input fields at their default values, and click
    yes to create the module.
    
    Now refresh your browser. You should see some JavaScript
    errors emerge, since you haven't added any JQuery to your
    project.

6.  Add the module ``0_js_jQuery`` to your "tutorial" project.

    Leave all input fields at their default values, and click
    yes to create the module.
    
    Now refresh your browser, you should see that the jQuery
    javascript framework has now been added to your page.
    
    Also try hovering over the link called "HOVER HERE!".
    
You have succesfully edited a new module.


<a name="create_build"/>

Creating a build 
-------------------------------------------------------------------------------

Follow these steps to create a new build.

1.  In your Eclipse Project Explorer pane, locate the build.xml file
    in the root folder of your "tutorial" project.
    
    Run the task "Build".
    
    This will begin an automated build procedure of your project.
    
    When the build is complete, go to this URL:
    
    [http://tutorial.localhost/sc/][2]
    
    This is just a handy way of telling you the latest build version of
    your project.

2.  Refresh your tutorial project in Eclipse. Locate the zipped build 
    file in this folder:

        ../tutorial/WebContent/modulaise/builds/*
    
    Please note that each build is stamped with a date and a randomly
    generated speakable name.
    
    Extract the folder to your desktop, and doubleclick the file
    
        ../modulaise/pages_compiled/blank_c.html
        
    You should now see the page in it's compiled form.
    
    Inspect the resources loaded by your browser using [Firebug][3] or a 
    similar tool.
    
    What happened here was that all of your JavaScript and CSS files
    were concatinated and minified into the folder:
    
        ../sc/_compiled/*
    
    And instead of importing them one at a time, which is what you
    would want in the development phase, the CSS and JavaScripts
    are imported with one-liners:
    
        <link rel="stylesheet" href="../sc/_compiled/css/style.min.css?v=BUILD_TAG" />
        <script src="../sc/_compiled/js/js_head.min.js?v=BUILD_TAG"></script> 
        <script src="../sc/_compiled/js/js_foot.min.js?v=BUILD_TAG"></script> 
        
You have succesfully build a package of frontend code.


<a name="deploying_build"/>

Deploying your build 
-------------------------------------------------------------------------------

In these steps I will tell you how to deploy your build via ftp, you
will need the following information:

*   FTP servername
*   FTP username
*   FTP password
*   FTP port (standard is 21)
*   FTP path - which is the path you are going to upload to

<a name="create_deploy_target"/>

### Creating a new Deploy target 

1.  In your Eclipse Project Explorer pane, locate the build.xml file
    in the root folder of your "tutorial" project.
    
    Run the task "New Deploy Target".
    
2.  Put in a name for your deploy target. For the sake of this tutorial
    we could call it "Tutorial Deploy".
    
3.  Choose ftp as a method.

    If you have access to a host accepting SCP transfers, use that instead,
    since the FTP-task in Ant is inferior to the SCP-task.

4.  Input servername. (For instance: "example.com")

5.  Choose the default port number, unless you have a customized ftp server.

6.  Input path. (For instance: "www/test/")

7.  Input your username.

8.  Review your options and make sure these options are satisfactory, if you are
    good to go choose "Yes".
    
    This creates a new file with your deploy information, take a look at:
    
        ../tutorial/config-project/deploy-targets/Tutorial Deploy/deploy.config
    
    You may need to refresh your Eclipse workspace to see the new file.
    
<a name="deploying_build"/>

### Deploying your build 
    
1.  In your Eclipse Project Explorer pane, locate the build.xml file
    in the root folder of your "tutorial" project.
    
    Run the task "Deploy Project".
    
    If you have no builds to deploy, the script will give you a warning, and
    automatically build the project. If that happens run the task "Deploy
    Project" again.
    
2.  Choose "Tutorial Deploy".

3.  Select the build you want to deploy.

4.  Input password. This password is not stored locally.

5.  Choose yes, and get comfortable while you static files are deployed.

You have succesfully deployed your first project. It's time for celebration
beer! ;-)


<a name="revision_history"/>

Revision History  
-------------------------------------------------------------------------------

*   20101230, [Lars Jensen](mailto:lars.jensen@exenova.dk)

    Created the documentation 
    
*   20110102, [Lars Jensen](mailto:lars.jensen@exenova.dk)

    Updated intallation instructions to correct minor details, and
    include a zip file installations instruction.
    
*   20110104, [Lars Jensen](mailto:lars.jensen@exenova.dk)

    Corrected documentation.
    
*   20110108, [Lars Jensen](mailto:lars.jensen@exenova.dk)

    Added table of contents, corrected documentation.
    
*   20110120, [Lars Jensen](mailto:lars.jensen@exenova.dk)

    Touched up documentation.

[1]:  https://github.com/larjen/modulaise/blob/master/docs/install.md
      "Installation instructions"
[2]:  http://tutorial.localhost/sc/
      "Build information"
[3]:  http://http://getfirebug.com/
      "Get Firebug"
[4]:  https://github.com/larjen/modulaise/blob/master/docs/install.md
      "Installation instructions"