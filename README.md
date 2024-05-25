# Debuglabs_Breadcrumbs

This module fixes the issue with breadcrumbs on the product page not showing categories if the category is set to "Show in Menu = No". This problem was originally discussed [here](https://github.com/magento/magento2/issues/30098).

The solution was found on [Magento Stack Exchange](https://magento.stackexchange.com/questions/225370/magento-2-2-4-breadcrumbs-do-not-show-on-product-pages-when-default-navigation/233023#233023), provided by [Nuwaus](https://magento.stackexchange.com/users/39025/nuwaus). 

## Description

This module wraps the solution into a Magento 2 module for easier access and deployment. It extends the default Magento breadcrumbs functionality to ensure categories are displayed in the breadcrumbs even when they are not shown in the menu.

## Compatibility

This module is compatible with Magento versions 2.2.4 to 2.4.6.

## Installation

1. **Clone the repository or download the module:**

    ```bash
    git clone https://github.com/your-repository-url/Debuglabs_Breadcrumbs.git
    ```

2. **Copy the module files to your Magento 2 installation:**

    ```bash
    cp -R Debuglabs_Breadcrumbs app/code/Debuglabs/Breadcrumbs
    ```

3. **Enable the module:**

    ```bash
    php bin/magento module:enable Debuglabs_Breadcrumbs
    php bin/magento setup:upgrade
    php bin/magento cache:clean
    ```

4. **Deploy static content:**

    ```bash
    php bin/magento setup:static-content:deploy
    ```

## Usage

After installation, the module will automatically fix the breadcrumbs issue on the product pages. No further configuration is required.

## Support

For any issues or questions, please contact the creator Sebastijan Placento at [info@debug-labs.hr](mailto:info@debug-labs.hr).

## License

This project is licensed under the MIT License. See the [LICENSE](LICENSE) file for details.

