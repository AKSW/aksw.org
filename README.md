# aksw.org

This is the source of the aksw.org website which is served
with [OntoWiki](http://ontowiki.net) and OntoWiki's [site
extension](https://github.com/AKSW/site.ontowiki).

The repository imports site and ipc extension (in addition to Erfurt and
RDFauthor) via submodules and organizes a clean upstream branch which is
used to fetch and push OntoWiki changesets.

## Setup

To use `aksw.org` please run `make deploy` and `make custom`.
For correctly invoking sendmail the according sendmail parameter has to be configuired in `php.ini` resp. a separate file in `conf.d`:

    sendmail_path = /usr/sbin/sendmail -t -i -f'from@my-domain.net'

## Setting up Sites and Templates

Please see https://github.com/AKSW/site.ontowiki/wiki/Template-and-Site-Options for detailled Information
on how to set up different Sites and new Content

## Installation/Update

If you are updating OntoWiki, please don't forget to run `make deploy`.
If `make deploy` fails, you might also have to run `make getcomposer` once before run `make deploy` again.

For further installation instructions please have a look at our [wiki](https://github.com/AKSW/OntoWiki/wiki/GetOntowikiUsers) (might be outdated in some parts).

## Setting up Thesis Announcements Feature

1. Please see https://github.com/AKSW/googledoc-viewer and follow the Deploy Steps starting with step 2
2. in Model, set template (http://ns.ontowiki.net/SysOnt/Site/template) to 'teaching' which itself renders the thesisannouncement template
3. to see the provided theses on each individual supervisor page, set the supervisorTag (http://aksw.org/schema/supervisorTag) to the respective Name in the Model

## Screenshot / Webinar
Below is a screenshot showing OntoWiki in editing mode.

For a longer visual presentation you can watch our [webinar@youtube](http://www.youtube.com/watch?v=vP1UDKeZsQk)
(thanks to Phil and the Semantic Web company).

![Screenshot](http://lh4.ggpht.com/-kXpKMqBBCIU/Tpx45SUaItI/AAAAAAAAA9w/aPYaNQjcpvo/s800/ontowiki.png)

## License

OntoWiki is licensed under the [GNU General Public License Version 2, June 1991](http://www.gnu.org/licenses/gpl-2.0.txt) (license document is in the application subfolder).
