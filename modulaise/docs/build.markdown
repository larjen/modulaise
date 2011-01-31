
Build
===============================================================================

This chapter outlines how to build and how to deploy your project.


Table of Contents
-------------------------------------------------------------------------------

*   [Introduction to building](#introduction_to_build)
*   [Creating a Build](#create_build)
*   [Creating a Deploy target](#create_deploy_target)
*   [Deploying your Build](#deploy_build)
*   [Revision History](#revision_history)


<a name="introduction_to_build"/>

Introduction to building
-------------------------------------------------------------------------------

When your project is ready to go live, you build the project. Ideally, and
since the procedure is automatic and takes seconds, you would want to build
and deploy continously in order to spot potential problems.

The build procedure concatinates and minifies all of your JavaScript and 
CSS files, and in addition it creates all you HTML-pages.

All of these files are zipped into a file which you may hand over to backend
developers who are going to implement the front end code.

This does require a little planning ahead, if you want to be able to push
your updated static content to a test or production server. By looking at
an example build file, you will get the basic idea of what folders you should
ask your backend developers to give you write access to.

For enterprise grade development procedures, I strongly recommend that you
not push the static contents directly to a production server - but instead
create a script deploying the static content from an eventual staging or test
server to production, complete with a rollback feature in case something
goes wrong.  


<a name="create_build"/>

Creating a Build
-------------------------------------------------------------------------------

Follow these steps to create a new build.

1.  In your Eclipse Project Explorer pane, locate the build.xml file
    in the root folder of your "tutorial" project.
    
    Run the task "Build".
    
    This will begin an automated build procedure of your project.
    
    When the build is complete, refresh your "tutorial" project in
    Eclipse.

2.  Locate the zipped build file in this folder:

        ../tutorial/WebContent/modulaise/builds/*
    
    Please note that each build is stamped with a date and a randomly
    generated speakable name.
    
    Extract the folder to your desktop, and doubleclick the file
    
        ../modulaise/pages_compiled/blank_c.html
        
    You should now see the page in it's compiled form.
    
    What happened here was that all of your JavaScript and CSS files
    were concatinated and minified into the folder:
    
        ../tutorial/WebContent/sc/_compiled/*
    
    And instead of importing them one at a time, which is what you
    would want in the development phase. The CSS stylesheets
    are actually imported with just this line:
    
        <link rel="stylesheet" href="../sc/_compiled/css/style.min.css" />
        
You have succesfully build a package of frontend code.


<a name="create_deploy_target"/>

Creating a Deploy target
-------------------------------------------------------------------------------

When you deploy your projects, you will be asked for which deploy target you
will be using. You may create as many deploy targets as you need, each deploy
target can pointing to a different server and or directory.

1.  In your Eclipse Project Explorer pane, locate the build.xml file
    in the root folder of your "tutorial" project.
    
    Run the task "New Deploy Target".
    
2.  Put in a name for your deploy target. For the sake of this tutorial
    we could call it "Tutorial Deploy".
    
3.  Choose ftp as a method.

4.  Input servername. (For instance: "example.com")

5.  Choose the default port number, unless you have a customized ftp server.

6.  Input path. (For instance: "www/test/")

7.  Input your username.

8.  Review your options and make sure these options are satisfactory, if you are
    good to go choose "Yes".
    
    This creates a new file with your deploy information, take a look at:
    
        ../tutorial/modulaise/deploy-targets/Tutorial Deploy/deploy.config
    
    You may need to refresh your Eclipse workspace to see the new file.

As the FTP connection for some reason is very slow, I recommend using the
SCP protocol to transfer your files. 


<a name="deploy_build"/>

Deploying your Build
-------------------------------------------------------------------------------

After building a project, and making sure the build is ready to be pushed, it
is time to deploy it.

1.  In your Eclipse Project Explorer pane, locate the build.xml file
    in the root folder of your "tutorial" project.
    
    Run the task "Deploy Project".
    
    If you have no builds to deploy, the script will give you a warning, and
    automatically build the project. If that happens run the task "Deploy
    Project" again.
    
2.  Choose "Tutorial Deploy".

3.  Select the build you want to deploy.

4.  Input password. This password is not stored locally.

5.  Choose yes.

What happens is that the zip file is being extracted to the ``temp`` folder
after which the files are transferred in the manner you specified.

This makes it possible for you to deploy an older version of your project,
if need be.


<a name="revision_history"/>

Revision History
-------------------------------------------------------------------------------

*   20110108, [Lars Jensen](mailto:lars.jensen@exenova.dk)

    Created the document.
   