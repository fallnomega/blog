<?php
/**
 * Created by PhpStorm.
 * User: Jason
 * Date: 2/23/2015
 * Time: 2:43 PM
 */

/**
 *gets the root path of the project
 * @return string
 */
function getRootPath()
{
    return realpath(__DIR__.'/..');
}

/**
 * gets the full path for the database file
 *
 * @return string
 */
function getDatabasePath()
{
    return getRootPath().'/data/data.sqlite';
}
/**
 * gets the dsn for the sqlite connection
 *
 * @return string
 */
function getDsn()
{
    return 'sqlite:'.getDatabasePath();
}

/**
 * gets the pdo object for the database access
 *
 * @return \pdo
 */
function getPDO()
{
    return new PDO(getDsn());
}
/**
 * escapes html so it is safe to output
 *
 * @param string $html
 * @param string
 */
function htmlEscape($html)
{
    return htmlspecialchars($html, ENT_HTML5,'UTF-8');
}