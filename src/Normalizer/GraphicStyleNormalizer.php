<?php

declare(strict_types=1);

namespace App\Normalizer;

use App\Entity\GraphicStyle;
use Symfony\Component\Serializer\Normalizer\ContextAwareNormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Vich\UploaderBundle\Storage\StorageInterface;

final class GraphicStyleNormalizer implements ContextAwareNormalizerInterface, NormalizerAwareInterface
{
    use NormalizerAwareTrait;

    private const ALREADY_CALLED = 'GRAPHIC_STYLE_NORMALIZER_ALREADY_CALLED';

    public function __construct(private StorageInterface $storage)
    {
    }

    /**
     * @param array<string, mixed> $context
     */
    public function supportsNormalization(mixed $data, ?string $format = null, array $context = []): bool
    {
        if (isset($context[self::ALREADY_CALLED])) {
            return false;
        }

        return $data instanceof GraphicStyle;
    }

    /**
     * @param GraphicStyle $graphicStyle
     * @param array<string, mixed> $context
     *
     * @return array<string, mixed>|bool|float|int|string|null
     */
    public function normalize(
        mixed $graphicStyle,
        ?string $format = null,
        array $context = []
    ): array|bool|float|int|string|null {
        $context[self::ALREADY_CALLED] = true;

        $graphicStyle->setUrl($this->storage->resolveUri($graphicStyle, 'file'));

        return $this->normalizer->normalize($graphicStyle, $format, $context);
    }
}
