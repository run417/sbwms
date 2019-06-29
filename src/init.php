<?php
define("WWW_ROOT", "/sbwms/public");
define("PUBLIC_PATH", getProjectPath() . '/public');
define("COMMON_VIEWS", getProjectPath() . '/resources/views/common/');

/**
 * Get the project path.
 * 
 * The project directory must be name 'sbwms'
 * NOTE: The full path must contain forward slashes /
 */
function getProjectPath() : string {
    $currentPath = __DIR__;
    $directoryArray = explode("/", $currentPath);
    $position = array_search("sbwms", $directoryArray);
    if (!$position) exit("Please rename project folder to sbwms");
    $newarray = array_slice($directoryArray, 0, $position + 1);
    $projectPath = implode("/", $newarray);
    return $projectPath;
}

function url_for($script_path)
{
    // adds the leading '/' if not present
    if ($script_path[0] != '/')
    {
        $script_path = "/" . $script_path;
    }
    return WWW_ROOT . $script_path;
}
?>
