<?php

/**
 * Helper class for use with page lists
 * 
 * @author Lars Jensen, lars.jensen@exenova.dk
 *
 */
Class ModulaiseIndexPageElement {
	public $pageName;
	public $currentLink;
	public $exportLink;
	public $cacheLink;

	public function __construct($pageName,$currentLink,$exportLink,$cacheLink){
		$this->pageName = $pageName;
		$this->currentLink = $currentLink;
		$this->exportLink = $exportLink;
		$this->cacheLink = $cacheLink;
	}
}

/**
 * Generates the index-page
 *
 * @author Lars Jensen, lars.jensen@exenova.dk
 *
 */
Class ModulaiseIndexPage {
	public static $indexPages = array();

	/**
	 * Prints the page
	 */
	public static function printPage(){

		// Get all pages
		self::$indexPages = self::getPages();
		
		// render page
		self::renderPage();
	}
	
	public static function renderPage(){
		?><!doctype html>  
<head>
<title><?php echo PROJECT_NAME; ?>: Index of pages in project</title>
<meta name="description" content="Index of pages in project <?php echo PROJECT_NAME; ?>">
<meta name="author" content="<?php echo PROJECT_AUTHOR; ?>">
<style type="text/css">
	<?php include (ModulaiseController::$DIR_MODULAISE_ROOT.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."common".DIRECTORY_SEPARATOR."default.css");?>
</style>
</head>
<body>
<header>
<h1>Project: <?php echo PROJECT_NAME; ?>, Author: <a href="mailto:<?php echo PROJECT_AUTHOR_EMAIL; ?>"><?php echo PROJECT_AUTHOR; ?></a></h1>
</header>
<section>
<table class="pi">
	<tr>
		<th>Page name</th>
		<th class="right" colspan="2"><a class="btn" href="/<?php echo PATH_BUILDS ?>/">Builds</a></th>
	</tr>
<?php 

$i=0;
foreach (ModulaiseIndexPage::$indexPages as $page){
	$i++;
?>
	<tr class="<?php if($i % 2 == 0){echo " pi-odd";}else{echo " pi-even";} ?>">
		<td class="pi-title"><a href="<?php echo $page->currentLink; ?>"><?php echo $page->pageName; ?></a></td>
		<td class="pi-cahced right"><a class="btn" href="<?php echo $page->cacheLink; ?>">Cached</a></td>
		<td class="pi-export right"><a class="btn" href="<?php echo $page->exportLink; ?>">Export</a></td>
	</tr>
<?php
}
?>
</table>
</section>
<?php include (ModulaiseController::$DIR_MODULAISE_ROOT.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."common".DIRECTORY_SEPARATOR."footer.html");?>
</body>
</html>
		<?php 
	}

	public static function getPages(){

		// Get all pages
		$returnArray = array();
		$pageDirectory = ModulaiseController::$DIR_DOCUMENT_ROOT.DIRECTORY_SEPARATOR.PATH_PAGES;
		$allPages = ModulaiseUtils::getDirectoryAsArray($pageDirectory);
		foreach ($allPages as $file){
			if (ModulaiseUtils::EndsWith($file,".php")){
				$pageName = substr($file, 0, -4);;
				$currentLink = PATH_PAGES."/".substr($file, 0, -4).".php";
				$cacheLink = PATH_PAGES."/".substr($file, 0, -4).".php?writeCachedHtml=true";
				$exportLink = PATH_PAGES_COMPILED."/".substr($file, 0, -4).".html";
				array_push($returnArray, new ModulaiseIndexPageElement($pageName,$currentLink,$exportLink,$cacheLink));
			}
		}
		return $returnArray;
	}
	

}

?>