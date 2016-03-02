**Attention for composer users!**
This version is not ready for use with composer, currently it is only the `feature/php-composer` branch. If you like to check it out, please require `dev-feature/php-composer`.

# aksw.org

This is the source of the aksw.org website which is served
with [OntoWiki](http://ontowiki.net) and OntoWiki's [site
extension](https://github.com/AKSW/site.ontowiki).

The repository imports site and ipc extension (in addition to Erfurt and
RDFauthor) via submodules and organizes a clean upstream branch which is
used to fetch and push OntoWiki changesets.

## Setup

To use `aksw.org` please run `make deploy` and `make custom`.

## Setting up Sites and Templates

Please see https://github.com/AKSW/site.ontowiki/wiki/Template-and-Site-Options for detailled Information
on how to set up different Sites and new Content

## Setting up Thesis Announcements Feature

1. Please see https://github.com/AKSW/googledoc-viewer and follow the Deploy Steps starting with step 2
2. in Model, set template (http://ns.ontowiki.net/SysOnt/Site/template) if the 'Teaching' Document to 'teaching' which itself renders the thesisannouncement template
3. to see the provided theses on each individual supervisor page, set the supervisorTag (http://aksw.org/schema/supervisorTag) to the respective Name in the Model
