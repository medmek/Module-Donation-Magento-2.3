# Magento 2 Module Test Donation


 - [Main Functionalities](#markdown-header-main-functionalities)
 - [Installation](#markdown-header-installation)
 - [Configuration](#markdown-header-configuration)
 - [Specifications](#markdown-header-specifications)
 - [Attributes](#markdown-header-attributes)


## Main Functionalities
Magento Module to add the donation features: 
- Add in BackOffice the donation configuration (enable module, title, description, image, amount)
- Add in Checkout the donation step (Form with configured data to select donation) 
- FrontOffice checkout cart donation total line

## Installation
\* = in production please use the `--keep-generated` option

### Type 1: Zip file

 - Unzip the directory Interview in `app/code/`
 - Enable the module by running `php bin/magento module:enable Interview_Donation`
 - Apply database updates by running `php bin/magento setup:upgrade`\*
 - Flush the cache by running `php bin/magento cache:flush`

### Type 2: Composer

 - No available
