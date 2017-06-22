Installation
============

Pre-installation steps
----------------------
* Create a backup of your shop before proceeding to install.

Installation process
--------------------
The installation via the web setup wizard is the preferred way of installing the extension.
Please follow this guide_ to learm how this works.

.. _guide: http://docs.magento.com/marketplace/user_guide/quick-tour/install-extension.html 

In case you are not able or willing to use the web installation, you can install the extension using composer.

- Sign in to your server via ssh
- cd into you Magento instalation directory
- Install the extension via composer: `composer require amzn/amazon-payments-magento-2-plugin:^1.1.0`
- Enable the extension: `php bin/magento module:enable Amazon_Core Amazon_Login Amazon_Payment`
- Upgrade the Magento instalation: `php bin/magento setup:upgrade`
- Follow any advice the upgrade routine will give
- Deploy static content: `php bin/magento setup:static-content:deploy xx_XX yy_YY` where xx_XX, yy_YY, ... are the locales you are aiming to support
- Check permissions on directories and files and set them correctly if needed
