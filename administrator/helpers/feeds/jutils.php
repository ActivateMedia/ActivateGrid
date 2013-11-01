<?php

function checkCategoryExists($alias = "")
{
    require_once "jinclude.php";
    global $db;
    $alias = htmlspecialchars(addslashes($alias));
    $query = "SELECT id FROM #__categories WHERE alias = '".$alias."' AND published=1;";
    $db->setQuery($query);
    $db->query();
    $results = $db->loadObjectList();   
    if(sizeof($results) > 0) return $results[0]->id; // exists
    else return false; // not exists
}

function createJoomlaCategory($component, $title, $alias)
{
    require_once "jinclude.php";
    global $db;
    $component = htmlspecialchars(addslashes($component));
    $title = htmlspecialchars(addslashes($title));
    $alias = htmlspecialchars(addslashes($alias));
    $query = "INSERT INTO jos_categories (parent_id, extension, title, alias, path, published, level, access, created_time, language)
              SELECT * FROM (SELECT 1 as parent_id, '".$component."', '".$title."' as t, '".$alias."' as a, '".$alias."' as p, 1 as published, 1 as level, 1 as access, NOW(), '*') AS tmp
              WHERE NOT EXISTS(     
                  SELECT id   
                  FROM #__categories 
                  WHERE alias = '".$alias."' AND published=1
              )";
    $db->setQuery($query);
    $db->query();

    return $db->insert_id();
}

function createJoomlaArticle($data)
{
    require_once "jinclude.php";
    global $db;
    if(!isset($data)) return false;
    
    $table = JTable::getInstance('Content', 'JTable', array());   

    // Bind data
    if (!$table->bind($data))
    {
        //$this->setError($table->getError());
        return false;
    }

    // Check the data.
    if (!$table->check())
    {
        //$this->setError($table->getError());
        return false;
    }

    // Store the data.
    if (!$table->store())
    {
        //$this->setError($table->getError());
        return false;
    }
}

/*
 * This funcion checks if the feed has been already imported - it means we have an article
 * with the ID of the feed in com_content.xreference
 */
function checkArticleAlreadyImported($xreference)
{
    if($xreference==0 || $xreference=="") die("Fatal error: xreference missing in jutils.php::checkActivateArticleExists()");
    require_once "jinclude.php";
    global $db;
    $xreference = htmlspecialchars(addslashes($xreference));
    $query = "SELECT xreference FROM #__content WHERE xreference = '".$xreference."' AND state=1;";
    $db->setQuery($query);
    $db->query();
    $results = $db->loadObjectList();   
    if(sizeof($results) > 0) return $results[0]->id; // exists
    else return false; // not exists    
}
?>
