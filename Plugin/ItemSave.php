<?php

namespace Absoft\WallCatalog\Plugin;


class ItemSave
{


    public function beforeSave(
        \Magento\Quote\Api\CartItemRepositoryInterface $cartItemRepository,
        \Magento\Quote\Api\Data\CartItemInterface $cartItem)
    {

        $extensionAttributes = $cartItem->getExtensionAttributes();
        if ($extensionAttributes === null) {
            $extensionAttributes = $this->getCartItemExtensionDependency();
        }
        $imagePreview = $extensionAttributes->getImagePreview();

        $extensionAttributes->setImagePreview($imagePreview);

        $cartItem->setExtensionAttributes($extensionAttributes);

        return [$cartItem];
    }

    public function afterSave(
        \Magento\Quote\Api\CartItemRepositoryInterface $cartItemRepository,
        \Magento\Quote\Api\Data\CartItemInterface $cartItem)
    {

        return $cartItem;

    }
    private function getCartItemExtensionDependency()
    {
        $CartItemExtension = \Magento\Framework\App\ObjectManager::getInstance()->get(
            '\Magento\Quote\Api\Data\CartItemExtension'
        );
        return $CartItemExtension;
    }


}