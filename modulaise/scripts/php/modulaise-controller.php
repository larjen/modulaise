<?php

// Include needed classes
require_once ('modulaise-utils.php');
require_once ('modulaise-page.php');
require_once ('modulaise-capture-output.php');

// Path to WebContent
ModulaiseController::$DIR_DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];

// Path to modulaise php scripts
ModulaiseController::$DIR_MODULAISE_ROOT = $_SERVER["DOCUMENT_ROOT"].DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."modulaise".DIRECTORY_SEPARATOR."scripts".DIRECTORY_SEPARATOR."php";

// Initialize ModulaiseController
ModulaiseController::initialize();

/**
 * Controls the rendering of pages
 *
 * @author Lars Jensen, lars.jensen@exenova.dk
 *
 */
Class ModulaiseController{

	/**
	 * Path to modules
	 * @var string
	 */
	public static $PATH_MODULES = false;
	
	/**
	 * Document root for the server
	 * @var string
	 */
	public static $DIR_DOCUMENT_ROOT;

	/**
	 * Root folder for the modulaise installation
	 * @var string
	 */
	public static $DIR_MODULAISE_ROOT;
	
	/**
	 * The buildtag for the current build
	 * @var string
	 */
	public static $buildTag;

	/**
	 * Wether or not we are building a static version of the page
	 * @var int
	 */
	public static $buildMode = SHOW_DEVELOPMENT;

	/**
	 * The path to the static contentfolder
	 * @var string
	 */
	public static $staticContentPath = false;

	/**
	 * All pages
	 * @var Array
	 */
	private static $pages = Array();

	/**
	 * All global modules
	 * @var Array
	 */
	private static $globalModules = Array();

	/**
	 * Global panecontents
	 * @var ModulaisePaneContent
	 */
	private static $globalPaneContent;

	/**
	 * Everytime a module is added put the the computed pane contents into this cache
	 * @var Array
	 */
	private static $modulePaneContentsCache = Array();

	/**
	 * Everytime a new page is created this counter is increased by one if and only if we need all pages in memory
	 * @var int
	 */
	private static $currentPageId = 0;

	/**
	 * Initializes all global settings and all global modules
	 */
	public static function initialize(){
		$debug = false;
		
		// set the buildtag
		if (isset($_REQUEST["buildTag"])){
			self::$buildTag = $_REQUEST["buildTag"];
		}else{
			self::$buildTag = "no-buildtag";
		}
		
		// Include modulaise php scripts to the include path
		set_include_path(get_include_path() . PATH_SEPARATOR . self::$DIR_MODULAISE_ROOT);

		// Read global configuration file
		ModulaiseUtils::readConfigurationFile(ModulaiseController::$DIR_DOCUMENT_ROOT.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."modulaise".DIRECTORY_SEPARATOR."config-global".DIRECTORY_SEPARATOR."global.config");
		
		// Read configuration file
		ModulaiseUtils::readConfigurationFile(ModulaiseController::$DIR_DOCUMENT_ROOT.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR."modulaise".DIRECTORY_SEPARATOR."config-project".DIRECTORY_SEPARATOR."project.config");

		// set the path to modules if not already set
		if (self::$PATH_MODULES === false){
			self::$PATH_MODULES = PATH_MODULES;
		}
		
		// reset cache
		self::$modulePaneContentsCache = Array();
		self::$globalPaneContent = new ModulaisePaneContent();
		self::$globalModules = Array();

		// set the static path to the page
		if (self::$staticContentPath === false){
			if (self::$buildMode == SHOW_EXPORT){
				self::$staticContentPath = PATH_MODULES_BUILD;
			} else {
				self::$staticContentPath = PATH_MODULES_DEVELOPMENT;
			}
		}

		// path to all modules
		$allModulesPath = self::$DIR_DOCUMENT_ROOT.DIRECTORY_SEPARATOR.self::$PATH_MODULES;
		if ($debug){
			self::printComment("\n\n".get_class()."->initialize(): \n\nallModulesPath=".$allModulesPath."\n\n");
		}

		// add all global modules to global modules array
		$allModuleNames = ModulaiseUtils::getDirectoryAsArray($allModulesPath,ONLY_DIRECTORIES);

		// build a list of all global modules
		foreach ($allModuleNames as $moduleId){
			if (substr($moduleId, 0, 1) == "0"){
				$module = New ModulaiseModule($moduleId);
				array_push(self::$globalModules,$module);
				self::$globalPaneContent->addPaneContent($module->getPaneContent());
			}
		}
		if ($debug){
			$a = print_r(self::$globalPaneContent->getContent(),TRUE);
			self::printComment("\n\n".get_class()."->initialize(): \n\n".$a."\n\n");
		}
	}

	/**
	 * Creates a new page
	 */
	public static function createPage($templateId,$pageTitle){

		// create a new id
		self::$currentPageId++;

		// Add a new page to the array of pages
		self::$pages[self::$currentPageId]= new ModulaisePage(self::$globalPaneContent,$templateId,$pageTitle);
	}

	/**
	 * Print page title
	 */
	public static function printPageTitle(){

		// Add a new page to the array of pages
		echo self::$pages[self::$currentPageId]->pageTitle;
	}
	
	/**
	 * Get page title
	 */
	public static function getPageTitle(){

		// Add a new page to the array of pages
		return self::$pages[self::$currentPageId]->pageTitle;
	}

	/**
	 * Adds a module to the page
	 */
	public static function addModule($paneId,$moduleId,$overrideHtmlSnippet=NULL){
		self::$pages[self::$currentPageId]->addModule($paneId,$moduleId,$overrideHtmlSnippet);
	}

	/**
	 * Gets all panenames as array
	 */
	public static function getPaneNames(){
		return self::$pages[self::$currentPageId]->getPaneNames();
	}

	/**
	 * Prints a pane
	 */
	public static function printPane($paneId){
		// Print a pane from a page
		if(!self::$pages[self::$currentPageId]->printPane($paneId)){
			self::printComment("Pane not found ".$paneId);
		}
	}

	/**
	 * Checks if a pane has content, if it has true is returned
	 */
	public static function paneHasContent($paneId){
		return self::$pages[self::$currentPageId]->paneHasContent($paneId);
	}

	/**
	 * Prints the entire page
	 */
	public static function printPage(){

		// If we are building a page, create the static HTML file with static links
		if (self::$buildMode == SHOW_EXPORT){
				
			// the file to write
			if (PATH_PAGES_COMPILED!=""){
				$writeFile = self::$DIR_DOCUMENT_ROOT.DIRECTORY_SEPARATOR.PATH_PAGES_COMPILED.DIRECTORY_SEPARATOR.self::$pages[self::$currentPageId]->pageTitle.".html";
			}else{
				$writeFile = self::$DIR_DOCUMENT_ROOT.PATH_PAGES_COMPILED.DIRECTORY_SEPARATOR.self::$pages[self::$currentPageId]->pageTitle.".html";
			}

			// capture output start
			$captureOutput = new ModulaiseCaptureOutput();
			$captureOutput->start();

			// render the page
			include(self::$DIR_DOCUMENT_ROOT.DIRECTORY_SEPARATOR.PATH_TEMPLATES.DIRECTORY_SEPARATOR.self::$pages[self::$currentPageId]->templateId);

			// capture output end
			$output = $captureOutput->end();

			// write the output to file
			ModulaiseUtils::writeFile($writeFile,$output);
		}else{

			// unless specifically requested the intermediate static html file will not be written
			$writeCached = isset($_REQUEST["writeCachedHtml"]) ?$_REQUEST["writeCachedHtml"]:"false";
			
			if ($writeCached=="true") {

				// the file to write
				$writeFile = self::$DIR_DOCUMENT_ROOT.DIRECTORY_SEPARATOR.PATH_PAGES_CACHED.DIRECTORY_SEPARATOR.self::$pages[self::$currentPageId]->pageTitle.".html";
					
				// capture output start
				$captureOutput = new ModulaiseCaptureOutput();
				$captureOutput->start();

				// render the page
				include(self::$DIR_DOCUMENT_ROOT.DIRECTORY_SEPARATOR.PATH_TEMPLATES.DIRECTORY_SEPARATOR.self::$pages[self::$currentPageId]->templateId);
					
				// capture output end
				$output = $captureOutput->end();
					
				// write the output to file
				ModulaiseUtils::writeFile($writeFile,$output);

				// redirect to the static page
				header("Location: http://".$_SERVER["SERVER_NAME"]."/".PATH_PAGES_CACHED."/".self::$pages[self::$currentPageId]->pageTitle.".html");

			}else{
					
				// render the page
				include(self::$DIR_DOCUMENT_ROOT.DIRECTORY_SEPARATOR.PATH_TEMPLATES.DIRECTORY_SEPARATOR.self::$pages[self::$currentPageId]->templateId);
			}
		}
	}

	/**
	 * Gets a module from the cache if it does not exist return false
	 */
	public static function getCachedModulePaneContent($moduleId){
		if (isset(self::$modulePaneContentsCache[$moduleId])){
			return self::$modulePaneContentsCache[$moduleId];
		}else{
			return false;
		}
	}

	/**
	 * Places a modules paneContent in the cache
	 */
	public static function setCachedModulePaneContent($moduleId, ModulaisePaneContent $paneContent){
		self::$modulePaneContentsCache[$moduleId]=$paneContent;
	}

	/**
	 * Prints a comment
	 */
	public static function printComment($comment){
		ModulaiseUtils::printComment($comment);
	}

	/**
	 * Prints the static content path
	 */
	public static function printStaticContentPath(){
		echo self::$staticContentPath;
	}

	/**
	 * Initiates index action
	 */
	public static function indexAction(){

		switch (isset($_REQUEST["action"]) ? $_REQUEST["action"]:"") {
			case "build":
		
				// Builds the page
				require_once ("modulaise-build.php");
				ModulaiseBuild::build();
				break;
		
			case "getAntProperties":
		
				// Get ant properties
				require_once ("modulaise-get-ant-properties.php");
				AntPropertiesWriter::getAntProperties();
				break;
				
			case "printpane":
		
				// Get ant properties
				self::initialize();
				
				// If we are going to show export pane
				if (isset($_REQUEST["buildmode"]) && $_REQUEST["buildmode"] == "SHOW_EXPORT"){
					self::$buildMode = SHOW_EXPORT;					
				}
				
				// create a dummy page
				self::createPage("nullstring","nullstring");
				
				// if the requested pane has content print it - otherwise print a no content comment
				if (isset($_REQUEST["pane"]) && self::paneHasContent($_REQUEST["pane"])){
					self::printPane($_REQUEST["pane"]);
				}else{
					echo "<!-- no content found for pane \"".$_REQUEST["pane"]."\" -->";
				}

				break;
		
			default:
		
				// Prints the index page
				require_once ("modulaise-index-page.php");
				ModulaiseIndexPage::printPage();
				break;
		}
	}
}

?>