# Magento 2 Customer Custom Attribute 


## 1. How to install

## Step 1 Install via composer (recommend)
	composer require technogex/customer-attribute
Manually (not recommended)
-	Download the extension
-	Unzip the file
-	Create a folder {Magento 2 root}/app/code/Technogex/CustomerAttribute
-	Copy the content from the unzip folder
## Step 2 : Enable Customer Attribute Extension ("cd" to {Magento root} folder)
	php -f bin/magento module:enable --clear-static-content Technogex_CustomerAttribute
	php -f bin/magento setup:upgrade

## Step 3 - How to Configure Customer Attribute
Log into your Magento 2 Admin, then navigate to 
	Stores -> Technogex -> Customer Attribute
