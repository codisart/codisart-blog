<?php

namespace Codisart;

/**
 *	@property string $_table
*/
abstract class Reacher
{
    protected function fetchAll($query, $className)
    {
        $objects = new \Codisart\Collection;

        while ($query && $data = $query->fetch()) {
            $objects[] = new $className($data);
        }
        return $objects;
    }
}
