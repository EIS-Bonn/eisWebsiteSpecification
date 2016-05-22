# eisWebsiteSpecification
This is the specification part of EIS website that makes it different from aksw.org site template. 

Info on site extension of aksw project is available on: https://github.com/AKSW/site.ontowiki

In the live server, it is located in this folder of ontowiki and aksw:  /extensions/site/sites/local

Folder description:


items -> sub- templates

types -> templates



To have a filter of publications in home page of each person, or project:

Add the file BibFilter.php inside the root folder of website inside the folder /bibFilter
and make sure that this folder is included and is not writable in .htaccess file

This filter works by pubs tag inside bib file, if that does not match the publication Tag of the person/project,
it will search inside authors and tries to match an author to the publication Tag.


