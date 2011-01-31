
Changelog
===============================================================================

This is the changelog.


v0.7.0 - 2010-12-30
-------------------------------------------------------------------------------

Committed first version to GitHub, this is not ready for development and is
considered unstable.


v0.7.1 - 2011-01-09
-------------------------------------------------------------------------------

All of the documentation files are in place.

The project is now ready to begin trial runs, in order to weed out any stupid 
bugs that may have crept in.


v0.7.2 - 2011-01-16
-------------------------------------------------------------------------------

Renaming all modulenames to not have a '-' (minus) in them, so as to enable
dojo.require() and dojo.provide().


v0.7.3 - 2011-01-20
-------------------------------------------------------------------------------

Reshuffling documentation to make INSTALL.markdown more prominent. 

Reshuffling internal project structure to minimize potential name-conflicts in
scenarios where the modulaise project should co-exist with for instance
wordpress.

Fixed bug: Changing config modulepath setting had side-effects on index of
pages.

v0.7.4 - 2011-01-30
-------------------------------------------------------------------------------

Included a dojo foundation site.

Included JSLint for java to the project, now JavaScript is tested against the
JSLint library.

Reshuffled entire project to make it work with automated build tool "Hudson", 
it has no out of project dependencies. 

Cleaned up installation procedure, so no need for adding more than two jar
files to the Ant environment path - ond those only needed for deploying
static content.