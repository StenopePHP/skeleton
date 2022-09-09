<?php

declare(strict_types=1);

namespace App\Model;

class Page
{
    use MetaTrait;

    public function __construct(
        public string $slug,
        public string $title,
        public string $content,
    ) {
    }
}
