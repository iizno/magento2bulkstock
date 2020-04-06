<?php
namespace Smartoys\BulkProductUpdate\Model;

use Smartoys\BulkProductUpdate\Api\ProductUpdateManagementInterface as ProductApiInterface;

class ProductUpdateManagement implements ProductApiInterface {

    /**
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     */
    public function __construct(
        \Magento\Catalog\Api\ProductRepositoryInterface $productRepository,
        \Psr\Log\LoggerInterface $logger
    ) {
        $this->productRepository = $productRepository;
        $this->logger = $logger;
    }

    /**
     * Updates the specified product from the request payload.
     *
     * @api
     * @param mixed $products
     * @return boolean
     */
    public function updateProduct($products) {
        if (!empty($products)) {
            $error = false;
            foreach ($products as $product) {
                try {
                    if (isset($product['Id'])) {
                        $sku = $product['Id'];
                        $productObject = $this->productRepository->get($sku);
                        if (isset($product['price'])) {
                            $price = $product['price'];
                            $productObject->setPrice($price);
                        }
                        if (isset($product['QtDispo'])) {
                            $qty = $product['QtDispo'];
                            if ($qty > 0) {
                                $productObject->setStockData(
                                    [
                                        'is_in_stock' => 1,
                                        'qty' => $qty
                                    ]
                                );
                            } else {
                                $productObject->setStockData(
                                    [
                                        'is_in_stock' => 0,
                                        'qty' => 0
                                    ]);
                            };
                        };
                        try {
                            $this->productRepository->save($productObject);
                        } catch (\Exception $e) {
                            throw new StateException(__('Cannot save product.'));
                        }
                    }
                } catch (\Magento\Framework\Exception\LocalizedException $e) {
                    $messages[] = $product['Id'].' =>'.$e->getMessage();
                    $error = true;
                }
            }
            if ($error) {
                $this->writeLog(implode(" || ",$messages));
                return false;
            }
        }
        return true;
    }

    /* log for an API */
    public function writeLog($log)
    {
        $this->logger->info($log);
    }
}
