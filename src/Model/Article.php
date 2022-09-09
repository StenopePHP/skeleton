<?php

declare(strict_types=1);

namespace App\Model;

use Stenope\Bundle\Attribute\SuggestedDebugQuery;
use Stenope\Bundle\Processor\TableOfContentProcessor;
use Stenope\Bundle\TableOfContent\TableOfContent;
use Symfony\Component\Serializer\Annotation\Context;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;

#[SuggestedDebugQuery('Scheduled', filters: 'not _.isPublished()', orders: 'desc:publishedAt')]
#[SuggestedDebugQuery('By author', filters: "'tom32i' in keys(_.authors)", orders: 'desc:publishedAt')]
#[SuggestedDebugQuery('By tag', filters: "'stenope' in _.tags", orders: 'desc:publishedAt')]
#[SuggestedDebugQuery('Matching slug', filters: "_.slug matches '/symfony/'", orders: 'desc:publishedAt')]
class Article
{
    use MetaTrait;

    public function __construct(
        public string $slug,
        public string $title,
        public ?string $description,
        public string $content,
        public string $image,
        public ?string $nextArticle,
        public array $authors,
        public array $tags,
        #[Context([DateTimeNormalizer::FORMAT_KEY => 'Y-m-d'])]
        public \DateTimeInterface $publishedAt,
        public ?\DateTimeInterface $lastModified = null,
        /** Automatically populated by {@link TableOfContentProcessor} */
        public ?TableOfContent $tableOfContent = null,
    ) {
    }

    public function getLastModifiedOrCreated(): \DateTimeInterface
    {
        return $this->lastModified ?? $this->publishedAt;
    }

    public function isPublished(): bool
    {
        return new \DateTimeImmutable() >= $this->publishedAt;
    }
}
