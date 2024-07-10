<?php

/**
 * get the base path
 *
 * @param string $path
 * @return String 
 */
function basePath($path = '')
{
    return __DIR__ . '/' . $path;
}

/**
 * loads a view with a name
 *
 * @param string $name
 * @return void
 */
function loadView($name = '')
{
    $viewPath = basePath("views/{$name}.view.php");

    if (file_exists($viewPath)) {
        require $viewPath;
    } else {
        echo "{$name} view does not exist";
    }
}

/**
 * loads a partial from with a name
 *
 * @param string $name
 * @return void
 */
function loadPartial($name = '')
{
    $partialPath = basePath("views/partials/{$name}.php");

    if (file_exists($partialPath)) {
        require $partialPath;
    } else {
        echo "{$name} partial does not exist";
    }
}

/**
 * Debugger utility function
 *
 * @param [type] $value
 * @return void
 */
function inspect($value)
{
    echo '<pre>';
    var_dump($value);
    echo '</pre>';
}

/**
 * Debugger utility function
 *
 * @param [type] $value
 * @return void
 */
function inspectAndDie($value)
{
    echo '<pre>';
    die(var_dump($value));
    echo '</pre>';
}
