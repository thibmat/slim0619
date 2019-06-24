<?php
namespace App\Twig;

use Slim\Views\TwigExtension;

class StringFilter extends TwigExtension
{
    public function getFilters()
    {
        return [new \Twig\TwigFilter('resume', [$this, 'resume'])];
    }

    /**
     * @param string $str
     * @param int|null $length
     * @return string
     */
    public function resume(string $str,?int $length = 150)
    {
        $strToReturn = substr($str,0,$length);
        $lastSpacePosition = strpos($strToReturn,'.');
        if ($lastSpacePosition){
            $strToReturn = substr($strToReturn,0,$lastSpacePosition);
        }
        return $strToReturn.' ...';
    }

}