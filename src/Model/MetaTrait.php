<?php

declare(strict_types=1);

namespace App\Model;

/**
 * Trait for SEO & social networks metadata.
 */
trait MetaTrait
{
    public ?string $metaTitle = null;
    public ?string $metaDescription = null;

    // https://developers.facebook.com/docs/sharing/webmasters?locale=en
    public ?string $ogTitle = null;
    public ?string $ogDescription = null;
    public ?string $ogImage = null;

    // https://developer.twitter.com/en/docs/twitter-for-websites/cards/guides/getting-started
    public ?string $twitterCardType = null;
    public ?string $twitterTitle = null;
    public ?string $twitterDescription = null;
    public ?string $twitterImage = null;
}
