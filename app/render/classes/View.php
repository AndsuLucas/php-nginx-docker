<?php 
namespace Render;

class View extends ViewInterface
{
    public function __construct(string $context = "")
    {
        if (!empty($context)) {
            $this->context = $context;
        }
    }
}