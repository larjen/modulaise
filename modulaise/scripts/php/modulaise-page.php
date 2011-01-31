<?php

require_once ('modulaise-utils.php');
require_once ('modulaise-pane-content.php');
require_once ('modulaise-module.php');

/**
 * Defines a page
 *
 * @author Lars Jensen, lars.jensen@exenova.dk
 *
 */
class ModulaisePage
{

	/**
	 * Name of the page
	 * @var string
	 */
	public $pageTitle;

	/**
	 * Name of the page template from the templates folder used for rendering this page
	 * @var string
	 */
	public $templateId;

	/**
	 * List of the ModulaiseModules included in this specific page
	 * @var Array
	 */
	private $pageModules = Array();

	/**
	 * Holds the pane content for this page
	 * @var ModulaisePaneContent
	 */
	private $paneContent;

	/**
	 * Constructs the page
	 * @param ModulaisePaneContent $globalPaneContent
	 * @param string $templateId
	 * @param string $pageTitle
	 */
	function __construct(ModulaisePaneContent $globalPaneContent,$templateId,$pageTitle=NULL){
		$this->paneContent = new ModulaisePaneContent();

		// add global panecontent to the pages panecontent
		$this->paneContent->addPaneContent($globalPaneContent);

		// set the page title to be the file name of the page
		if ($pageTitle==NULL){
			$pageTitle= basename($_SERVER["PHP_SELF"],".php");
		}
		$this->pageTitle = $pageTitle;

		// set the pagetemplate to use
		$this->templateId = $templateId;
	}

	/**
	 * Adds a module to this page
	 * @param string $paneId
	 * @param string $moduleId
	 * @param string $overrideHtmlSnippet
	 */
	function addModule($paneId,$moduleId,$overrideHtmlSnippet){
		$module = new ModulaiseModule($moduleId,$paneId,$overrideHtmlSnippet);
		$this->paneContent->addPaneContent($module->getPaneContent());
		array_push($this->pageModules, $module);
	}

	/**
	 * Prints a pane from this page
	 * @param string $paneId
	 */
	public function printPane($paneId){

		// If we are going to show an export
		if (ModulaiseController::$buildMode==SHOW_EXPORT){
			switch ($paneId) {
				case PANE_JS_HEAD:
					echo ModulaiseUtils::getJsImportStatement(FOLDER_COMPILED."/js/".FILENAME_JSHEAD_COMPILED);
					return true;
				case PANE_JS_FOOT:
					echo ModulaiseUtils::getJsImportStatement(FOLDER_COMPILED."/js/".FILENAME_JSFOOT_COMPILED);
					return true;
				case PANE_CSS:
					echo ModulaiseUtils::getCssImportStatement(FOLDER_COMPILED."/css/".FILENAME_CSS_COMPILED);
					return true;
				default:
					return $this->paneContent->printPane($paneId);
					return true;
			}
		}
		return $this->paneContent->printPane($paneId);
	}

	/**
	 * Gets all panenames as array
	 */
	public function getPaneNames(){
		return $this->paneContent->getPaneNames();
	}

	/**
	 * Checks if a pane has content, if it has true is returned
	 */
	public function paneHasContent($paneId){
		return $this->paneContent->paneHasContent($paneId);
	}
}

?>