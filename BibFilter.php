
<?php

/**
 * User: afshin sadeghi
 * Date: 21/05/16
 * Time: 23:56
 */
class BibFilter
{
    /**
     * @var array|bool|mixed|string
     */
    private $json;

    /**
     * BibFilter constructor.
     */
    public function __construct()
    {
    $this->json = $this->readJsonFile('../eis.bib.json');
        $publicationTag = null;
        if (isset($_REQUEST['suffix'])) {
            $publicationTag = $_REQUEST['suffix'];
            if (isset($publicationTag) && $publicationTag != "") {
                $this->filterByTag($publicationTag);
            }
        }

        header('Content-type: application/json');
        if (isset($_REQUEST['callback'])) {
            echo $_REQUEST['callback'] . ' ( ' . json_encode($this->json) . ')';
        } else {
            echo json_encode($this->json);
        }

    }	

    /**
     * @param $address
     * @return array|bool|mixed|string
     */
    public function readJsonFile($address)
    {
        $output = null;
        if (!file_exists($address)) {
            error_log(" bib file does not exists");
            return $output;
        }
        $handle = fopen($address, 'rb');
        if ($handle === false) {
            return false;
        }
        $output = fread($handle, filesize($address));
        fclose($handle);
        $prefix = "cb (";
        if (substr( $output, 0, 4 ) === $prefix){
            $output = substr_replace($output, '', 0, strlen($prefix)) ;
            $output = substr_replace($output, '', strlen($output)-1, 1) ;
        }

        $output = json_decode($output);
        return $output;
    
     }


    /**
     * @param $publicationTag
     */
    private function filterByTag($publicationTag)
    {

    $items = array();
        $foundByPubs = false;

        if (isset($this->json->items)) {
            foreach ($this->json->items as $item) {
                if (isset($item->pubs)) {
                    $tags = explode(',', $item->pubs);
                    foreach ($tags as $tag) {
                        if ($tag == $publicationTag) {
                            $items[] = $item;
                            $foundByPubs = true;
                        }
                    }
                }
                if (isset($item->author) && $foundByPubs != true) {
                    foreach ($item->author as $author) {
                        
			$tags = explode(',', str_replace('"', "", $author));
                        foreach ($tags as $tag) {
                     if (strpos(strtolower($tag), $publicationTag) != false) {
                                $items[] = $item;
                            }
                        }
                    }
                }

            }
        }
        $this->json->items = $items;
    }

   
}

$runFilter = new BibFilter();
