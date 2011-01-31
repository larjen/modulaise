
Buildnamer
===============================================================================

Use this jar file in your ant build scripts to get friendly buildnames.


Example usage:
-------------------------------------------------------------------------------

Subsitute the paths below to the placement of your own files:

    <taskdef name="buildnamer" classname="dk.exenova.ant.BuildNamer" classpath="${basedir}/modulaise/lib/buildnamer-1.1.0/bin/BuildNamer.jar"/>
    <buildnamer property="timestamped.build.name" />
    <property name="build.name" value="${PROJECT_NAME}-${timestamped.build.name}" />

