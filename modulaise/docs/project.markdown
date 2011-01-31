
Project
===============================================================================

This chapter briefly outlines what is meant by a project, how you create one
and what the insides of the folder project contains.
 

Table of Contents
-------------------------------------------------------------------------------

*   [Creating a new Project](#project_create)
*   [Project Layout](#project_layout)
*   [Build Configuration](#build_configuration)
    *   [Setting the path to your static content](#setting_sc_path)<a name=""/>
*   [Project Boilerplates](#project_boilerplates)
*   [Revision History](#revision_history)


<a name="project_create"/>

Creating a Project 
-------------------------------------------------------------------------------

I will assume you have your environment set up as per the installation
instructions. 

To create a new project follow these steps:

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
    project preferably in small-caps.
    
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
    [http://PROJECT_NAME.localhost](http://PROJECT_NAME.localhost)
    
    If you are having trouble refer to the troubleshooting
    documentation.

If everything in the above steps worked out allright, you should now have
created a new project.


<a name="project_layout"/>

Project Layout  
-------------------------------------------------------------------------------

This is a simple layout of your project, you may find that some of the folders
are not present in your project, usually those folders are created when you
are building or deploying your project.

    PROJECT_NAME/
    |
    + .settings/ - - - - - - - - - - Eclipse folder.
    |
    + modulaise/ - - - - - - - - - - Includes scripts and settings to make
    | |                              the tools suite work
    | |
    | + config-project/  - - - - - - Contains build settings for this project
    | | |
    | | + project.config - - - - - - Contains project settings. These are best
    | |                              left at their default values, however in
    | |                              rare cases, you may need to alter these.
    | |
    | + deploy-targets/  - - - - - - Contains your deploy targets
    |
    + temp/  - - - - - - - - - - - - Temporary files, you may delete these
    |
    + WebContent/  - - - - - - - - - If Apache is configured correctly, this
    | |                              is the web root folder
    | |
    | + modulaise/
    | | |
    | | + builds/  - - - - - - - - - Contains your zipped build files
    | | |
    | | + pages/ - - - - - - - - - - Contains your pages, when editing 
    | | |                            pages you will edit the pages in this 
    | | |                            folder
    | | |
    | | + pages_compiled/  - - - - - These are compiled versions of your 
    | | |                            pages, these are the pages included 
    | | |                            in your zipped build files.
    | | |
    | | + pages_cached/  - - - - - - These are cached versions of your 
    | |                              pages.
    | |
    | + sc/  - - - - - - - - - - - - This folder contains all of your modules.
    | | |                            Please note it's relative path to the
    | | |                            web root folder. You may take advantage
    | | |                            of this when planning where to host your
    | | |                            static content on your production server.
    | | |
    | | + _compiled/   - - - - - - - This folder contains the concatinated
    | | |                            and minified CSS and JavaSript. When you
    | | |                            perform a build, this is where all of the
    | | |                            files are stored.
    | | |
    | | + index.html   - - - - - - - Build changelog, for checking out the
    | |                              version of the currently deployed static
    | |                              content.
    | |
    | + templates/   - - - - - - - - This folder contains your page templates
    | |                              these are used for assembling your pages.
    | |
    | + modulaise.php  - - - - - - - File that gives you a list of your pages 
    |                                and a link to your builds.
    |
    + .project - - - - - - - - - - - Eclipse file.
    |
    + build.xml  - - - - - - - - - - This is your Ant build file for this
    |                                project. Use this to perform common
    |                                tasks.
    |
    + README.markdown  - - - - - - - This file contains server configuration
                                     instructions.

<a name="build_configuration"/>

Project Configuration 
-------------------------------------------------------------------------------

If you want to change configurations for your project you may do so in the
``project.config`` file in the folder ``modulaise/project-config``.

In this file you can set your name and email adress, revision numbers and
tweak a lot of general settings.


<a name="setting_sc_path"/>

### Setting the path to your static content

In this file you will find variables for altering the path to the static
content for either export or development versions. As per default when you
export you project as a zip file there are two root folders in the zip
file:

    /modulaise/pages_compiled
    /sc

So in order to reference the files in the ``/sc`` folder from within the
compiled pages, you need to go up two folders using ``../../sc/``:

    <link rel="stylesheet" href="../../sc/_compiled/css/style.min.css" />

But when developing your static content pages on your server, you would
like to reference your static content from server root with ``/sc/``:

    <script src="/sc/0-js-Modernizr/js_head_00/modernizr-1.6.min.js"></script>

By changing the following settings in your ``project.config`` file you
will be able to change the paths to suit your needs:

    # Static path to pages when compiling static pages
    PATH_MODULES_BUILD = ../../sc/
    
    # Dynamic path to pages when creating them dynamically on the fly and serving them from server
    PATH_MODULES_DEVELOPMENT = /sc/


<a name="project_boilerplates"/>

Project Boilerplates  
-------------------------------------------------------------------------------

When you are creating a new project, you are simply copying files from:

    ../modulaise/boilerplates/projects/*

to

    ../__PROJECT_NEW_NAME__/*

You may take advantage of this by creating your own project boilerplate. The
easiest way to create a new boilerplate is by either copying from an existing
boilerplate or by copying over the contents of an existing project into a
new folder inside the ``../modulaise/boilerplates/projects/`` folder.

A few pointers though, in able to create the new project a set of variables
are being renamed in all files inside your boilerplate project. To make
sure the boilerplate is set up for immediate use, refer to this table
to get the variable naming correct:

    __PROJECT_NEW_NAME__             is replaced by    Name of the project
    __FILE_HOSTS__                   is replaced by    FILE_HOSTS value from ../modulaise/config-global/global.config
    __FILE_APACHE_CONFIGURATION__    is replaced by    FILE_APACHE_CONFIGURATION value from ../modulaise/config-global/global.config
    __DIR_WORKSPACE__                is replaced by    The correct path to your workspace.


<a name="revision_history"/>

Revision History 
-------------------------------------------------------------------------------

*   20110108, [Lars Jensen](mailto:lars.jensen@exenova.dk)

    Created the document.