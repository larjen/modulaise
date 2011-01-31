<?php

define("ALL_FILES",0);
define("ONLY_FILES",1);
define("ONLY_DIRECTORIES",2);
define("SHOW_DEVELOPMENT",0);
define("SHOW_EXPORT",1);
define("BUILD_EXPORT",2);

/**
 * Utilities class
 *
 * @author Lars Jensen, lars.jensen@exenova.dk
 *
 */
Class ModulaiseUtils {
	
	/**
	 * Returns a mediatype declaration for CSS import statements
	 * based on the filename of the CSS file.
	 */
	public static function getImportMediaType($file = NULL){
		if ($file === NULL || $file == "all.css"){
			return " ";
		}
		$mediaType = str_replace("..", ": ", $file);		
		return " media=\"".substr($mediaType, 0, -4)."\" ";
	}

	/**
	 * Gets a CSS import statement
	 */
	public static function getCssImportStatement($cssFile, $fileName = NULL){
		
		return "<link rel=\"stylesheet\"".self::getImportMediaType($fileName)."href=\"".ModulaiseController::$staticContentPath.$cssFile."?v=".ModulaiseController::$buildTag."\" />\n";
	}

	/**
	 * Gets a JavaScript import statement
	 */
	public static function getJsImportStatement($jsFile){
		return "<script src=\"".ModulaiseController::$staticContentPath.$jsFile."?v=".ModulaiseController::$buildTag."\"></script>\n";
	}

	/**
	 * Prints comments
	 */
	public static function printComment($comment){
		echo "<!--[if !IE]>".$comment."<![endif]-->\n";
	}

	/**
	 * Checks if a given string ends with another string
	 */
	public static function EndsWith($FullStr, $EndStr)
	{
		$FullStr = strtolower($FullStr);
		$EndStr = strtolower($EndStr);

		// Get the length of the end string
		$StrLen = strlen($EndStr);

		// Look at the end of FullStr for the substring the size of EndStr
		$FullStrEnd = substr($FullStr, strlen($FullStr) - $StrLen);

		// If it matches, it does end with EndStr
		return $FullStrEnd == $EndStr;
	}

	/**
	 * Get's a directory as an array
	 */
	public static function getDirectoryAsArray($directory,$return=ALL_FILES){

		$debug = false;

		if (is_dir($directory)){

			// Initialize array
			$dirArray = Array();

			// open this directory
			$handle = opendir($directory) or die("\n\nERROR! Can't open directory ".$directory."\n\n");

			// get each entry
			while($resource = readdir($handle)) {

				// discard hidden files and files starting with DELIMITER
				if (substr($resource, 0, 1) != "." && substr($resource, 0, 1) != DELIMITER){

					// Decide what files to include
					switch ($return) {
						case ALL_FILES:
							$dirArray[] = $resource;
							break;
						case ONLY_FILES:
							if (is_file($directory.DIRECTORY_SEPARATOR.$resource)){
								$dirArray[] = $resource;
								if ($debug){
									ModulaiseController::printComment("\n\n".get_class().": ONLY_FILES is_file(".$directory.DIRECTORY_SEPARATOR.$resource.") =  ".is_file($directory.DIRECTORY_SEPARATOR.$resource)."\n\n");
								}
							}
							break;
						case ONLY_DIRECTORIES:
							if (is_dir($directory.DIRECTORY_SEPARATOR.$resource)){
								$dirArray[] = $resource;
								if ($debug){
									ModulaiseController::printComment("\n\n".get_class().": ONLY_DIRECTORIES is_dir(".$directory.DIRECTORY_SEPARATOR.$resource.") =  ".is_dir($directory.DIRECTORY_SEPARATOR.$resource)."\n\n");
								}
							}
							break;
					}
				}
			}

			// close directory
			closedir($handle);

			// sort 'em
			sort($dirArray);
			return $dirArray;
		}
		else
		{
			return Array();
		}
	}

	/**
	 * Writes a file
	 */
	public static function writeFile($fileName,$content){

		// Create the directory in case it does not exist
		$path = dirname($fileName);
		if (!is_dir($path)){
			if (!mkdir($path, 0777, true)) {
				die("\n\nERROR! Can't create folder ".$path."\n\n");
			}
		}
		$fh = fopen($fileName, 'w') or die("\n\nERROR! Can't open file ".$fileName."\n\n");
		fwrite($fh, $content);
		fclose($fh);
	}

	/**
	 * reads the configuration file and parses it into definitions
	 */
	public static function readConfigurationFile($file){
		$comment = "#";
		$fp = fopen($file, "r") or die("\n\nERROR! Can't open file ".$file."\n\n");
		while (!feof($fp)) {
			$line = trim(fgets($fp));
			if ($line && !preg_match("/^".$comment."/", $line)) {
				$pieces = explode("=", $line);
				$option = trim($pieces[0]);
				$value = trim($pieces[1]);
				if(!defined($option)){ define($option,$value);}
			}
		}
		fclose($fp);
	}

	/**
	 * extract Contents between start and end blocks in css file, or everything if they are omitted
	 */
	public static function extractCss($cssSnippet){

		$pos = strpos($cssSnippet,"@media");

		if (!($pos === false)) {
			$start = "{";
			$end = "}";
			$pos = stripos($cssSnippet, $start);
			if ($pos == false){
				return $cssSnippet;
			}
			$str = substr($cssSnippet, $pos);
			$str_two = substr($str, strlen($start));
			$second_pos = strripos($str_two, "}");
			$str_three = substr($str_two, 0, $second_pos);
			$unit = trim($str_three); // remove whitespaces
			return "\n".$unit."\n";
		}

		return $cssSnippet;
	}


	/**
	 * returns mediaType from filename
	 */
	public static function getMediaType($cssFileName){
		$mediaType = str_replace("..", ": ", $cssFileName);
		return "@media ".substr($mediaType, 0, -4);
	}
}

?>