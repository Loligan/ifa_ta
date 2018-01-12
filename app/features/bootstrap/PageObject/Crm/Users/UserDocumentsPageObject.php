<?php

namespace PageObject\Crm\Users;

use PageObject\PageObject;

class UserDocumentsPageObject extends PageObject
{
    const PATH_REGEX = '/(\/documents$)/';
    const TABLE_LINE = './/table//tbody//tr';
    const TABLE_LINE_BY_TYPE = './/table//tbody//tr//td[2][normalize-space(text())="VALUE"]';

    public static function checkOnThePage()
    {
        self::checkPathByRegex(self::PATH_REGEX);
    }

    public static function checkNumberTableLine($checkNumberLine)
    {
        $elements = self::findElements(self::TABLE_LINE);
        if (count($elements) != (int)$checkNumberLine) {
            throw new \Exception("Number lines in table not be equals number line for check. Count in table: " . count($elements));
        }
    }

    public static function checkNumberTableLineByType($checkNumberLine, $type)
    {
        $xpath = str_replace('VALUE', $type, self::TABLE_LINE_BY_TYPE);
        $elements = self::findElements($xpath);
        if (count($elements) != $checkNumberLine) {
            throw new \Exception("Number lines in table not be equals number line for check");
        }
    }

}