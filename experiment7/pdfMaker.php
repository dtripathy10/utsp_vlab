<?php 
//CONFIG
require_once('../tcpdf/tcpdf.php');
require_once('../fpdi/fpdi.php');//concatenation
//END CONFIG
 
 
class PDFmaker extends FPDI{
	  /////////////////////////////////////////////////
  // PROPERTIES, PUBLIC
  /////////////////////////////////////////////////
	//here we set the default font, margins, etc.
	//TODO define the default parameters for font, etc.
 
	protected $idDocument;
	public $header;
 
 
	function PDFmaker(){
		parent::__construct('P','mm', 'A4', true, 'UTF-8', false);
	}
 
 
	function configPdfFile(){
		//set margins
		$this->SetMargins(20, 30, 20);//(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
	}
 
	 //Page header
    public function Header() {
 
		// set header fonts
		$this->setHeaderFont(Array('arial', '', PDF_FONT_SIZE_MAIN));
 
    	//Set the margins
    	$this->SetY(5);
 
    	// Colors, line width and bold font
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetDrawColor(0, 0, 0);
        $this->SetLineWidth(0.1);
        $this->SetFont('', '');
 
        $this->SetX(50);
        //Carriage return to the following line
        $this->Ln();
 
        // Color and font restoration
        $this->SetFillColor(255, 255, 255);
        $this->SetTextColor(0);
        $this->SetFont('');
         // Line break
        $this->Ln(20);
 
    }
 
    // Page footer
    public function Footer() {
    	//Set footer margin
    	$this->SetFooterMargin(PDF_MARGIN_FOOTER);
       // set header and footer fonts
		$this->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
		$this->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
 
        // Position at 1.5 cm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, 0, 'C');
    }
 
    public function addPdfText($htmlMyText=""){
 
    	//check if there is already a page in the document. If there is no page it must be created before
    	if($this->getPage()==0){
    		$this->AddPage('L',"");
    	}
    	else{//if there is already a page, the cursor must point to it
    		$this->setPage($this->getPage(), false);
    	}
    	$this->writeHTML($htmlMyText, false, false, false, false, 'J');
    	//Without the following line, next time we use addPdfText the first line of the new content will overlap the last line that was already written in the document
    	$this->Ln(10, false);
    	//Now we leave the cursor in the last page, ready for a future addition of more content
    	$this->lastPage();
 
 
    }
 
 	protected function AddPagePdf($orientation='', $format='') {
			if (!isset($this->original_lMargin)) {
				$this->original_lMargin = $this->lMargin;
			}
			if (!isset($this->original_rMargin)) {
				$this->original_rMargin = $this->rMargin;
			}
			// terminate previous page
			$this->endPage();
			// start new page
			$this->startPagePdf($orientation, $format);
		}
 
	protected function startPagePdf($orientation='', $format='') {
			if ($this->numpages > $this->page) {
				// this page has been already added
				$this->setPage($this->page + 1);
				$this->SetY($this->tMargin);
				return;
			}
			// start a new page
			if ($this->state == 0) {
				$this->Open();
			}
			++$this->numpages;
			$this->swapMargins($this->booklet);
			// save current graphic settings
			$gvars = $this->getGraphicVars();
			// start new page
			$this->_beginpage($orientation, $format);
			// mark page as open
			$this->pageopen[$this->page] = true;
			// restore graphic settings
			$this->setGraphicVars($gvars);
			// mark this point
			$this->setPageMark();
			// print page header
			//$this->setHeader();
			// restore graphic settings
			$this->setGraphicVars($gvars);
			// mark this point
			$this->setPageMark();
			// print table header (if any)
			//$this->setTableHeader();
		}
 
    public function addPdfFile($file){
 
	    //check if there is already a page in the document. If there is no page it must be created before
	    	if($this->getPage()==0) $this->AddPage('P',"");
	    	else $this->setPage($this->getPage(), false);//if there is already a page, the cursor must point to it
 
     		$pagecount = $this->setSourceFile($file);
            for ($i = 1; $i <= $pagecount; $i++) {
                 $tplidx = $this->ImportPage($i);
                 $s = $this->getTemplatesize($tplidx);
                 $this->AddPagePdf('P', array($s['w'], $s['h']));
                 $this->Ln($s['h'], false);
                 $this->useTemplate($tplidx);
			}
            $this->lastPage();
    }
 
}
?>