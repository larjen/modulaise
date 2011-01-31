<?php

require_once ('modulaise-utils.php');

/**
 * Reads ant properties from localhost
 *
 * @author Lars Jensen, lars.jensen@exenova.dk
 *
 */
Class AntPropertiesWriter {

	/**
	 * Prints ant properties
	 */
	public static function getAntProperties(){

		// read all module templates
		$allModuleTemplates = ModulaiseUtils::getDirectoryAsArray(ModulaiseController::$DIR_DOCUMENT_ROOT.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR.PATH_BOILERPLATES_MODULES);
		echo "# List all moduletemplates from boilerplates/modules folder\n";
		$firstLoop = true;

		// loop all modules files
		foreach ($allModuleTemplates as $templateName){
			if ($firstLoop){
				echo "ALL_MODULE_TEMPLATES_DEFAULT=".$templateName."\n";
				echo "ALL_MODULE_TEMPLATES=";
				$firstLoop = false;
			}else{
				echo ",";
			}
			echo $templateName;
		}

		// read all page templates
		$allPageTemplates = ModulaiseUtils::getDirectoryAsArray(ModulaiseController::$DIR_DOCUMENT_ROOT.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR.PATH_BOILERPLATES_PAGES);
		echo "\n\n# List all pagetemplates from boilerplates/pages folder\n";
		$firstLoop = true;

		// loop all modules files
		foreach ($allPageTemplates as $templateName){
			if ($firstLoop){
				echo "ALL_PAGE_TEMPLATES_DEFAULT=".$templateName."\n";
				echo "ALL_PAGE_TEMPLATES=";
				$firstLoop = false;
			}else{
				echo ",";
			}
			echo $templateName;
		}

		// read all project templates
		$allBoilerPlates = ModulaiseUtils::getDirectoryAsArray(ModulaiseController::$DIR_DOCUMENT_ROOT.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR.PATH_BOILERPLATES_PROJECTS);
		echo "\n\n# List all boilerplates from boilerplates/projects folder\n";
		$firstLoop = true;

		// loop all modules files
		foreach ($allBoilerPlates as $boilerPlate){
			if ($firstLoop){
				echo "ALL_BOILERPLATES_DEFAULT=".$boilerPlate."\n";
				echo "ALL_BOILERPLATES=";
				$firstLoop = false;
			}else{
				echo ",";
			}
			echo $boilerPlate;
		}

		// read all build packages
		$allBuildPackages = ModulaiseUtils::getDirectoryAsArray(ModulaiseController::$DIR_DOCUMENT_ROOT.DIRECTORY_SEPARATOR.PATH_BUILDS);

		// flip, we want latest builds first
		$allBuildPackages = array_reverse($allBuildPackages, true);
		echo "\n\n# List all buildPackages from build folder\n";
		$firstLoop = true;
		$i = 0;

		// loop all modules files
		foreach ($allBuildPackages as $buildTag){
			$i++;
			if ($i<20 && ModulaiseUtils::EndsWith($buildTag, ".zip")){
				if ($firstLoop){
					echo "ALL_BUILDPACKAGES_DEFAULT=".substr($buildTag, 0, -4)."\n";
					echo "ALL_BUILDPACKAGES=";
					$firstLoop = false;
				}else{
					echo ",";
				}
				echo substr($buildTag, 0, -4);
			}
		}

		// read all deploy destinations
		$allDeployDestinations = ModulaiseUtils::getDirectoryAsArray(ModulaiseController::$DIR_DOCUMENT_ROOT.DIRECTORY_SEPARATOR."..".DIRECTORY_SEPARATOR.PATH_TO_DEPLOY_TARGETS,ONLY_DIRECTORIES);
		echo "\n\n# List all deploy destinations from config-project folder\n";
		$firstLoop = true;

		// loop all modules files
		foreach ($allDeployDestinations as $destination){
			if ($firstLoop){
				echo "ALL_DEPLOY_DESTINATIONS_DEFAULT=".$destination."\n";
				echo "ALL_DEPLOY_DESTINATIONS=";
				$firstLoop = false;
			}else{
				echo ",";
			}
			echo $destination;
		}
	}
}

?>