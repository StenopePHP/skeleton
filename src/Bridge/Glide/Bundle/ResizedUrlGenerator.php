<?php

declare(strict_types=1);

namespace App\Bridge\Glide\Bundle;

use League\Glide\Filesystem\FileNotFoundException;
use League\Glide\Server;
use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;

class ResizedUrlGenerator
{
    public function __construct(
        private readonly Server $server,
        private readonly GlideUrlBuilder $glideUrlBuilder,
        private readonly array $presetsNames = [],
        private readonly bool $preGenerate = false,
        private readonly LoggerInterface $logger = new NullLogger()
    ) {
    }

    public function withPreset(string $filename, string $preset, array $options = []): string
    {
        if (!\in_array($preset, $this->presetsNames, true)) {
            throw new \InvalidArgumentException(sprintf(
                'Preset "%s" does not exists. Known presets are %s',
                $preset,
                json_encode($this->presetsNames, JSON_THROW_ON_ERROR),
            ));
        }

        return $this->withOptions($filename, ['p' => $preset] + $options);
    }

    public function withOptions(string $filename, array $options): string
    {
        if ($this->isUrl($filename)) {
            // Don't attempt to process external files
            return $filename;
        }

        if (!$this->preGenerate) {
            // In case no pre-generation is asked, do only generate a link to the resize controller:
            return $this->glideUrlBuilder->buildUrl($filename, $options);
        }

        try {
            // Otherwise, pre-create the image in cache, and generate an URL to its public cache path:
            return $this->glideUrlBuilder->getPublicCachePath($this->server->makeImage($filename, $options));
        } catch (FileNotFoundException) {
            $this->logger->warning('Image at path "{path}" not found', [
                'path' => $filename,
                'glide_options' => $options,
            ]);

            return $filename;
        }
    }

    private function isUrl(string $path): bool
    {
        return \is_string(parse_url($path, PHP_URL_HOST));
    }
}
