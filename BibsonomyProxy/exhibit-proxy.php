<?php
/**
 * Exhibit Proxy which reads an URI and releases an JSON file
 *
 * @author     Sebastian Tramp <tramp@informatik.uni-leipzig.de>
 * @copyright  Copyright (c) 2009, {@link http://aksw.org AKSW}
 * @license    http://opensource.org/licenses/gpl-license.php GNU General Public License (GPL)
 */

class ExhibitItem
{
    // the item object
    public $content;

    public function  __construct($item) {
        $this->content = $item;
    }

    public function getContent () {
        return $this->content;
    }

    /*
     * set a value for a key (and shift to an array if there is an old value)
     */
    public function addValue($key, $value) {
        // a new value / key not used
        if ( !isset($this->content->$key) ) {
            $this->content->$key = $value;
        } else {
            if (is_array($this->content->$key)) {
                // key used as multi-value
                $newValue = $this->content->$key;
                $newValue[] = $value;
                $this->content->$key = $newValue;
            } else { // key used as single value
                $newValue = array ();
                $newValue[] = $this->content->$key;
                $newValue[] = $value;
                $this->content->$key = $newValue;
            }
        }
    }

    /*
     * set a value for a key (and delete the old value)
     */
    public function setValue($key, $value) {
        $this->content->$key = $value;
    }
     public function __set($name, $value) {
        return $this->setValue($name, $value);
    }

    public function getValue($key) {
        if ( isset($this->content->$key) ) {
            return $this->content->$key;
        } else {
           return null;
        }
    }
    public function __get($name) {
        return $this->getValue($name);
    }


    public function __isset($name) {
        return isset($this->content->$name);
    }

    public function __unset($name) {
        unset($this->content->$name);
    }

    /* merges some attributes from an item into this item */
    public function mergeWith(ExhibitItem $item) {
        if ($item->group) {
            $this->addValue('group', $item->group);
        }
    }
}

class ExhibitProxy
{
    // the manipulated json structure
    public $json;

    public function  __construct() {

        if (isset($_REQUEST['suffix'])) {
            $bisonomysuffix = $_REQUEST['suffix'];
            $this->json = $this->readJsonUrl('http://www.bibsonomy.org/json/'.$bisonomysuffix.'?items=1000');

            $this->annotate();

            header('Content-type: application/json');
            if (isset($_REQUEST['callback'])) {
                echo $_REQUEST['callback'] . ' ( '. json_encode($this->json) . ')';
            } else {
                echo json_encode($this->json);
            }
        }
    }

    /*
     * Annotates the given JSON data with different additions
     */
    public function annotate() {
        $items = array ();

        // creates a new $items
        if (isset($this->json->items)) {
            foreach ($this->json->items as $item) {
                $item = new ExhibitItem($item);

                // add the bibtex URL
                $item->addValue('biburl', $item->getValue('id'));

                // delete empty url fields
                if ((isset($item->url)) && ($item->url == '') ) {
                    unset($item->url);
                }

                // english is default language
                $item->language = "english";

                // iterate over all tags
                foreach ($item->tags as $tag) {
                    $tagParts = explode ('_', $tag);

                    // manipulate data only if tag has form xxx_yyy
                    if ( count($tagParts) == 2 ) {
                        $key = strtolower($tagParts[0]); # lowercase the key for simplicity
                        $value = $tagParts[1];

                        switch ($key) {
                            case 'group':
                            case 'event':
                                // add the uppercased group, event
                                $item->addValue($key, strtoupper($value) );
                                break;

                            case 'language':
                                // set / overwrite language
                                $item->setValue($key, $value );
                                break;

                            case 'sameas':
                                // safe the referenced intraHash (for deleting the object)
                                $this->sameAsIntraHashs[$value] = $item->intraHash;

                            default:
                                $item->addValue($key, $value);
                                break;
                        }
                    }
                }

                // manipulate the authors
                if ( isset($item->author) ) {
                    $newAuthors = array();
                    foreach ($item->author as $author) {

                        // change seebis name
                        if ( ($author == 'Sebastian Tramp') || ($author == 'Sebastian Dietzold') ) {
                            $author = 'Sebastian Tramp (geb. Dietzold)';
                        }

                        // change Amrapalis name
                        if ($author == 'Amrapali Zaveri') {
                            $author = 'Amrapali J. Zaveri';
                        }

                        // change aslams name
                        if ($author == 'Aslam Ahtisham Aslam') {
                            $author = 'Muhammad Ahtisham Aslam';
                        }

                        $newAuthors[] = $author;
                    }
                    $item->author = $newAuthors;
                }

                // manipulate the editors
                if ( isset($item->editor) ) {
                    $newEditors = array();
                    foreach ($item->editor as $editor) {

                        // change seebis name
                        if ( ($editor == 'Sebastian Tramp') || ($editor == 'Sebastian Dietzold') ) {
                            $editor = 'Sebastian Tramp (geb. Dietzold)';
                        }

                        $newEditors[] = $editor;
                    }
                    $item->editor = $newEditors;
                }

                // use item user as fallback for the group
                if (!isset($item->group)) {
                    $item->group = strtoupper($item->user);
                }

                $items[$item->intraHash] = $item->getContent();
            }
        }
        $this->json->items = $items;

        // merge sameas_ referenced into the referencing source
        if (isset($this->sameAsIntraHashs)) {
            foreach ($this->sameAsIntraHashs as $delete => $hold) {
                $newItem = new ExhibitItem( $this->json->items[$hold] );
                $newItem->mergeWith(new ExhibitItem( $this->json->items[$delete] ));
                $this->json->items[$hold] = $newItem->getContent();
            }
        }

        // and again iterate (this time, add only non-sameas_ referenced items
        $items = array ();
        foreach ($this->json->items as $intraHash => $item) {
            if ($this->sameAsIntraHashs[$intraHash] != true) {
                $items[] = $item;
            }
        }
        $this->json->items = $items;

    }

    /*
     * reads an URL and return the decoded JSON structure
     * http://de.php.net/manual/de/function.readfile.php#54295
     */
    public function readJsonUrl($url) {
       $chunksize = 1*(1024*1024); // how many bytes per chunk
       $buffer = '';
       $output = '';
       $handle = fopen($url, 'rb');
       if ($handle === false) {
           return false;
       }
       while (!feof($handle)) {
           $buffer = fread($handle, $chunksize);
           $output = $output . $buffer;
       }
       fclose($handle);

       $output = json_decode ($output);

       return $output;
    }


}

$proxy = new ExhibitProxy();
