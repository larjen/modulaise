<?php

/**
 * This is a module
 *
 * @author Lars Jensen, lars.jensen@exenova.dk
 *
 */
Class ModulaiseModule {

	/**
	 * Id for this module
	 * @var string
	 */
	private $moduleId;

	/**
	 * If not using the default HTML file index.html this variable is set
	 *
	 * @var string
	 */
	private $overrideHtmlSnippet;

	/**
	 * Holds the pane content for this module
	 *
	 * @var ModulaisePaneContent
	 */
	private $paneContent;

	/**
	 * Constructs the module
	 * @param string $moduleId
	 * @param string $paneId
	 * @param string $overrideHtmlSnippet
	 * @param int $priorityId
	 */
	public function __construct($moduleId,$paneId=NULL,$overrideHtmlSnippet=NULL,$priorityId=-1){
		$debug = false;
		if ($debug){
			ModulaiseController::printComment("\n\n".get_class()."__construct: ".$moduleId.", ".$paneId.", ".$overrideHtmlSnippet.", ".$priorityId."\n\n");
		}
		$this->paneContent = new ModulaisePaneContent();
		$this->moduleId = $moduleId;
		if ($overrideHtmlSnippet == NULL || $overrideHtmlSnippet == ""){
			$this->overrideHtmlSnippet="index.html";
		}else{
			$this->overrideHtmlSnippet=$overrideHtmlSnippet;
		}

		// check to see if there is a cached version of this modules paneContent
		$cachedPane = ModulaiseController::getCachedModulePaneContent($moduleId);
		if($cachedPane == false){
			$this->initializePaneContent();
			ModulaiseController::setCachedModulePaneContent($moduleId,$this->paneContent);
		}
		if ($priorityId == -1){
			$priorityId = 75;
		}

		// add the html snippet to the module pane if there is one
		if ($paneId!=NULL){
			if (!$this->paneContent->addFileSnippet($moduleId,$paneId,$priorityId,"html".DIRECTORY_SEPARATOR.$this->overrideHtmlSnippet)){
				
				// The snippet was not added, but it could be on purpose
				
			}
		}
	}

	/**
	 * Returns pane content for this module
	 */
	public function getPaneContent(){
		return $this->paneContent;
	}

	/**
	 * Initilizes the pane content for this module
	 */
	private function initializePaneContent(){
		if (!$this->paneContent->initialize($this->moduleId)){
			ModulaiseController::printComment("\n\nERROR:\nModule could not initialized ".$this->moduleId."\n\n");
		}
	}
}

?>