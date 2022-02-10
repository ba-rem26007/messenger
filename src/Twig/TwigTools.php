<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

class TwigTools extends AbstractExtension{

    public function getFilters()
    {
        return [
            new TwigFilter('image' , [$this, 'image_display'] , ["is_safe"=>['html']] ),
            new TwigFilter('badge' , [$this, 'badge'] , ["is_safe"=>['html']] ),
            new TwigFilter('button' , [$this, 'button'] , ["is_safe"=>['html']] ),
            new TwigFilter('summary' , [$this, 'summary'] , ["is_safe"=>['html']] ) ,
        ];
    }

    public function image_display( string $text){
        return('<img src="'.$text.'" />');
    }

    public function badge( string $text,$type="secondary"){
        return('<span class="badge bg-'.$type.'">'.$text."</span>");
    }

    public function summary( string $text, $len = 100){
        return(substr($text,0,$len));
    }

    public function button( string $text ,$type="secondary"){
        return('<button type="button" class="btn btn-'.$type.'">' . $text . '</button>');
    }
    
}