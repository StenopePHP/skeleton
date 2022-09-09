<?php

declare(strict_types=1);

namespace App\Model;

use Stenope\Bundle\Attribute\SuggestedDebugQuery;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[SuggestedDebugQuery('Ative', filters: '_.active', orders: 'desc:since')]
class Author
{
    public function __construct(
        public string $slug,
        public string $name,
        public ?string $avatar = null,
        public bool $active = true,
        #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
        public ?\DateTimeInterface $since = null,
        public ?\DateTimeInterface $lastModified = null,
    ) {
    }
}
