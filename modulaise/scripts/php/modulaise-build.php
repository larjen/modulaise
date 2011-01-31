<?php

require_once ('modulaise-utils.php');
require_once ('modulaise-build.php');
require_once ('modulaise-page.php');
require_once ('modulaise-capture-output.php');

/**
 * Class that builds javascript and css
 *  
 * @author Lars Jensen, lars.jensen@exenova.dk
 *
 */
Class ModulaiseBuild {

	/**
	 * Builds everything, initiated from ant
	 */
	public static function build(){
		echo "\nStarting build ".ModulaiseController::$buildTag."\n--------------------------------------------------------------------------------\n\n";

		// time the build
		$timeparts = explode(' ',microtime());
		$starttime = $timeparts[1].substr($timeparts[0],1);
		$timeparts = explode(' ',microtime());

		// build the pages
		ModulaiseBuild::buildPages();
		
		// build css and javascript
		ModulaiseBuild::buildCompiled();

		// show total time elapsed
		$endtime = $timeparts[1].substr($timeparts[0],1);
		echo "\nBuild completed\n--------------------------------------------------------------------------------\nBuild script time       : ".bcsub($endtime,$starttime,6)." seconds\n\n";
	}

	/**
	 * Builds the export version of the HTML pages
	 */
	public static function buildPages(){
		echo "\nBuilding static pages\n--------------------------------------------------------------------------------\n";

		// set the PageController buildMode to SHOW_EXPORT
		ModulaiseController::$buildMode = SHOW_EXPORT;

		// set the static content path to right value
		ModulaiseController::$staticContentPath = PATH_MODULES_BUILD;
		
		// Reset global modules
		ModulaiseController::initialize();

		// read all modulenames
		$allPages = ModulaiseUtils::getDirectoryAsArray(ModulaiseController::$DIR_DOCUMENT_ROOT.DIRECTORY_SEPARATOR.PATH_PAGES);
		foreach ($allPages as $file){
			if (ModulaiseUtils::EndsWith($file,".php")){

				// figure out filename to write
				if (PATH_PAGES_COMPILED!=""){
					echo "Writing static page     : ".ModulaiseController::$DIR_DOCUMENT_ROOT.DIRECTORY_SEPARATOR.PATH_PAGES_COMPILED.DIRECTORY_SEPARATOR.substr($file, 0, -4).".html\n";
				}else{
					echo "Writing static page     : ".ModulaiseController::$DIR_DOCUMENT_ROOT.DIRECTORY_SEPARATOR.substr($file, 0, -4).".html\n";
				}
				include(ModulaiseController::$DIR_DOCUMENT_ROOT.DIRECTORY_SEPARATOR.PATH_PAGES.DIRECTORY_SEPARATOR.$file);
			}
		}
	}

	/**
	 * Concatinates CSS and JavaScript
	 */
	public static function buildCompiled(){
		echo "\nConcatinating CSS and JavaScript\n--------------------------------------------------------------------------------\n";

		// set the PageController buildMode value to BUILD_EXPORT
		ModulaiseController::$buildMode = BUILD_EXPORT;

		// Reset global modules
		ModulaiseController::initialize();

		// Create a page containing all modules and then in turn print js_head, js_foot and css
		ModulaiseController::createPage("EXPORT","EXPORT");

		// add all global modules to global modules array
		$allModuleNames = ModulaiseUtils::getDirectoryAsArray(ModulaiseController::$DIR_DOCUMENT_ROOT.DIRECTORY_SEPARATOR.ModulaiseController::$PATH_MODULES,ONLY_DIRECTORIES);

		// build a list with all non-global modules
		foreach ($allModuleNames as $moduleId){
			echo "Compiling module        : ".$moduleId."\n";
			if (substr($moduleId, 0, 1) != "0"){
				ModulaiseController::addModule("EXPORT",$moduleId);
			}
		}
		
		$buildTagComment = "/*\n\nBuildtag: ".ModulaiseController::$buildTag."\n\n*/\n\n";

		// Write PANE_JS_HEAD

		// the file to write
		$writeFile = ModulaiseController::$DIR_DOCUMENT_ROOT.DIRECTORY_SEPARATOR.ModulaiseController::$PATH_MODULES.DIRECTORY_SEPARATOR.FOLDER_COMPILED.DIRECTORY_SEPARATOR."js".DIRECTORY_SEPARATOR."js_head.concatinated.js";
		echo "Writing file            : ".$writeFile."\n";

		// capture output start
		$captureOutput = new ModulaiseCaptureOutput();
		$captureOutput->start();
		echo $buildTagComment;
		if (ModulaiseController::paneHasContent(PANE_JS_HEAD)){
				
			// render the pane
			ModulaiseController::printPane(PANE_JS_HEAD);
		}
			
		// capture output end
		$output = $captureOutput->end();
			
		// write the output to file
		ModulaiseUtils::writeFile($writeFile,$output);

		// Write PANE_JS_FOOT

		// the file to write
		$writeFile = ModulaiseController::$DIR_DOCUMENT_ROOT.DIRECTORY_SEPARATOR.ModulaiseController::$PATH_MODULES.DIRECTORY_SEPARATOR.FOLDER_COMPILED.DIRECTORY_SEPARATOR."js".DIRECTORY_SEPARATOR."js_foot.concatinated.js";
		echo "Writing file            : ".$writeFile."\n";

		// capture output start
		$captureOutput = new ModulaiseCaptureOutput();
		$captureOutput->start();
		echo $buildTagComment;
		if (ModulaiseController::paneHasContent(PANE_JS_FOOT)){
				
			// render the pane
			ModulaiseController::printPane(PANE_JS_FOOT);
		}

		// capture output end
		$output = $captureOutput->end();
			
		// write the output to file
		ModulaiseUtils::writeFile($writeFile,$output);

		// Write each and every PANE_CSS
		
		// Prepare an empty array to hold the css
		$concatinated_css = Array();
		
		$debug = false;

		// get the pane names
		$paneNames = ModulaiseController::getPaneNames();
		foreach ($paneNames as $name){
			
			if ($debug===true){
				echo "paneName=".$name."\n";
			}
			
			$pos = strpos($name,PANE_CSS);
			if (!($pos === false)) {
				$nameArrays = explode("--",$name);
				
				// leading zero
				$nameArrays[1] = ($nameArrays[1]<10) ? "0".$nameArrays[1] : $nameArrays[1];

				// the file to write
				$writeFile = ModulaiseController::$DIR_DOCUMENT_ROOT.DIRECTORY_SEPARATOR.ModulaiseController::$PATH_MODULES.DIRECTORY_SEPARATOR.FOLDER_COMPILED.DIRECTORY_SEPARATOR."css".DIRECTORY_SEPARATOR.$nameArrays[1].DELIMITER.$nameArrays[2].".concatinated.css";
				echo "Writing file            : ".$writeFile."\n";
					
				// capture output start
				$captureOutput = new ModulaiseCaptureOutput();
				$captureOutput->start();
				echo $buildTagComment;

				if (ModulaiseController::paneHasContent($name)){

					// render the pane
					ModulaiseController::printPane($name);
				}
					
				// capture output end
				$output = $captureOutput->end();
					
				// write the output to file
				ModulaiseUtils::writeFile($writeFile,$output);
				
				// Remove comments and blank lines from output
				
				$output = preg_replace('!/\*.*?\*/!s', '', $output);
				//$output = preg_replace('/\n\s*\n/', '', $output);
				//$output = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "", $output);
				$output = trim($output);
				
				if ($debug===true){
					echo "output=\"".$output."\"\n";
			    }
			    
			    // if there is something to add
			    if ($output!=""){
					// also add the snippet to the concatinated array
					$concatinated_css[$nameArrays[1]."--".$nameArrays[2]][] = $output;
			    }
			
			}
		}
		
		// Write everything as one big pane
		
		// the file to write
		$writeFile = ModulaiseController::$DIR_DOCUMENT_ROOT.DIRECTORY_SEPARATOR.ModulaiseController::$PATH_MODULES.DIRECTORY_SEPARATOR.FOLDER_COMPILED.DIRECTORY_SEPARATOR."css".DIRECTORY_SEPARATOR."css.concatinated.css";
		echo "Writing file            : ".$writeFile."\n";

		// capture output start
		$captureOutput = new ModulaiseCaptureOutput();
		$captureOutput->start();
		echo $buildTagComment;
		
		// now use the concatinated_css array to concatinate everything into its right place
		foreach ($concatinated_css as $css_name => $contentsArray){
			
			$nameArrays = explode("--",$css_name);
			$mediaType = ModulaiseUtils::getMediaType($nameArrays[1]);
			if ($mediaType != "@media all"){
				echo "/*!NEWLINE*/".$mediaType." {";
			}else{
				echo "/*!NEWLINE*/";
			}
				
			foreach ($contentsArray as $key => $content){
				echo $content."\n";
			}
			
			if ($mediaType != "@media all"){
				echo "}";
			}
			
			echo "/*!NEWLINE*/";
		}
		
		// render the pane
		//print_r($concatinated_css);
		
		// capture output end
		$output = $captureOutput->end();
			
		// write the output to file
		ModulaiseUtils::writeFile($writeFile,$output);
		
		if ($debug){
			// write an extra output file
			ModulaiseUtils::writeFile($writeFile.".text",$output);
		}		
	}
}

?>