<?php

namespace App\Services;

use ImageKit\ImageKit;

class ImageKitService
{
    protected ?ImageKit $client = null;

    public function __construct(
        protected ?string $publicKey = null,
        protected ?string $privateKey = null,
        protected ?string $endpointUrl = null,
    ) {
        $this->publicKey = $publicKey ?? config('services.imagekit.public_key');
        $this->privateKey = $privateKey ?? config('services.imagekit.private_key');
        $this->endpointUrl = $endpointUrl ?? config('services.imagekit.endpoint_url');
    }

    public function getClient(): ImageKit
    {
        if (empty($this->publicKey) || empty($this->privateKey) || empty($this->endpointUrl)) {
            throw new \InvalidArgumentException(
                'ImageKit credentials are missing. Set IMAGEKIT_PUBLIC_KEY, IMAGEKIT_PRIVATE_KEY and IMAGEKIT_ENDPOINT_URL.'
            );
        }

        return $this->client ??= new ImageKit(
            $this->publicKey,
            $this->privateKey,
            $this->endpointUrl
        );
    }

    /**
     * Generate authentication parameters for client-side uploads
     */
    public function generateAuthParameters(): array
    {
        $authParams = $this->getClient()->getAuthenticationParameters();

        return [
            'token' => $authParams->token,
            'expire' => $authParams->expire,
            'signature' => $authParams->signature,
            'publicKey' => $this->publicKey,
            'urlEndpoint' => $this->endpointUrl,
        ];
    }

    /**
     * Normalize metadata from client upload response
     */
    public function normalizeMetadata(array $clientResponse): array
    {
        return [
            'file_id' => $clientResponse['fileId'] ?? null,
            'url' => $clientResponse['url'] ?? null,
            'file_path' => $clientResponse['filePath'] ?? null,
            'thumbnail_url' => $clientResponse['thumbnailUrl'] ?? null,
        ];
    }

    /**
     * Delete a file by fileId
     */
    public function deleteFile(string $fileId): void
    {
        $this->getClient()->deleteFile($fileId);
    }

    /**
     * Move a file to a new folder
     */
    public function moveFile(string $sourceFilePath, string $destinationPath): object
    {
        return $this->getClient()->move([
            'sourceFilePath' => $sourceFilePath,
            'destinationPath' => $destinationPath,
        ]);
    }
}
