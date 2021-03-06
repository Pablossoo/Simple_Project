<?php

declare(strict_types=1);

namespace App\Messenger\CommandHandler;

use App\Messenger\Command\RemoveProductFromCatalog;
use App\Service\Catalog\ProductService;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;

final class RemoveProductFromCatalogHandler implements MessageHandlerInterface
{
    public function __construct(private ProductService $service)
    {
    }

    public function __invoke(RemoveProductFromCatalog $command): void
    {
        $this->service->remove($command->productId);
    }
}
