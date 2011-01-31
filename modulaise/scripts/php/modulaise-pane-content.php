<?php

/**
 * Contains the pane contents
 *
 * @author Lars Jensen, lars.jensen@exenova.dk
 *
 */
class ModulaisePaneContent
{
	/**
	 * This is an ordered array containing the panesnippets
	 * @var Array
	 */
	private $content = Array();

	/**
	 * Constructs the pane contents
	 */
	public function __construct(){
		$this->content = Array();

	}

	/**
	 * Initialize
	 */
	public function initialize($moduleId){

		$debug = false;

		// first get the directory contents of the module
		$targetDir = ModulaiseController::$DIR_DOCUMENT_ROOT.DIRECTORY_SEPARATOR.ModulaiseController::$PATH_MODULES.DIRECTORY_SEPARATOR.$moduleId;
		$moduleDirectory = ModulaiseUtils::getDirectoryAsArray($targetDir,ONLY_DIRECTORIES);

		foreach ($moduleDirectory as $outerDir){
			$d = explode(DELIMITER,$outerDir);
			if ($debug){
				ModulaiseController::printComment("\n\n".get_class()."->initializePaneContent(): \nd[0]=".$d[0]."\nd[1]=".$d[1]."\nd[2]=".$d[2]."\n\n");
			}
				
			// check for html
			if ($d[0]=="html"){

				// html_head pane
				if (isset($d[1]) && $d[1]=="head"){
					$priorityId = -1;
					if (isset($d[2]) && ctype_digit($d[2])){
						$priorityId = intval($d[2]);
					}
					if(!isset($d[2])){
						$priorityId = 75;
					}
					if ($priorityId != -1){
							
						// Set target pane
						if ($priorityId < 50){
							$targetPane = PANE_HTML_HEAD_FIRST;
						}else{
							$targetPane = PANE_HTML_HEAD_LAST;
						}

						// add all snippets from html_head directory to panecontent
						$innerDirectory = ModulaiseUtils::getDirectoryAsArray($targetDir.DIRECTORY_SEPARATOR.$outerDir,ONLY_FILES);
						foreach ($innerDirectory as $file){
							$this->addFileSnippet($moduleId, $targetPane, $priorityId, $outerDir.DIRECTORY_SEPARATOR.$file);
						}
					}
				}

				// html_foot pane
				if (isset($d[1]) && $d[1]=="foot"){
					$priorityId = -1;
					if (isset($d[2]) && ctype_digit($d[2])){
						$priorityId = intval($d[2]);
					}
					if(!isset($d[2])){
						$priorityId = 75;
					}
					if ($priorityId != -1){
							
						// Set target pane
						if ($priorityId < 50){
							$targetPane = PANE_HTML_FOOT_FIRST;
						}else{
							$targetPane = PANE_HTML_FOOT_LAST;
						}

						// add all snippets from html_foot directory to panecontent
						$innerDirectory = ModulaiseUtils::getDirectoryAsArray($targetDir.DIRECTORY_SEPARATOR.$outerDir,ONLY_FILES);

						foreach ($innerDirectory as $file){
							$this->addFileSnippet($moduleId, $targetPane, $priorityId, $outerDir.DIRECTORY_SEPARATOR.$file);
						}
					}
				}
			}

			// check for javascript
			if ($d[0]=="js"){

				// js_head pane
				if (isset($d[1]) && $d[1]=="head"){
					$priorityId = -1;
					if (isset($d[2]) && ctype_digit($d[2])){
						$priorityId = intval($d[2]);
					}
					if(!isset($d[2])){
						$priorityId = 75;
					}
					if ($priorityId != -1){
						$targetPane = PANE_JS_HEAD;

						// add all snippets from js_head directory to panecontent
						$innerDirectory = ModulaiseUtils::getDirectoryAsArray($targetDir.DIRECTORY_SEPARATOR.$outerDir,ONLY_FILES);
						if ($debug){
							ModulaiseController::printComment("\n\n".get_class()."->initializePaneContent(): innerDirectory=".$innerDirectory."\n\n");
						}
						foreach ($innerDirectory as $file){
							if ($debug){
								ModulaiseController::printComment("\n\n".get_class()."->initializePaneContent(): ".$moduleId.", ".$targetPane.", ".$priorityId.", ".$outerDir.DIRECTORY_SEPARATOR.$file."\n\n");
							}
							if(ModulaiseController::$buildMode == SHOW_DEVELOPMENT){
								$this->addStringSnippet($moduleId, $targetPane, $priorityId, ModulaiseUtils::getJsImportStatement($moduleId."/".$outerDir."/".$file));
							}
							if(ModulaiseController::$buildMode == SHOW_EXPORT){

							}
							if(ModulaiseController::$buildMode == BUILD_EXPORT){
								$this->addFileSnippet($moduleId, $targetPane, $priorityId, $outerDir.DIRECTORY_SEPARATOR.$file);
							}
						}
					}
				}

				// js_foot pane
				if (isset($d[1]) && $d[1]=="foot"){
					$priorityId = -1;
					if (isset($d[2]) && ctype_digit($d[2])){
						$priorityId = $d[2];
					}
					if(!isset($d[2])){
						$priorityId = 75;
					}
					if ($priorityId != -1){
							
						// Set target pane
						$targetPane = PANE_JS_FOOT;

						// add all snippets from js_foot directory to panecontent
						$innerDirectory = ModulaiseUtils::getDirectoryAsArray($targetDir.DIRECTORY_SEPARATOR.$outerDir,ONLY_FILES);
						foreach ($innerDirectory as $file){
							if ($debug){
								ModulaiseController::printComment("\n\n".get_class()."->initializePaneContent(): ".$moduleId.", ".$targetPane.", ".$priorityId.", ".$outerDir.DIRECTORY_SEPARATOR.$file."\n\n");
							}
							if(ModulaiseController::$buildMode == SHOW_DEVELOPMENT){
								$this->addStringSnippet($moduleId, $targetPane, $priorityId, ModulaiseUtils::getJsImportStatement($moduleId."/".$outerDir."/".$file));
							}
							if(ModulaiseController::$buildMode == SHOW_EXPORT){
								$this->addFileSnippet($moduleId, $targetPane, $priorityId, $outerDir.DIRECTORY_SEPARATOR.$file);
							}
							if(ModulaiseController::$buildMode == BUILD_EXPORT){
								$this->addFileSnippet($moduleId, $targetPane, $priorityId, $outerDir.DIRECTORY_SEPARATOR.$file);
							}
						}
					}
				}
			}

			// check for css
			if ($d[0]=="css"){
				if ($debug){
					ModulaiseController::printComment("\n\n".get_class()."->initializePaneContent(): d[0]==\"css\"\n\n");
				}
				$priorityId = -1;
				if (isset($d[1])){
					if (ctype_digit($d[1])||is_int($d[1])){
						$priorityId = intval($d[1]);
					}
				}
				if(!isset($d[1])){
					$priorityId = 75;
				}
				if ($debug){
					ModulaiseController::printComment("\n\n".get_class()."->initializePaneContent(): priorityId=".$priorityId."\n\n");
				}
				if ($priorityId != -1){
					if ($debug){
						ModulaiseController::printComment("\n\n".get_class()."->initializePaneContent(): priorityId != NULL\n\n");
					}

					// add all CSS snippets from css directory to panecontent
					$innerDirectory = ModulaiseUtils::getDirectoryAsArray($targetDir.DIRECTORY_SEPARATOR.$outerDir,ONLY_FILES);
					if ($debug){
						ModulaiseController::printComment("\n\n".get_class()."->initializePaneContent(): innerDirectory=".$innerDirectory."\n\n");
					}
					foreach ($innerDirectory as $file){
						
						// set the target pane name to this complicated formula
						$targetPane = PANE_CSS."--".$priorityId."--".$file;
						
						if ($debug){
							ModulaiseController::printComment("\n\n".get_class()."->initializePaneContent(): ".$moduleId.", ".$targetPane.", ".$priorityId.", ".$outerDir.DIRECTORY_SEPARATOR.$file."\n\n");
						}
						if ($debug){
							ModulaiseController::printComment("\n\n".get_class()."->initializePaneContent(): ".$moduleId.", ".$targetPane.", ".$priorityId.", ".$outerDir.DIRECTORY_SEPARATOR.$file."\n\n");
						}
						if(ModulaiseController::$buildMode == SHOW_DEVELOPMENT){
							$this->addStringSnippet($moduleId, $targetPane, $priorityId, ModulaiseUtils::getCssImportStatement($moduleId."/".$outerDir."/".$file,$file));
						}
						if(ModulaiseController::$buildMode == SHOW_EXPORT){
							
						}
						if(ModulaiseController::$buildMode == BUILD_EXPORT){
							$this->addExportCssSnippet($moduleId, $targetPane, $priorityId, $outerDir.DIRECTORY_SEPARATOR.$file);
						}
					}
				}
			}
		}
		
		$this->sortPanes();
		return true;
	}
	
	/**
	 * Prints CSS pane
	 */
	private function printCSSPane(){
		
		// Start by sorting the panes
		$this->sortPanes();
		
		// Prepare an empty array to hold the css
		$concatinated_css = Array();
		
		$debug = false;

		// get the pane names
		$paneNames = ModulaiseController::getPaneNames();
		foreach ($this->content as $name=>$value){
			if ($debug===true){
				echo "paneName=".$name."\n";
			}
			$pos = strpos($name,PANE_CSS);
			if (!($pos === false)) {
				$nameArrays = explode("--",$name);
				if (ModulaiseController::paneHasContent($name)){
					// render the pane
					ModulaiseController::printPane($name);
			    }
			}
		}
		return true;
	}

	/**
	 * Sorts panes, used for printing the CSS panes out in the correct order
	 */
	function sortPanes(){
		ksort ( $this->content);
	}
	
	/**
	 * Prints the pane
	 * @param string $paneId
	 */
	function printPane($paneId){
		
		// If we are trying to print the css pane
		if($paneId == PANE_CSS){
			return $this->printCSSPane();
		}
		
		if (!isset($this->content[$paneId])){
			return false;
		}

		$debug = false;
		if ($debug === true){
			ModulaiseController::printComment("\n\n".get_class()."->printPane(): ".print_r($this->content[$paneId])."\n\n");
		}

		// now sort according to $priority keys
		ksort($this->content[$paneId]);
		if ($debug === true){
			ModulaiseController::printComment("\n\n".get_class()."->printPane(): ".print_r($this->content[$paneId])."\n\n");
		}
		foreach($this->content[$paneId] as $priorityId){
			foreach ($priorityId as $snippet){
				echo "\n".$snippet."\n";
			}
		}
		return true;
	}

	/**
	 * Returns this content
	 */
	public function getContent(){
		return $this->content;
	}

	/**
	 * Returns pane names
	 */
	public function getPaneNames(){
		$paneNames = Array();
		foreach ($this->content as $key=>$value){
			array_push($paneNames,$key);
		}
		return $paneNames;
	}

	/**
	 * Adds a snippet to this pane contents
	 */
	public function addFileSnippet($moduleId, $paneId, $priorityId, $snippetPath){
		$debug = false;
		$priorityId = intval($priorityId);
		$fileName = ModulaiseController::$DIR_DOCUMENT_ROOT.DIRECTORY_SEPARATOR.ModulaiseController::$PATH_MODULES.DIRECTORY_SEPARATOR.$moduleId.DIRECTORY_SEPARATOR.$snippetPath;
		if ($debug){
			ModulaiseController::printComment("\n\n".get_class()."->addFileSnippet(): ".$moduleId.", ".$paneId.", ".$priorityId.", ".$snippetPath."\n\n");
		}

		// check if the file to include exists:
		if (isset($fileName) && is_file($fileName)) {

			// extract variables from the global scope:
			extract($GLOBALS, EXTR_REFS);
			ob_start();
			include($fileName);
			$snippet = ob_get_clean();
		} else {
			ob_clean();
			return false;
		}

		// add to content
		if (!$this->addContent($paneId,$priorityId,$snippet)){
			ModulaiseController::printComment("\n\nERROR:\n".get_class()."->addFileSnippet(): ".$paneId.", ".$priorityId.", ".$snippetPath."\n\n");
			die();
		}
		return true;
	}

	/**
	 * Adds a css snippet for export purposes
	 */
	public function addExportCssSnippet($moduleId, $paneId, $priorityId, $snippetPath){
		$debug = false;
		$priorityId = intval($priorityId);
		$fileName = ModulaiseController::$DIR_DOCUMENT_ROOT.DIRECTORY_SEPARATOR.ModulaiseController::$PATH_MODULES.DIRECTORY_SEPARATOR.$moduleId.DIRECTORY_SEPARATOR.$snippetPath;
		if ($debug){
			ModulaiseController::printComment("\n\n".get_class()."->addFileSnippet(): ".$moduleId.", ".$paneId.", ".$priorityId.", ".$snippetPath."\n\n");
		}

		// check if the file to include exists:
		if (isset($fileName) && is_file($fileName)) {

			// extract variables from the global scope:
			extract($GLOBALS, EXTR_REFS);
			ob_start();
			include($fileName);
			$snippet = ob_get_clean();
		} else {
			ob_clean();
			return false;
		}
		
		// If there is a media type { } around the snippet this function extracts it
		$snippet = ModulaiseUtils::extractCss($snippet);

		// add to content
		if (!$this->addContent($paneId,$priorityId,$snippet)){
			ModulaiseController::printComment("\n\nERROR:\n".get_class()."->addFileSnippet(): ".$paneId.", ".$priorityId.", ".$snippetPath."\n\n");
			die();
		}
		return true;
	}

	/**
	 * Adds a stringsnippet to a pane
	 */
	public function addStringSnippet($moduleId, $paneId, $priorityId, $snippet){
		$debug = false;
		$priorityId = intval($priorityId);
		if ($debug){
			ModulaiseController::printComment("\n\n".get_class()."->addFileSnippet(): ".$moduleId.", ".$paneId.", ".$priorityId.", ".$snippetPath."\n\n");
		}

		// add to content
		if (!$this->addContent($paneId,$priorityId,$snippet)){
			ModulaiseController::printComment("\n\nERROR:\n".get_class()."->addFileSnippet(): ".$paneId.", ".$priorityId.", ".$snippetPath."\n\n");
			die();
		}
	}

	/**
	 * Concatinates two panecontents into eachother, preserving any priority id's
	 */
	function addPaneContent(ModulaisePaneContent $modulaisePaneContent){
		$debug = false;
		if ($debug){
			$a = print_r($modulaisePaneContent->getContent(),TRUE);
			ModulaiseController::printComment("\n\n".get_class()."->addPaneContent(): \n\n".$a."\n\n");
		}

		// adds paneContent to this paneContent
		foreach ($modulaisePaneContent->getContent() as $paneId=>$paneIdArray){
			if ($debug){
				ModulaiseController::printComment("\n\n".get_class()."->addPaneContent(): foreach modulaisePaneContent->getContent() as paneId=>paneIdArray (".gettype($modulaisePaneContent->getContent())." as ".gettype($paneId)."=>".gettype($paneIdArray).")\n\n");
			}
			foreach ($paneIdArray as $priorityId=>$priorityIdArray){
				if ($debug){
					ModulaiseController::printComment("\n\n".get_class()."->addPaneContent(): foreach paneIdArray as priorityId=>priorityIdArray (".gettype($paneIdArray)." as ".gettype($priorityId)."=>".gettype($priorityIdArray).")\n\n");
				}
				foreach ($priorityIdArray as $key=>$snippet){
					if ($debug){
						ModulaiseController::printComment("\n\n".get_class()."->addPaneContent(): foreach priorityIdArray as key=>snippet (".gettype($priorityIdArray)." as ".gettype($key)."=>".gettype($snippet).")\n\n");
						ModulaiseController::printComment("\n\n".get_class()."->addPaneContent(): paneId, priorityId, snippet (".gettype($paneId).", ".gettype(priorityId).", ".gettype($snippet).")\n\n");
						ModulaiseController::printComment("\n\n".get_class()."->addPaneContent(): paneId, priorityId, snippet (".$paneId.", ".priorityId.", ".$snippet.")\n\n");
					}
						
					// add to content
					if (!$this->addContent($paneId,$priorityId,$snippet)){
						ModulaiseController::printComment("\n\nERROR:\n".get_class()."->addPaneContent(): ".$paneId.", ".$priorityId.", ".$snippet."\n\n");
						die();
					}
				}
			}
		}
		
		// Also sort afterwards, to maintain the order of CSS panes
		$this->sortPanes();
	}

	/**
	 * Adds $snippet to a $paneId with $priorityId
	 */
	private function addContent($paneId, $priorityId, $snippet){
		$debug = false;
		if ($debug){
			ModulaiseController::printComment("\n\n".get_class()."->addContent ".gettype($paneId).", ".gettype($priorityId).", ".gettype($snippet)."\n".get_class()."->addContent ".$paneId.", ".$priorityId.", ".strlen($snippet)."\n\n");
		}
		if (!is_string($paneId)||!is_int($priorityId)||!is_string($snippet)){
			return false;
		}

		// make sure the pane we are adding the snippet to is initialized
		if (!$this->addPane($paneId,$priorityId)){
			ModulaiseController::printComment("\n\nERROR:\n".get_class()."->addContent ".$paneId.", ".$priorityId.", ".strlen($snippet)."\n\n");
			die();
		}

		// add snippet to pane
		$this->content[$paneId][$priorityId][] = $snippet;

		// add snippet to pane
		$destinationPane = $this->content[$paneId];
		if ($debug){
			ModulaiseController::printComment("\n\n".get_class()."->addContent(): destinationPane (".gettype($destinationPane).")\n\n");
			$a = print_r($destinationPane,TRUE);
			ModulaiseController::printComment("\n\n".get_class()."->addContent(): destinationPane\n\n".$a."\n\n");
		}
		$destinationPriority = $destinationPane[$priorityId];
		if ($debug){
			ModulaiseController::printComment("\n\n".get_class()."->addContent(): destinationPriority (".gettype($destinationPriority).")\n\n");
			$a = print_r($destinationPriority,TRUE);
			ModulaiseController::printComment("\n\n".get_class()."->addContent(): destinationPriority\n\n".$a."\n\n");
		}
		$destinationPriority[]=$snippet;
		if ($debug){
			$a = print_r($this->content,TRUE);
			ModulaiseController::printComment("\n\n".get_class()."->addContent(): \n\n".$a."\n\n");
		}
		return true;
	}

	/**
	 * Adds a pane with a priority Id
	 */
	private function addPane($paneId,$priorityId){
		$debug = false;
		if(!is_string($paneId)||!is_int($priorityId)){
			return false;
		}
		if ($debug){
			ModulaiseController::printComment("\n\n".get_class()."->addPane ".$paneId.", ".$priorityId."\n\n");
		}
		if (!array_key_exists($paneId, $this->content)){
			$this->content[$paneId]=Array();
		}
		if (!array_key_exists($priorityId, $this->content[$paneId])){
			$this->content[$paneId][$priorityId]=Array();
		}
		if ($debug){
			$a = print_r($this->content,TRUE);
			ModulaiseController::printComment("\n\n".get_class()."->addPane \n\n".$a."\n\n");
		}
		return true;
	}

	/**
	 * Checks if a pane has content, if it has true is returned
	 */
	public function paneHasContent($paneId){
		if (!isset($this->content[$paneId])){
			return false;
		}
		$returnValue = false;
		$debug = false;
		if ($debug === true){
			ModulaiseController::printComment("\n\n".get_class()."->printPane(): ".print_r($this->content[$paneId])."\n\n");
		}

		// now sort according to $priority keys
		ksort($this->content[$paneId]);
		if ($debug === true){
			ModulaiseController::printComment("\n\n".get_class()."->printPane(): ".print_r($this->content[$paneId])."\n\n");
		}
		foreach($this->content[$paneId] as $priorityId){
			foreach ($priorityId as $snippet){
				if (strlen(trim($snippet))!=0){
					$returnValue = true;
				}
			}
		}
		return $returnValue;
	}
}
?>