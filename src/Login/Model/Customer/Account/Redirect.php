<?php
/**
 * Copyright 2016 Amazon.com, Inc. or its affiliates. All Rights Reserved.
 *
 * Licensed under the Apache License, Version 2.0 (the "License").
 * You may not use this file except in compliance with the License.
 * A copy of the License is located at
 *
 *  http://aws.amazon.com/apache2.0
 *
 * or in the "license" file accompanying this file. This file is distributed
 * on an "AS IS" BASIS, WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either
 * express or implied. See the License for the specific language governing
 * permissions and limitations under the License.
 */
namespace Amazon\Login\Model\Customer\Account;

use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Customer\Model\Account\Redirect as BaseRedirect;
use Magento\Customer\Model\Session as CustomerSession;
use Magento\Customer\Model\Url as CustomerUrl;
use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Url\DecoderInterface;
use Magento\Framework\UrlInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Stdlib\CookieManagerInterface;
use Magento\Framework\Session\SessionManagerInterface;
use Magento\Framework\Stdlib\Cookie\CookieMetadataFactory;

class Redirect extends BaseRedirect
{
    /**
     * @var CheckoutSession
     */
    protected $checkoutSession;

    /**
     * @var CustomerSession
     */
    protected $customerSession;

    protected $cookieManager;

    protected $cookieMetadataFactory;

    protected $sessionManager;

    /**
     * Redirect constructor.
     * @param RequestInterface $request
     * @param CustomerSession $customerSession
     * @param ScopeConfigInterface $scopeConfig
     * @param StoreManagerInterface $storeManager
     * @param UrlInterface $url
     * @param DecoderInterface $urlDecoder
     * @param CustomerUrl $customerUrl
     * @param ResultFactory $resultFactory
     * @param CheckoutSession $checkoutSession
     */
    public function __construct(
        CookieManagerInterface $cookieManager,
        RequestInterface $request,
        CustomerSession $customerSession,
        ScopeConfigInterface $scopeConfig,
        StoreManagerInterface $storeManager,
        UrlInterface $url,
        DecoderInterface $urlDecoder,
        CustomerUrl $customerUrl,
        ResultFactory $resultFactory,
        CheckoutSession $checkoutSession,
        SessionManagerInterface $sessionManager,
        CookieMetadataFactory $cookieMetadataFactory
    ) {
        parent::__construct(
            $request,
            $customerSession,
            $scopeConfig,
            $storeManager,
            $url,
            $urlDecoder,
            $customerUrl,
            $resultFactory
        );

        $this->customerSession = $customerSession;
        $this->checkoutSession = $checkoutSession;
        $this->cookieManager = $cookieManager;
        $this->cookieMetadataFactory = $cookieMetadataFactory;
        $this->sessionManager = $sessionManager;
    }

    public function getRedirect()
    {
        $cookieRedirect = $this->cookieManager->getCookie(
            \Amazon\Payment\Helper\Data::REDIRECT_COOKIE_NAME
        );
        $this->deleteCookie(\Amazon\Payment\Helper\Data::REDIRECT_COOKIE_NAME);

        $this->updateLastCustomerId('amazon_redirect');

        $result = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        $afterAmazonAuthUrl = $this->customerUrl->getAccountUrl();

        if ($cookieRedirect) {
            $afterAmazonAuthUrl = $cookieRedirect;
        } else if ($this->checkoutSession->getQuote() && (int)$this->checkoutSession->getQuote()->getItemsCount() > 0) {
            $afterAmazonAuthUrl = $this->url->getUrl('checkout');
        } else {
            $afterAmazonAuthUrl = $this->customerSession->getAfterAmazonAuthUrl();
        }

        $result->setUrl($afterAmazonAuthUrl);

        return $result;
    }

    public function deleteCookie($name)
    {
        $this->cookieManager->deleteCookie(
            $name,
            $this->cookieMetadataFactory
                ->createCookieMetadata()
                ->setPath($this->sessionManager->getCookiePath())
                ->setDomain($this->sessionManager->getCookieDomain())
        );
    }
}
