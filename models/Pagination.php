
<?php

include './debugging.php';

class Pagination {
    
    // total records in table
    public $total_records;
    // limit of items per page
    private $limit;
    // total number of pages needed
    private $total_pages;
    // first and back links
    private $firstBack;
    // next and last links
    private $nextLast;
    // where are we among all pages?
    private $where;

    public function __construct() {
        
    }

    // determines the total number of records in table
    public function totalRecords($table) {
        $dbc = Database::getInstance();
        $query = 'select * from ' . $table;
        $this->total_records = $dbc->getRows($query);
        if (!$this->total_records) {
            echo 'No records found!';
            return;
        }
    }

    // sets limit and number of pages
    public function setLimit($limit) {
        $this->limit = $limit;

        // determines how many pages there will be
        if (!empty($this->total_records)) {
            $this->total_pages = ceil($this->total_records / $this->limit);
        }
    }

    // determine what the current page is also, it returns the current page
    public function page($search) {
        $pageno = (int) (isset($_GET['pageno'])) ? $_GET['pageno'] : $pageno = 1;
//        $sType = $_REQUEST['searchType'];
//        $srank = $_REQUEST['showRank'];

        // out of range check
        if ($pageno > $this->total_pages) {
            $pageno = $this->total_pages;
        } elseif ($pageno < 1) {
            $pageno = 1;
        }

        // links
        echo '<nav class="mb-3 d-flex justify-content-center align-items-center" aria-label="Menu Page Navigation">';
        echo '<span class="me-2">Page: </span>';
        if ($pageno > 1) {
            // backtrack
            $prevpage = $pageno - 1;

            // 'first' and 'back' links
//            $this->firstBack = "<div><a href='$_SERVER[PHP_SELF]?submitted=1&pageno=1'>First</a> <a href='$_SERVER[PHP_SELF]?submitted=1&pageno=$prevpage'>Back</a></div>";
            $this->firstBack = '<ul class="pagination d-flex flex-row m-0">
                        <li class="page-item"><a href="'.$_SERVER[PHP_SELF].'?submitted=1&pageno=1" type="button" class="pagination-last-bookings page-link mx-2 rounded border-2" value="First" disabled="true">First</a></li>
              </ul>';
            echo $this->firstBack;
            
        }

        $this->where = "<div>(Page $pageno of $this->total_pages)</div>";
        
        
        
        for ($i = 1; $i <= $this->total_pages; $i++ ) {
//            <nav class="mb-3 d-flex justify-content-center align-items-center" aria-label="Menu Page Navigation">
//                    <span class="me-2">Page: </span>
//                    <ul class="pagination d-flex flex-row m-0">
//                        <li class="page-item"><input type="button" class="pagination-first-bookings page-link mx-2 rounded border-2 disabled" value="First" disabled="true"></li>
//                    </ul>
//                    <ul class="pagination pagination-numbers-bookings d-flex flex-row m-0"><li class="page-item pagination-number-bookings"><button class="page-link ms-2 rounded border-2 pagination-number-button-bookings active" page-index="1" type="button">1</button></li></ul>
//                    <ul class="pagination d-flex flex-row m-0">
//                        <li class="page-item"><input type="button" class="pagination-last-bookings page-link mx-2 rounded border-2 disabled" value="Last" disabled="true"></li>
//                    </ul>
//                </nav>
            if ($pageno == $i) {
//                echo "<a  class="page-link ms-2 rounded border-2 pagination-number-button-bookings active'>'.$i.'</a>";
//                echo "<a class='page-link ms-2 rounded border-2 pagination-number-button-bookings active' href='$_SERVER[PHP_SELF]?submitted=1&pageno=".$i."'>".$i."</a>";
                echo '<ul class="pagination pagination-numbers-bookings d-flex flex-row m-0"><li class="page-item pagination-number-bookings"><a href="'.$_SERVER[PHP_SELF].'?submitted=1&pageno='.$i.'" class="page-link ms-2 rounded border-2 pagination-number-button-bookings active" page-index="'.$i.'" type="button">'.$i.'</a></li></ul>';
            } else {
                echo '<ul class="pagination pagination-numbers-bookings d-flex flex-row m-0"><li class="page-item pagination-number-bookings"><a href="'.$_SERVER[PHP_SELF].'?submitted=1&pageno='.$i.'" class="page-link ms-2 rounded border-2 pagination-number-button-bookings" page-index="'.$i.'" type="button">'.$i.'</a></li></ul>';
            }
        }
        
        
        
//        echo $pageno . " is the current page number";

        if ($pageno < $this->total_pages) {
            // forward
            $nextpage = $pageno + 1;

            // 'next' and 'last' links 
//            $this->nextLast = "<div><a href='$_SERVER[PHP_SELF]?sort=$sort&submitted=1&search=$search&pageno=$nextpage&showRank=$srank&searchType=$sType'>Next</a> <a href='$_SERVER[PHP_SELF]?sort=$sort&submitted=1&search=$search&pageno=$this->total_pages&showRank=$srank&searchType=$sType'>Last</a></div>";
            echo '<ul class="pagination d-flex flex-row m-0">
                        <li class="page-item"><a href="'.$_SERVER[PHP_SELF].'?submitted=1&pageno='.$this->total_pages.'" type="button" class="pagination-last-bookings page-link mx-2 rounded border-2" value="Last" disabled="true">Last</a></li>
              </ul>';
        }
        
        echo '</nav>';

        return $pageno;
    }

    // get first and back links
    public function firstBack() {
        return $this->firstBack;
    }

    // get next and last links
    public function nextLast() {
        return $this->nextLast;
    }

    // get where we are among pages
    public function where() {
        return $this->where;
    }
    
    public function setTotal_records($total_records) {
        $this->total_records = $total_records;
    }

    public function getTotal_records() {
        return $this->total_records;
    }



}
