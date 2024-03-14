-- phpMyAdmin SQL Dump
-- version 5.2.0
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Sep 18, 2023 at 01:54 PM
-- Server version: 10.4.27-MariaDB
-- PHP Version: 8.1.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `test`
--

-- --------------------------------------------------------

--
-- Table structure for table `addresses`
--

CREATE TABLE `addresses` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `name` varchar(64) DEFAULT NULL,
  `type` varchar(32) DEFAULT NULL,
  `mobile` varchar(24) DEFAULT NULL,
  `alternate_mobile` varchar(24) DEFAULT NULL,
  `address` mediumtext DEFAULT NULL,
  `landmark` varchar(128) DEFAULT NULL,
  `area_id` int(11) DEFAULT NULL,
  `city_id` int(11) DEFAULT NULL,
  `city` varchar(256) DEFAULT NULL,
  `area` varchar(256) DEFAULT NULL,
  `pincode` varchar(512) DEFAULT NULL,
  `system_pincode` tinyint(4) NOT NULL DEFAULT 1,
  `country_code` int(11) DEFAULT NULL,
  `state` varchar(64) DEFAULT NULL,
  `country` varchar(64) DEFAULT NULL,
  `latitude` varchar(64) DEFAULT NULL,
  `longitude` varchar(64) DEFAULT NULL,
  `is_default` int(11) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `areas`
--

CREATE TABLE `areas` (
  `id` int(11) NOT NULL,
  `name` mediumtext NOT NULL,
  `city_id` int(11) NOT NULL,
  `zipcode_id` int(11) DEFAULT 0,
  `minimum_free_delivery_order_amount` double NOT NULL DEFAULT 100,
  `delivery_charges` double DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attributes`
--

CREATE TABLE `attributes` (
  `id` int(11) NOT NULL,
  `attribute_set_id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `type` varchar(64) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `status` tinyint(4) NOT NULL DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attribute_set`
--

CREATE TABLE `attribute_set` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `status` tinyint(4) DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `attribute_values`
--

CREATE TABLE `attribute_values` (
  `id` int(11) NOT NULL,
  `attribute_id` int(11) NOT NULL,
  `filterable` int(11) DEFAULT 0,
  `value` varchar(1024) NOT NULL,
  `swatche_type` varchar(512) DEFAULT NULL,
  `swatche_value` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `brands`
--

CREATE TABLE `brands` (
  `id` int(11) NOT NULL,
  `name` varchar(256) DEFAULT NULL,
  `slug` varchar(256) DEFAULT NULL,
  `image` text NOT NULL,
  `status` tinyint(4) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_variant_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `is_saved_for_later` int(11) NOT NULL DEFAULT 0,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `categories`
--

CREATE TABLE `categories` (
  `id` int(11) NOT NULL,
  `name` varchar(256) NOT NULL,
  `parent_id` int(11) DEFAULT NULL,
  `slug` varchar(256) NOT NULL,
  `image` text NOT NULL,
  `banner` text DEFAULT NULL,
  `row_order` int(11) DEFAULT 0,
  `status` tinyint(4) DEFAULT NULL,
  `clicks` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `categories`
--

INSERT INTO `categories` (`id`, `name`, `parent_id`, `slug`, `image`, `banner`, `row_order`, `status`, `clicks`) VALUES
(1, 'Uncategorized', 0, '', 'uploads/media/2020/', 'uploads/media/2020/', 0, NULL, 0);

-- --------------------------------------------------------

--
-- Table structure for table `cities`
--

CREATE TABLE `cities` (
  `id` int(11) NOT NULL,
  `name` mediumtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `client_api_keys`
--

CREATE TABLE `client_api_keys` (
  `id` int(11) NOT NULL,
  `name` mediumtext DEFAULT NULL,
  `secret` mediumtext NOT NULL,
  `status` int(1) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `client_api_keys`
--

INSERT INTO `client_api_keys` (`id`, `name`, `secret`, `status`) VALUES
(1, 'eShop App', '65c9cd19cd138f19ddf2f6320c7a802ee936c548', 1);

-- --------------------------------------------------------

--
-- Table structure for table `countries`
--

CREATE TABLE `countries` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(100) NOT NULL,
  `iso3` char(3) DEFAULT NULL,
  `numeric_code` char(3) DEFAULT NULL,
  `iso2` char(2) DEFAULT NULL,
  `phonecode` varchar(255) DEFAULT NULL,
  `capital` varchar(255) DEFAULT NULL,
  `currency` varchar(255) DEFAULT NULL,
  `currency_name` varchar(255) DEFAULT NULL,
  `currency_symbol` varchar(255) DEFAULT NULL,
  `tld` varchar(255) DEFAULT NULL,
  `native` varchar(255) DEFAULT NULL,
  `region` varchar(255) DEFAULT NULL,
  `subregion` varchar(255) DEFAULT NULL,
  `timezones` text DEFAULT NULL,
  `translations` text DEFAULT NULL,
  `latitude` decimal(10,8) DEFAULT NULL,
  `longitude` decimal(11,8) DEFAULT NULL,
  `emoji` varchar(191) DEFAULT NULL,
  `emojiU` varchar(191) DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `flag` tinyint(1) NOT NULL DEFAULT 1,
  `wikiDataId` varchar(255) DEFAULT NULL COMMENT 'Rapid API GeoDB Cities'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `custom_notifications`
--

CREATE TABLE `custom_notifications` (
  `id` int(11) NOT NULL,
  `title` varchar(128) DEFAULT NULL,
  `message` varchar(512) DEFAULT NULL,
  `type` varchar(64) DEFAULT NULL,
  `date_sent` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `delivery_boy_notifications`
--

CREATE TABLE `delivery_boy_notifications` (
  `id` int(11) NOT NULL,
  `delivery_boy_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `title` mediumtext NOT NULL,
  `message` mediumtext NOT NULL,
  `type` varchar(56) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `digital_orders_mails`
--

CREATE TABLE `digital_orders_mails` (
  `id` int(11) NOT NULL,
  `order_id` int(11) DEFAULT NULL,
  `order_item_id` int(11) DEFAULT NULL,
  `subject` varchar(256) DEFAULT NULL,
  `message` varchar(256) DEFAULT NULL,
  `file_url` varchar(512) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `faqs`
--

CREATE TABLE `faqs` (
  `id` int(11) NOT NULL,
  `question` mediumtext DEFAULT NULL,
  `answer` mediumtext DEFAULT NULL,
  `status` char(1) DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `favorites`
--

CREATE TABLE `favorites` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `flash_sale`
--

CREATE TABLE `flash_sale` (
  `id` int(11) NOT NULL,
  `title` varchar(512) DEFAULT NULL,
  `slug` varchar(512) DEFAULT NULL,
  `short_description` varchar(512) DEFAULT NULL,
  `discount` int(11) DEFAULT NULL,
  `product_ids` varchar(1024) DEFAULT NULL,
  `image` varchar(2048) DEFAULT NULL,
  `start_date` datetime DEFAULT NULL,
  `end_date` datetime DEFAULT NULL,
  `status` tinyint(4) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `fund_transfers`
--

CREATE TABLE `fund_transfers` (
  `id` int(11) NOT NULL,
  `delivery_boy_id` int(11) NOT NULL,
  `opening_balance` double NOT NULL,
  `closing_balance` double NOT NULL,
  `amount` double NOT NULL,
  `status` varchar(28) DEFAULT NULL,
  `message` varchar(512) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `groups`
--

CREATE TABLE `groups` (
  `id` mediumint(8) UNSIGNED NOT NULL,
  `name` varchar(20) NOT NULL,
  `description` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `groups`
--

INSERT INTO `groups` (`id`, `name`, `description`) VALUES
(1, 'admin', 'Administrator'),
(2, 'members', 'General User'),
(3, 'delivery_boy', 'Delivery Boys');

-- --------------------------------------------------------

--
-- Table structure for table `languages`
--

CREATE TABLE `languages` (
  `id` int(11) NOT NULL,
  `language` varchar(128) DEFAULT NULL,
  `code` varchar(8) DEFAULT NULL,
  `is_rtl` tinyint(4) NOT NULL DEFAULT 0,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `languages`
--

INSERT INTO `languages` (`id`, `language`, `code`, `is_rtl`, `created_on`) VALUES
(1, 'English', 'en', 0, '2021-02-26 14:48:01');

-- --------------------------------------------------------

--
-- Table structure for table `login_attempts`
--

CREATE TABLE `login_attempts` (
  `id` int(11) UNSIGNED NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `login` varchar(100) NOT NULL,
  `time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `media`
--

CREATE TABLE `media` (
  `id` int(11) NOT NULL,
  `title` mediumtext NOT NULL,
  `name` mediumtext NOT NULL,
  `extension` varchar(16) NOT NULL,
  `type` varchar(16) NOT NULL,
  `sub_directory` mediumtext NOT NULL,
  `size` mediumtext NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `media`
--

INSERT INTO `media` (`id`, `title`, `name`, `extension`, `type`, `sub_directory`, `size`, `date_created`) VALUES
(1, 'logo 460 x 11411', 'logo-460x11411.png', 'png', 'image', 'uploads/media/2020/', '32358', '2021-03-31 06:32:50'),
(2, 'favicon 64', 'favicon-64.png', 'png', 'image', 'uploads/media/2020/', '14131', '2021-03-31 06:34:15');

-- --------------------------------------------------------

--
-- Table structure for table `migrations`
--

CREATE TABLE `migrations` (
  `version` bigint(20) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `migrations`
--

INSERT INTO `migrations` (`version`) VALUES
(21);

-- --------------------------------------------------------

--
-- Table structure for table `notifications`
--

CREATE TABLE `notifications` (
  `id` int(11) NOT NULL,
  `title` varchar(128) NOT NULL,
  `message` varchar(512) NOT NULL,
  `type` varchar(12) NOT NULL,
  `type_id` int(11) NOT NULL DEFAULT 0,
  `image` varchar(128) DEFAULT NULL,
  `link` varchar(512) DEFAULT 'NULL',
  `send_to` varchar(256) NOT NULL,
  `users_id` text DEFAULT NULL,
  `date_sent` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offers`
--

CREATE TABLE `offers` (
  `id` int(11) NOT NULL,
  `type` varchar(32) DEFAULT NULL,
  `type_id` int(11) DEFAULT 0,
  `min_discount` int(11) DEFAULT 0,
  `max_discount` int(11) DEFAULT 0,
  `image` varchar(256) NOT NULL,
  `link` varchar(512) DEFAULT '0',
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `offer_sliders`
--

CREATE TABLE `offer_sliders` (
  `id` int(11) NOT NULL,
  `style` varchar(256) NOT NULL,
  `offer_ids` text NOT NULL,
  `row_order` int(11) NOT NULL DEFAULT 0,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `delivery_boy_id` int(11) DEFAULT NULL,
  `address_id` int(11) DEFAULT NULL,
  `mobile` varchar(12) NOT NULL,
  `total` double NOT NULL,
  `delivery_charge` double DEFAULT 0,
  `is_delivery_charge_returnable` tinyint(4) DEFAULT 0,
  `wallet_balance` double DEFAULT 0,
  `total_payable` double DEFAULT NULL,
  `promo_code` varchar(28) DEFAULT NULL,
  `promo_discount` double DEFAULT NULL,
  `discount` double DEFAULT 0,
  `final_total` double DEFAULT NULL,
  `payment_method` varchar(16) NOT NULL,
  `latitude` varchar(256) DEFAULT NULL,
  `longitude` varchar(256) DEFAULT NULL,
  `address` mediumtext DEFAULT NULL,
  `delivery_time` varchar(128) DEFAULT NULL,
  `delivery_date` date DEFAULT NULL,
  `status` varchar(1024) NOT NULL,
  `active_status` varchar(1024) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  `otp` int(11) DEFAULT 0,
  `email` varchar(254) DEFAULT 'NULL',
  `notes` varchar(512) DEFAULT NULL,
  `attachments` varchar(2048) DEFAULT NULL,
  `is_local_pickup` tinyint(4) DEFAULT 0,
  `is_pos_order` tinyint(4) DEFAULT 0,
  `seller_notes` text DEFAULT NULL,
  `pickup_time` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_bank_transfer`
--

CREATE TABLE `order_bank_transfer` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `attachments` varchar(512) DEFAULT NULL,
  `status` tinyint(2) DEFAULT 0 COMMENT '0:pending|1:rejected|2:accepted',
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_items`
--

CREATE TABLE `order_items` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `product_name` varchar(512) DEFAULT NULL,
  `variant_name` varchar(256) DEFAULT NULL,
  `product_variant_id` int(11) NOT NULL,
  `quantity` int(11) NOT NULL,
  `price` double NOT NULL,
  `discounted_price` double DEFAULT NULL,
  `tax_percent` double DEFAULT NULL,
  `tax_amount` double DEFAULT NULL,
  `discount` double DEFAULT 0,
  `sub_total` double NOT NULL,
  `deliver_by` varchar(128) DEFAULT NULL,
  `updated_by` int(11) DEFAULT 0,
  `status` varchar(1024) NOT NULL,
  `active_status` varchar(1024) DEFAULT NULL,
  `hash_link` varchar(512) DEFAULT 'NULL',
  `is_sent` tinyint(4) DEFAULT 0,
  `is_download` tinyint(4) DEFAULT 0,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `order_tracking`
--

CREATE TABLE `order_tracking` (
  `id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_item_id` mediumtext NOT NULL,
  `shiprocket_order_id` int(11) DEFAULT NULL,
  `shipment_id` int(11) DEFAULT NULL,
  `courier_company_id` int(11) DEFAULT NULL,
  `awb_code` varchar(256) DEFAULT NULL,
  `pickup_status` int(11) NOT NULL,
  `pickup_scheduled_date` varchar(256) NOT NULL,
  `pickup_token_number` varchar(256) NOT NULL,
  `status` int(11) NOT NULL,
  `others` varchar(256) DEFAULT NULL,
  `pickup_generated_date` varchar(256) NOT NULL,
  `data` varchar(256) NOT NULL,
  `date` varchar(256) NOT NULL,
  `is_canceled` int(11) DEFAULT NULL,
  `manifest_url` varchar(256) NOT NULL,
  `label_url` varchar(256) NOT NULL,
  `invoice_url` varchar(256) NOT NULL,
  `courier_agency` varchar(20) DEFAULT NULL,
  `tracking_id` varchar(120) DEFAULT NULL,
  `url` varchar(256) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `payment_requests`
--

CREATE TABLE `payment_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `payment_type` varchar(56) NOT NULL,
  `payment_address` varchar(1024) NOT NULL,
  `amount_requested` int(11) NOT NULL,
  `remarks` varchar(512) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `pickup_locations`
--

CREATE TABLE `pickup_locations` (
  `id` int(11) NOT NULL,
  `pickup_location` varchar(512) NOT NULL,
  `name` varchar(512) NOT NULL,
  `email` varchar(512) NOT NULL,
  `phone` varchar(28) NOT NULL,
  `address` text NOT NULL,
  `address_2` text NOT NULL,
  `city` varchar(56) NOT NULL,
  `state` varchar(56) NOT NULL,
  `country` varchar(56) NOT NULL,
  `pin_code` varchar(56) NOT NULL,
  `latitude` varchar(128) DEFAULT NULL,
  `longitude` varchar(128) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `popup_offers`
--

CREATE TABLE `popup_offers` (
  `id` int(11) NOT NULL,
  `type` varchar(256) DEFAULT NULL,
  `type_id` int(11) NOT NULL,
  `min_discount` int(11) DEFAULT 0,
  `max_discount` int(11) DEFAULT 0,
  `image` varchar(256) DEFAULT NULL,
  `link` varchar(256) DEFAULT NULL,
  `status` int(11) NOT NULL DEFAULT 0,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `products`
--

CREATE TABLE `products` (
  `id` int(11) NOT NULL,
  `product_identity` varchar(50) DEFAULT NULL,
  `category_id` int(11) NOT NULL,
  `tax` double DEFAULT NULL,
  `row_order` int(11) DEFAULT 0,
  `type` varchar(34) DEFAULT NULL,
  `stock_type` varchar(64) DEFAULT NULL COMMENT '0 =>''Simple_Product_Stock_Active'' 1 => "Product_Level" 1 => "Variable_Level"',
  `name` varchar(512) NOT NULL,
  `short_description` mediumtext DEFAULT NULL,
  `slug` varchar(512) NOT NULL,
  `indicator` tinyint(4) DEFAULT NULL COMMENT '0 - none | 1 - veg | 2 - non-veg',
  `cod_allowed` int(11) DEFAULT 1,
  `download_allowed` int(11) NOT NULL DEFAULT 0,
  `download_type` varchar(40) DEFAULT NULL,
  `download_link` varchar(512) DEFAULT NULL,
  `minimum_order_quantity` int(11) DEFAULT 1,
  `quantity_step_size` int(11) DEFAULT 1,
  `total_allowed_quantity` int(11) DEFAULT NULL,
  `is_prices_inclusive_tax` int(11) DEFAULT 0,
  `is_returnable` int(11) DEFAULT 0,
  `is_cancelable` int(11) DEFAULT 0,
  `cancelable_till` varchar(32) DEFAULT NULL,
  `is_attachment_required` tinyint(4) DEFAULT 0,
  `image` mediumtext NOT NULL,
  `other_images` mediumtext DEFAULT NULL,
  `video_type` varchar(32) DEFAULT NULL,
  `video` varchar(512) DEFAULT NULL,
  `tags` text DEFAULT NULL,
  `warranty_period` varchar(32) DEFAULT NULL,
  `guarantee_period` varchar(32) DEFAULT NULL,
  `made_in` varchar(128) DEFAULT NULL,
  `brand` varchar(256) DEFAULT NULL,
  `sku` varchar(128) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `availability` tinyint(4) DEFAULT NULL,
  `rating` double DEFAULT 0,
  `no_of_ratings` int(11) DEFAULT 0,
  `description` mediumtext DEFAULT NULL,
  `deliverable_type` int(11) DEFAULT 1 COMMENT '(0:none, 1:all, 2:include, 3:exclude)',
  `deliverable_zipcodes` varchar(512) DEFAULT NULL,
  `shipping_method` int(11) DEFAULT NULL,
  `pickup_location` varchar(512) DEFAULT NULL,
  `status` int(2) DEFAULT 1,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_on_sale` tinyint(4) DEFAULT 0,
  `sale_discount` int(11) DEFAULT 0,
  `sale_start_date` datetime DEFAULT NULL,
  `sale_end_date` datetime DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_attributes`
--

CREATE TABLE `product_attributes` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `attribute_value_ids` varchar(64) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_faqs`
--

CREATE TABLE `product_faqs` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `votes` int(11) NOT NULL DEFAULT 0,
  `question` text DEFAULT NULL,
  `answer` text DEFAULT NULL,
  `answered_by` int(11) NOT NULL DEFAULT 0,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_rating`
--

CREATE TABLE `product_rating` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `rating` double NOT NULL DEFAULT 0,
  `images` mediumtext DEFAULT NULL,
  `comment` varchar(1024) DEFAULT NULL,
  `data_added` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `product_variants`
--

CREATE TABLE `product_variants` (
  `id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `attribute_value_ids` text DEFAULT NULL,
  `attribute_set` varchar(1024) DEFAULT NULL,
  `price` double NOT NULL,
  `special_price` double DEFAULT 0,
  `sku` varchar(128) DEFAULT NULL,
  `stock` int(11) DEFAULT NULL,
  `weight` float DEFAULT NULL,
  `height` float NOT NULL,
  `breadth` float NOT NULL,
  `length` float NOT NULL,
  `images` text DEFAULT NULL,
  `availability` tinyint(4) DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 1,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `promo_codes`
--

CREATE TABLE `promo_codes` (
  `id` int(11) NOT NULL,
  `promo_code` varchar(28) NOT NULL,
  `message` varchar(512) DEFAULT NULL,
  `start_date` varchar(28) DEFAULT NULL,
  `end_date` varchar(28) DEFAULT NULL,
  `no_of_users` int(11) DEFAULT NULL,
  `minimum_order_amount` double DEFAULT NULL,
  `discount` double DEFAULT NULL,
  `discount_type` varchar(32) DEFAULT NULL,
  `max_discount_amount` double DEFAULT NULL,
  `repeat_usage` tinyint(4) NOT NULL,
  `no_of_repeat_usage` int(11) DEFAULT NULL,
  `image` varchar(256) DEFAULT NULL,
  `status` tinyint(4) NOT NULL,
  `is_cashback` tinyint(4) NOT NULL DEFAULT 0,
  `list_promocode` tinyint(4) NOT NULL DEFAULT 1,
  `is_specific_users` int(11) NOT NULL DEFAULT 0,
  `users_id` varchar(256) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `return_requests`
--

CREATE TABLE `return_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `product_id` int(11) NOT NULL,
  `product_variant_id` int(11) NOT NULL,
  `order_id` int(11) NOT NULL,
  `order_item_id` int(11) NOT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `remarks` varchar(1024) DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `sections`
--

CREATE TABLE `sections` (
  `id` int(11) NOT NULL,
  `title` varchar(512) NOT NULL,
  `short_description` varchar(512) DEFAULT NULL,
  `style` varchar(16) NOT NULL,
  `product_ids` varchar(1024) DEFAULT NULL,
  `row_order` int(11) NOT NULL DEFAULT 0,
  `categories` mediumtext DEFAULT NULL,
  `product_type` varchar(1024) DEFAULT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `settings`
--

CREATE TABLE `settings` (
  `id` int(11) NOT NULL,
  `variable` varchar(128) NOT NULL,
  `value` mediumtext CHARACTER SET utf8 COLLATE utf8_general_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `settings`
--

INSERT INTO `settings` (`id`, `variable`, `value`) VALUES
(1, 'logo', 'uploads/media/2022/eShop_Single_Vendor_Logo.png'),
(2, 'privacy_policy', '<p></p><h2><b>Privacy policy</b></h2>Costumers ACCESSING, BROWSING OR OTHERWISE USING THE \\r\\nWEBSITE cityecommerce.com, Missed Call Service or mobile application \\r\\nINDICATES user is in AGREEMENT with cityecommerce vegetables & \\r\\nfruits Pvt Ltd for ALL THE TERMS AND CONDITIONS MENTIONED henceforth. \\r\\nUser is requested to READ terms and conditions CAREFULLY BEFORE \\r\\nPROCEEDING FURTHER.<br>\\r\\nUser is the person, group of person, company, trust, society, legal \\r\\nentity, legal personality or anyone who visits website, mobile app or \\r\\ngives missed call or places order with Gmartfresh via phone or website \\r\\nor mobile application or browse through website www.Gmartfresh.com.<p></p>\\r\\n\\r\\n<p>Gmartfresh reserves the right to add, alter, change, modify or delete\\r\\n any of these terms and conditions at any time without prior \\r\\ninformation. The altered terms and conditions becomes binding on the \\r\\nuser since the moment same are unloaded on the website \\r\\nwww.Gmartfresh.com</p>\\r\\n\\r\\n<p>Gmartfresh is in trade of fresh fruits and vegetables and delivers the order to home (user’s desired address) directly.</p>\\r\\n\\r\\n<p>That any user who gives missed call/call for order on any number \\r\\npublished/used by Gmartfresh.com, consents to receive, accept calls and \\r\\nmessages or any after communication from Gmartfresh vegetables & \\r\\nfruits Pvt Ltd for Promotion and Telemarketing Purposes within a week.</p>\\r\\n\\r\\n<p>If a customer do not wish to receive any communication from Gmartfresh, please SMS NO OFFERS to 9512512125.</p>\\r\\n\\r\\n<p>Gmartfresh accept orders on all seven days and user will receive the \\r\\ndelivery next day from date of order placement, as we at Gmartfresh \\r\\nprocure the fresh produce from the procurement center and deliver it \\r\\nstraight to user.</p>\\r\\n\\r\\n<p>There is Minimum Order value of Rs. 200. There are no delivery \\r\\ncharges on an order worth Rs. 200 or above. In special cases, if \\r\\npermitted, order value is less then Rs. 200/– , Rs. 40 as shipping \\r\\ncharges shall be charged from user.</p>\\r\\n\\r\\n<p>Gmartfresh updates the prices on daily basis and the price displayed \\r\\nat our website www.Gmartfresh.com, at the time of placement of order by \\r\\nuser he/she/it will be charged as per the price listed at the website \\r\\nwww.Gmartfresh.com.</p>\\r\\n\\r\\n<p>In the event, though there are remote possibilities, of wrong invoice\\r\\n generation due to any reason, in case it happens Gmartfresh vegetables \\r\\n& fruits Pvt Ltd reserve its right to again raise the correct \\r\\ninvoice at the revised amount and same shall be paid by user.</p>\\r\\n\\r\\n<p>At times it is difficult to weigh certain vegetables or fruits \\r\\nexactly as per the order or desired quantity of user, hence the delivery\\r\\n might be with five percent variation on both higher or lower side of \\r\\nexact ordered quantity, user are hereby under takes to pay to Gmartfresh\\r\\n vegetables & fruits Pvt Ltd as per the final invoice. We at \\r\\nGmartfresh understands and our endeavor is to always deliver in exact \\r\\nquantity in consonance with quantity ordered but every time it’s not \\r\\npossible but Gmartfresh guarantee the fair deal and weight to all its \\r\\nusers. Gmartfresh further assures its users that at no instance delivery\\r\\n weights/quantity vary dramatically from what quantity ordered by user.</p>\\r\\n\\r\\n<p>If some product is not available or is not of good quality, the same \\r\\nitem will not be delivered and will be adjusted accordingly in the \\r\\ninvoice; all rights in this regards are reserved with Gmartfresh. Images\\r\\n of Fruits & Vegetables present in the website are for demonstration\\r\\n purpose and may not resemble exactly in size, colour, weight, contrast \\r\\netc; though we assure our best to maintain the best quality in product, \\r\\nwhich is being our foremost commitment to the customer.</p>\\r\\n\\r\\n<p>All orders placed before 11 PM in the Night will be delivered next day or as per delivery date chosen.</p>'),
(3, 'terms_conditions', '<h3><b>Terms and conditions</b></h3><p>Costumers eshop.com is a sole proprietary firm , Juridical rights of eshop.com are reserved with eshop</p><p>Personal Information eshop.com and the website eshop.com (”The Site”) . respects your privacy. This Privacy Policy succinctly provides the manner your data is collected and used by eshop.com. on the Site. As a visitor to the Site/ Customer you are advised to please read the Privacy Policy carefully.</p><p><br></p><p>Services Overview As part of the registration process on the Site, eshop.com may collect the following personally identifiable information about you: Name including first and last name, alternate email address, mobile phone number and contact details, Postal code, GPS location, Demographic profile &#40;like your age, gender, occupation, education, address etc.&#41; and information about the pages on the site you visit/access, the links you click on the site, the number of times you access the page and any such browsing information.</p><p><br></p><p>Eligibility Services of the Site would be available to only select geographies in India. Persons who are \\\"incompetent to contract\\\" within the meaning of the Indian Contract Act, 1872 including un-discharged insolvents etc. are not eligible to use the Site. If you are a minor i.e. under the age of 18 years but at least 13 years of age you may use the Site only under the supervision of a parent or legal guardian who agrees to be bound by these Terms of Use. If your age is below 18 years, your parents or legal guardians can transact on behalf of you if they are registered users. You are prohibited from purchasing any material which is for adult consumption and the sale of which to minors is prohibited.</p><p><br></p><p>License & Site Access eshop.com grants you a limited sub-license to access and make personal use of this site and not to download (other than page caching) or modify it, or any portion of it, except with express written consent of eshop.com. This license does not include any resale or commercial use of this site or its contents; any collection and use of any product listings, descriptions, or prices; any derivative use of this site or its contents; any downloading or copying of account information for the benefit of another merchant; or any use of data mining, robots, or similar data gathering and extraction tools. This site or any portion of this site may not be reproduced, duplicated, copied, sold, resold, visited or otherwise exploited for any commercial purpose without express written consent of eshop.com. You may not frame or utilize framing techniques to enclose any trademark, logo, or other proprietary information (including images, text, page layout, or form) of the Site or of eshop.com and its affiliates without express written consent. You may not use any meta tags or any other \\\"hidden text\\\" utilizing the Site’s or eshop.com’s name or eshop.com’s name or trademarks without the express written consent of eshop.com. Any unauthorized use, terminates the permission or license granted by eshop.com</p><p><br></p><p>Account & Registration Obligations All shoppers have to register and login for placing orders on the Site. You have to keep your account and registration details current and correct for communications related to your purchases from the site. By agreeing to the terms and conditions, the shopper agrees to receive promotional communication and newsletters upon registration. The customer can opt out either by unsubscribing in \\\"My Account\\\" or by contacting the customer service.</p><p><br></p><p>Pricing All the products listed on the Site will be sold at MRP unless otherwise specified. The prices mentioned at the time of ordering will be the prices charged on the date of the delivery. Although prices of most of the products do not fluctuate on a daily basis but some of the commodities and fresh food prices do change on a daily basis. In case the prices are higher or lower on the date of delivery not additional charges will be collected or refunded as the case may be at the time of the delivery of the order.</p><p><br></p><p>Cancellation by Site / Customer You as a customer can cancel your order anytime up to the cut-off time of the slot for which you have placed an order by calling our customer service. In such a case we will Credit your wallet against any payments already made by you for the order. If we suspect any fraudulent transaction by any customer or any transaction which defies the terms & conditions of using the website, we at our sole discretion could cancel such orders. We will maintain a negative list of all fraudulent transactions and customers and would deny access to them or cancel any orders placed by them.</p><p><br></p><p>Return & Refunds We have a \\\"no questions asked return policy\\\" which entitles all our Delivery Ambassadors to return the product at the time of delivery if due to any reason they are not satisfied with the quality or freshness of the product. We will take the returned product back with us and issue a credit note for the value of the return products which will be credited to your account on the Site. This can be used to pay your subsequent shopping bills. Refund will be processed through same online mode within 7 working days.</p><p><br></p><p><br></p><p>Delivery & Shipping Charge</p><p><br></p><p>1.You can expect to receive your order depending on the delivery option you have chosen.</p><p><br></p><p>2.You can order 24*7 in website & mobile application , Our delivery timeings are between 06:00 AM - 02:00PM Same day delivery.</p><p><br></p><p>3.You will get free shipping on order amount above Rs.150.</p><p>You Agree and Confirm</p><p>1. That in the event that a non-delivery occurs on account of a mistake by you (i.e. wrong name or address or any other wrong information) any extra cost incurred by eshop. for redelivery shall be claimed from you.</p><p>2. That you will use the services provided by the Site, its affiliates, consultants and contracted companies, for lawful purposes only and comply with all applicable laws and regulations while using and transacting on the Site.</p><p>3. You will provide authentic and true information in all instances where such information is requested you. eshop reserves the right to confirm and validate the information and other details provided by you at any point of time. If upon confirmation your details are found not to be true (wholly or partly), it has the right in its sole discretion to reject the registration and debar you from using the Services and / or other affiliated websites without prior intimation whatsoever.</p><p>4. That you are accessing the services available on this Site and transacting at your sole risk and are using your best and prudent judgment before entering into any transaction through this Site.</p><p>5. That the address at which delivery of the product ordered by you is to be made will be correct and proper in all respects.</p><p>6. That before placing an order you will check the product description carefully. By placing an order for a product you agree to be bound by the conditions of sale included in the item\\\'s description.</p><p><br></p><p>You may not use the Site for any of the following purposes:</p><p>1. Disseminating any unlawful, harassing, libelous, abusive, threatening, harmful, vulgar, obscene, or otherwise objectionable material.</p><p>2. Transmitting material that encourages conduct that constitutes a criminal offence or results in civil liability or otherwise breaches any relevant laws, regulations or code of practice.</p><p>3. Gaining unauthorized access to other computer systems.</p><p>4. Interfering with any other person\\\'s use or enjoyment of the Site.</p><p>5. Breaching any applicable laws;</p><p>6. Interfering or disrupting networks or web sites connected to the Site.</p><p>7. Making, transmitting or storing electronic copies of materials protected by copyright without the permission of the owner.</p><p><br></p><p>Colors we have made every effort to display the colors of our products that appear on the Website as accurately as possible. However, as the actual colors you see will depend on your monitor, we cannot guarantee that your monitor\\\'s display of any color will be accurate.</p><p><br></p><p>Modification of Terms & Conditions of Service eshop may at any time modify the Terms & Conditions of Use of the Website without any prior notification to you. You can access the latest version of these Terms & Conditions at any given time on the Site. You should regularly review the Terms & Conditions on the Site. In the event the modified Terms & Conditions is not acceptable to you, you should discontinue using the Service. However, if you continue to use the Service you shall be deemed to have agreed to accept and abide by the modified Terms & Conditions of Use of this Site.</p><p><br></p><p>Governing Law and Jurisdiction This User Agreement shall be construed in accordance with the applicable laws of India. The Courts at Faridabad shall have exclusive jurisdiction in any proceedings arising out of this agreement. Any dispute or difference either in interpretation or otherwise, of any terms of this User Agreement between the parties hereto, the same shall be referred to an independent arbitrator who will be appointed by eshop and his decision shall be final and binding on the parties hereto. The above arbitration shall be in accordance with the Arbitration and Conciliation Act, 1996 as amended from time to time. The arbitration shall be held in Nagpur. The High Court of judicature at Nagpur Bench of Mumbai High Court alone shall have the jurisdiction and the Laws of India shall apply.</p><p><br></p><p>Reviews, Feedback, Submissions All reviews, comments, feedback, postcards, suggestions, ideas, and other submissions disclosed, submitted or offered to the Site on or by this Site or otherwise disclosed, submitted or offered in connection with your use of this Site (collectively, the \\\"Comments\\\") shall be and remain the property of eshop Such disclosure, submission or offer of any Comments shall constitute an assignment to eshop of all worldwide rights, titles and interests in all copyrights and other intellectual properties in the Comments. Thus, eshop owns exclusively all such rights, titles and interests and shall not be limited in any way in its use, commercial or otherwise, of any Comments. eshopwill be entitled to use, reproduce, disclose, modify, adapt, create derivative works from, publish, display and distribute any Comments you submit for any purpose whatsoever, without restriction and without compensating you in any way. eshop is and shall be under no obligation (1) to maintain any Comments in confidence; (2) to pay you any compensation for any Comments; or (3) to respond to any Comments. You agree that any Comments submitted by you to the Site will not violate this policy or any right of any third party, including copyright, trademark, privacy or other personal or proprietary right(s), and will not cause injury to any person or entity. You further agree that no Comments submitted by you to the Website will be or contain libelous or otherwise unlawful, threatening, abusive or obscene material, or contain software viruses, political campaigning, commercial solicitation, chain letters, mass mailings or any form of \\\"spam\\\". eshop does not regularly review posted Comments, but does reserve the right (but not the obligation) to monitor and edit or remove any Comments submitted to the Site. You grant eshopthe right to use the name that you submit in connection with any Comments. You agree not to use a false email address, impersonate any person or entity, or otherwise mislead as to the origin of any Comments you submit. You are and shall remain solely responsible for the content of any Comments you make and you agree to indemnify eshop and its affiliates for all claims resulting from any Comments you submit. eshop and its affiliates take no responsibility and assume no liability for any Comments submitted by you or any third party.</p><p><br></p><p>Copyright & Trademark eshop.com and eshop.com, its suppliers and licensors expressly reserve all intellectual property rights in all text, programs, products, processes, technology, content and other materials, which appear on this Site. Access to this Website does not confer and shall not be considered as conferring upon anyone any license under any of eshop.com or any third party\\\'s intellectual property rights. All rights, including copyright, in this website are owned by or licensed to eshop.com from eshop.com. Any use of this website or its contents, including copying or storing it or them in whole or part, other than for your own personal, non-commercial use is prohibited without the permission of eshop.com and/or eshop.com. You may not modify, distribute or re-post anything on this website for any purpose.The names and logos and all related product and service names, design marks and slogans are the trademarks or service marks of eshop.com, eshop.com, its affiliates, its partners or its suppliers. All other marks are the property of their respective companies. No trademark or service mark license is granted in connection with the materials contained on this Site. Access to this Site does not authorize anyone to use any name, logo or mark in any manner.References on this Site to any names, marks, products or services of third parties or hypertext links to third party sites or information are provided solely as a convenience to you and do not in any way constitute or imply eshop.com or eshop.com\\\'s endorsement, sponsorship or recommendation of the third party, information, product or service. eshop.com or eshop.com is not responsible for the content of any third party sites and does not make any representations regarding the content or accuracy of material on such sites. If you decide to link to any such third party websites, you do so entirely at your own risk. All materials, including images, text, illustrations, designs, icons, photographs, programs, music clips or downloads, video clips and written and other materials that are part of this Website (collectively, the \\\"Contents\\\") are intended solely for personal, non-commercial use. You may download or copy the Contents and other downloadable materials displayed on the Website for your personal use only. No right, title or interest in any downloaded materials or software is transferred to you as a result of any such downloading or copying. You may not reproduce (except as noted above), publish, transmit, distribute, display, modify, create derivative works from, sell or participate in any sale of or exploit in any way, in whole or in part, any of the Contents, the Website or any related software. All software used on this Website is the property of eshop.com or its licensees and suppliers and protected by Indian and international copyright laws. The Contents and software on this Website may be used only as a shopping resource. Any other use, including the reproduction, modification, distribution, transmission, republication, display, or performance, of the Contents on this Website is strictly prohibited. Unless otherwise noted, all Contents are copyrights, trademarks, trade dress and/or other intellectual property owned, controlled or licensed by eshop.com, one of its affiliates or by third parties who have licensed their materials to eshop.com and are protected by Indian and international copyright laws. The compilation (meaning the collection, arrangement, and assembly) of all Contents on this Website is the exclusive property of eshop.com and eshop.com and is also protected by Indian and international copyright laws.</p><p><br></p><p>Objectionable Material You understand that by using this Site or any services provided on the Site, you may encounter Content that may be deemed by some to be offensive, indecent, or objectionable, which Content may or may not be identified as such. You agree to use the Site and any service at your sole risk and that to the fullest extent permitted under applicable law, eshop.com and/or eshop.com and its affiliates shall have no liability to you for Content that may be deemed offensive, indecent, or objectionable to you.</p><p><br></p><p>Indemnity You agree to defend, indemnify and hold harmless eshop.com, eshop.com, its employees, directors, Coordinators, officers, agents, interns and their successors and assigns from and against any and all claims, liabilities, damages, losses, costs and expenses, including attorney\\\'s fees, caused by or arising out of claims based upon your actions or inactions, which may result in any loss or liability to eshop.com or eshop.com or any third party including but not limited to breach of any warranties, representations or undertakings or in relation to the non-fulfillment of any of your obligations under this User Agreement or arising out of the violation of any applicable laws, regulations including but not limited to Intellectual Property Rights, payment of statutory dues and taxes, claim of libel, defamation, violation of rights of privacy or publicity, loss of service by other subscribers and infringement of intellectual property or other rights. This clause shall survive the expiry or termination of this User Agreement.</p><p><br></p><p>Termination This User Agreement is effective unless and until terminated by either you or eshop.com. You may terminate this User Agreement at any time, provided that you discontinue any further use of this Site. eshop.com may terminate this User Agreement at any time and may do so immediately without notice, and accordingly deny you access to the Site, Such termination will be without any liability to eshop.com. Upon any termination of the User Agreement by either you or eshop.com, you must promptly destroy all materials downloaded or otherwise obtained from this Site, as well as all copies of such materials, whether made under the User Agreement or otherwise. eshop.com\\\'s right to any Comments shall survive any termination of this User Agreement. Any such termination of the User Agreement shall not cancel your obligation to pay for the product already ordered from the Website or affect any liability that may have arisen under the User Agreement.</p>'),
(4, 'fcm_server_key', 'your fcm_server_key'),
(5, 'contact_us', '<h2><strong>Contact Us</strong></h2>\\r\\n\\r\\n<p>For any kind of queries related to products, orders or services feel free to contact us on our official email address or phone number as given below :</p>\\r\\n\\r\\n<p> </p>\\r\\n\\r\\n<h3><strong>Areas we deliver : </strong></h3>\\r\\n\\r\\n<p> </p>\\r\\n\\r\\n<h3><strong>Delivery Timings :</strong></h3>\\r\\n\\r\\n<ol>\\r\\n <li><strong>  8:00 AM To 10:30 AM</strong></li>\\r\\n <li><strong>10:30 AM To 12:30 PM</strong></li>\\r\\n <li><strong>  4:00 PM To  7:00 PM</strong></li></ol><h3> <strong></strong>\\r\\n\\r\\n</h3><p><strong>Note : </strong>You can order for maximum 2days in advance. i.e., Today & Tomorrow only.  <br></p>'),
(6, 'system_settings', '{\"system_configurations\":\"1\",\"system_timezone_gmt\":\"+05:30\",\"system_configurations_id\":\"13\",\"app_name\":\"eShop - ecommerce\",\"support_number\":\"9876543210\",\"support_email\":\"support@eshop.com\",\"current_version\":\"1.0.0\",\"current_version_ios\":\"1.0.0\",\"is_version_system_on\":\"1\",\"area_wise_delivery_charge\":\"1\",\"currency\":\"\\u20b9\",\"delivery_charge\":\"10\",\"min_amount\":\"100\",\"system_timezone\":\"Asia\\/Kolkata\",\"is_refer_earn_on\":\"1\",\"min_refer_earn_order_amount\":\"100\",\"refer_earn_bonus\":\"10\",\"refer_earn_method\":\"percentage\",\"max_refer_earn_amount\":\"50\",\"refer_earn_bonus_times\":\"2\",\"welcome_wallet_balance_on\":\"0\",\"wallet_balance_amount\":\"100\",\"allow_order_attachments\":\"1\",\"upload_limit\":\"10\",\"minimum_cart_amt\":\"50\",\"low_stock_limit\":\"15\",\"max_items_cart\":\"12\",\"delivery_boy_bonus_percentage\":\"1\",\"max_product_return_days\":\"1\",\"is_delivery_boy_otp_setting_on\":\"1\",\"cart_btn_on_list\":\"1\",\"expand_product_images\":\"0\",\"tax_name\":\"GST Number\",\"tax_number\":\"24GSTIN1022520\",\"company_name\":\"\",\"company_url\":\"\",\"supported_locals\":\"INR\",\"is_customer_app_under_maintenance\":\"0\",\"is_admin_app_under_maintenance\":\"0\",\"is_delivery_boy_app_under_maintenance\":\"0\",\"message_for_customer_app\":\"\",\"message_for_admin_app\":\"\",\"message_for_delivery_boy_app\":\"\",\"local_pickup\":\"0\",\"address\":\"#262-265, Time Square Empire SH 42, highway, Goa, 643987\",\"latitude\":\"12355156756468\",\"longitude\":\"156754687\"}'),
(7, 'payment_method', '{\"paypal_payment_method\":\"1\",\"paypal_mode\":\"sandbox\",\"paypal_business_email\":\"seller@somedomain.com\",\"currency_code\":\"USD\",\"razorpay_payment_method\":\"1\",\"razorpay_key_id\":\"your key\",\"razorpay_secret_key\":\"your razorpay_secret_key\",\"paystack_payment_method\":\"1\",\"paystack_key_id\":\"your paystack_key_id\",\"paystack_secret_key\":\"your paystack_secret_key\",\"stripe_payment_method\":\"1\",\"stripe_payment_mode\":\"test\",\"stripe_publishable_key\":\"your stripe_publishable_key\",\"stripe_secret_key\":\"your stripe_secret_key\",\"stripe_webhook_secret_key\":\"your stripe_webhook_secret_key\",\"stripe_currency_code\":\"INR\",\"flutterwave_payment_method\":\"1\",\"flutterwave_public_key\":\"your flutterwave_public_key\",\"flutterwave_secret_key\":\"your flutterwave_secret_key\",\"flutterwave_encryption_key\":\"your flutterwave_encryption_key\",\"flutterwave_currency_code\":\"NGN\",\"paytm_payment_method\":\"1\",\"paytm_payment_mode\":\"sandbox\",\"paytm_merchant_key\":\"your paytm_merchant_key\",\"paytm_merchant_id\":\"your paytm_merchant_id\",\"paytm_website\":\"WEBSTAGING\",\"paytm_industry_type_id\":\"Retail\",\"google_pay_payment_method\":\"0\",\"google_pay_mode\":\"\",\"google_pay_merchant_name\":\"\",\"google_pay_merchant_id\":\"\",\"google_pay_currency_code\":\"\",\"google_pay_country_code\":\"\",\"direct_bank_transfer\":\"1\",\"account_name\":\"eShop E-Commerce LLC.\",\"account_number\":\"1234567891012\",\"bank_name\":\"State Bank of India\",\"bank_code\":\"SBI0123456789\",\"notes\":\"Please do not forget to upload the bank transfer receipt upon sending \\/ depositing money to the above-mentioned account. Once the amount deposit is confirmed the order will be processed further. To upload the receipt go to your order details page or screen and find a form to upload the receipt.\",\"cod_method\":\"1\"}'),
(8, 'about_us', '<p>About us <br></p>'),
(9, 'currency', '₹'),
(11, 'email_settings', '{\"email\":\"your email\",\"password\":\"your password\",\"smtp_host\":\"your smtp_host\",\"smtp_port\":\"your smtp_port\",\"mail_content_type\":\"html\",\"smtp_encryption\":\"ssl\"}'),
(12, 'time_slot_config', '{\"time_slot_config\":\"1\",\"is_time_slots_enabled\":\"1\",\"delivery_starts_from\":\"1\",\"allowed_days\":\"7\"}'),
(13, 'favicon', 'uploads/media/2022/eShop_Single_Vendor_Favicon_Icon.png'),
(14, 'delivery_boy_privacy_policy', '<p><span xss=\\\"removed\\\">Neeraj delivery boy ACCESSING, </span>BROWSING OR OTHERWISE USING THE WEBSITE cityecommerce.com, Missed Call Service or mobile application INDICATES user is in AGREEMENT with cityecommerce vegetables & fruits Pvt Ltd for ALL THE TERMS AND CONDITIONS MENTIONED henceforth. User is requested to READ terms and conditions CAREFULLY BEFORE PROCEEDING FURTHER.<br>User is the person, group of person, company, trust, society, legal entity, legal personality or anyone who visits website, mobile app or gives missed call or places order with Gmartfresh via phone or website or mobile application or browse through website www.Gmartfresh.com.</p><p>Gmartfresh reserves the right to add, alter, change, modify or delete any of these terms and conditions at any time without prior information. The altered terms and conditions becomes binding on the user since the moment same are unloaded on the website www.Gmartfresh.com</p><p>Gmartfresh is in trade of fresh fruits and vegetables and delivers the order to home (user’s desired address) directly.</p><p>That any user who gives missed call/call for order on any number published/used by Gmartfresh.com, consents to receive, accept calls and messages or any after communication from Gmartfresh vegetables & fruits Pvt Ltd for Promotion and Telemarketing Purposes within a week.</p><p>If a customer do not wish to receive any communication from Gmartfresh, please SMS NO OFFERS to 9512512125.</p><p>Gmartfresh accept orders on all seven days and user will receive the delivery next day from date of order placement, as we at Gmartfresh procure the fresh produce from the procurement center and deliver it straight to user.</p><p>There is Minimum Order value of Rs. 200. There are no delivery charges on an order worth Rs. 200 or above. In special cases, if permitted, order value is less then Rs. 200/– , Rs. 40 as shipping charges shall be charged from user.</p><p>Gmartfresh updates the prices on daily basis and the price displayed at our website www.Gmartfresh.com, at the time of placement of order by user he/she/it will be charged as per the price listed at the website www.Gmartfresh.com.</p><p>In the event, though there are remote possibilities, of wrong invoice generation due to any reason, in case it happens Gmartfresh vegetables & fruits Pvt Ltd reserve its right to again raise the correct invoice at the revised amount and same shall be paid by user.</p><p>At times it is difficult to weigh certain vegetables or fruits exactly as per the order or desired quantity of user, hence the delivery might be with five percent variation on both higher or lower side of exact ordered quantity, user are hereby under takes to pay to Gmartfresh vegetables & fruits Pvt Ltd as per the final invoice. We at Gmartfresh understands and our endeavor is to always deliver in exact quantity in consonance with quantity ordered but every time it’s not possible but Gmartfresh guarantee the fair deal and weight to all its users. Gmartfresh further assures its users that at no instance delivery weights/quantity vary dramatically from what quantity ordered by user.</p><p>If some product is not available or is not of good quality, the same item will not be delivered and will be adjusted accordingly in the invoice; all rights in this regards are reserved with Gmartfresh. Images of Fruits & Vegetables present in the website are for demonstration purpose and may not resemble exactly in size, colour, weight, contrast etc; though we assure our best to maintain the best quality in product, which is being our foremost commitment to the customer.</p><p>All orders placed before 11 PM in the Night will be delivered next day or as per delivery date chosen.</p>'),
(15, 'delivery_boy_terms_conditions', '<p><span xss=\\\"removed\\\">Neeraj delivery boy ACCESSING, </span>BROWSING OR OTHERWISE USING THE WEBSITE cityecommerce.com, Missed Call Service or mobile application INDICATES user is in AGREEMENT with cityecommerce vegetables & fruits Pvt Ltd for ALL THE TERMS AND CONDITIONS MENTIONED henceforth. User is requested to READ terms and conditions CAREFULLY BEFORE PROCEEDING FURTHER.<br>User is the person, group of person, company, trust, society, legal entity, legal personality or anyone who visits website, mobile app or gives missed call or places order with Gmartfresh via phone or website or mobile application or browse through website www.Gmartfresh.com.</p><p>Gmartfresh reserves the right to add, alter, change, modify or delete any of these terms and conditions at any time without prior information. The altered terms and conditions becomes binding on the user since the moment same are unloaded on the website www.Gmartfresh.com</p><p>Gmartfresh is in trade of fresh fruits and vegetables and delivers the order to home (user’s desired address) directly.</p><p>That any user who gives missed call/call for order on any number published/used by Gmartfresh.com, consents to receive, accept calls and messages or any after communication from Gmartfresh vegetables & fruits Pvt Ltd for Promotion and Telemarketing Purposes within a week.</p><p>If a customer do not wish to receive any communication from Gmartfresh, please SMS NO OFFERS to 9512512125.</p><p>Gmartfresh accept orders on all seven days and user will receive the delivery next day from date of order placement, as we at Gmartfresh procure the fresh produce from the procurement center and deliver it straight to user.</p><p>There is Minimum Order value of Rs. 200. There are no delivery charges on an order worth Rs. 200 or above. In special cases, if permitted, order value is less then Rs. 200/– , Rs. 40 as shipping charges shall be charged from user.</p><p>Gmartfresh updates the prices on daily basis and the price displayed at our website www.Gmartfresh.com, at the time of placement of order by user he/she/it will be charged as per the price listed at the website www.Gmartfresh.com.</p><p>In the event, though there are remote possibilities, of wrong invoice generation due to any reason, in case it happens Gmartfresh vegetables & fruits Pvt Ltd reserve its right to again raise the correct invoice at the revised amount and same shall be paid by user.</p><p>At times it is difficult to weigh certain vegetables or fruits exactly as per the order or desired quantity of user, hence the delivery might be with five percent variation on both higher or lower side of exact ordered quantity, user are hereby under takes to pay to Gmartfresh vegetables & fruits Pvt Ltd as per the final invoice. We at Gmartfresh understands and our endeavor is to always deliver in exact quantity in consonance with quantity ordered but every time it’s not possible but Gmartfresh guarantee the fair deal and weight to all its users. Gmartfresh further assures its users that at no instance delivery weights/quantity vary dramatically from what quantity ordered by user.</p><p>If some product is not available or is not of good quality, the same item will not be delivered and will be adjusted accordingly in the invoice; all rights in this regards are reserved with Gmartfresh. Images of Fruits & Vegetables present in the website are for demonstration purpose and may not resemble exactly in size, colour, weight, contrast etc; though we assure our best to maintain the best quality in product, which is being our foremost commitment to the customer.</p><p>All orders placed before 11 PM in the Night will be delivered next day or as per delivery date chosen.</p>'),
(16, 'web_logo', 'uploads/media/2022/eShop_Single_Vendor_Logo.png'),
(17, 'web_favicon', 'uploads/media/2022/eShop_Single_Vendor_Favicon_Icon.png'),
(18, 'web_settings', '{\"site_title\":\"eShop - Multipurpose Ecommerce Store\",\"support_number\":\"1234567890\",\"support_email\":\"eshop@gmail.com\",\"copyright_details\":\"Copyright \\u00a9 2021, All Right Reserved WRTeam\",\"address\":\"Time Square Empire, WRTeam , Mirzapar Highway , Bhuj , Kutch , Gujarat - 370001\",\"app_short_description\":\"eShop is a multipurpose Ecommerce Platform best suitable for all kinds of sectors like Electronics, Fashion, Groceries and Vegetables, Flowers, Gift articles, Medical, and more ..\\\\r\\\\ndvbdjbv\\\\r\\\\ndvjb\\\\r\\\\ndvdjnvjkn\",\"map_iframe\":\"&lt;iframe src=\\\\\\\"https:\\/\\/www.google.com\\/maps\\/embed?pb=!1m18!1m12!1m3!1d58652.60185263579!2d69.63381478835316!3d23.250814410717105!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3950e209000b6f17:0x7077f358af0774a6!2sBhuj, Gujarat!5e0!3m2!1sen!2sin!4v1614852897708!5m2!1sen!2sin\\\\\\\" width=\\\\\\\"600\\\\\\\" height=\\\\\\\"450\\\\\\\" style=\\\\\\\"border:0;\\\\\\\" allowfullscreen=\\\\\\\"\\\\\\\" loading=\\\\\\\"lazy\\\\\\\"&gt;&lt;\\/iframe&gt;\",\"logo\":\"uploads\\/media\\/2022\\/eShop_Single_Vendor_Logo.png\",\"favicon\":\"uploads\\/media\\/2022\\/eShop_Single_Vendor_Favicon_Icon.png\",\"meta_keywords\":\"Eshop , E-commerce\",\"meta_description\":\"Eshop is an ecommerce platform\",\"app_download_section\":true,\"app_download_section_title\":\"eShop Mobile App\",\"app_download_section_tagline\":\"Affordable Ecommerce Platform\",\"app_download_section_short_description\":\"Shop with us at affordable prices and get exciting cashback & offers.\",\"app_download_section_playstore_url\":\"https:\\/\\/play.google.com\\/\",\"app_download_section_appstore_url\":\"https:\\/\\/www.apple.com\\/in\\/app-store\\/\",\"twitter_link\":\"https:\\/\\/twitter.com\\/\",\"facebook_link\":\"https:\\/\\/facebook.com\\/\",\"instagram_link\":\"https:\\/\\/instagram.com\\/\",\"youtube_link\":\"https:\\/\\/youtube.com\\/\",\"shipping_mode\":true,\"shipping_title\":\"Free Shipping\",\"shipping_description\":\"Free Shipping at your door step.\",\"return_mode\":true,\"return_title\":\"Free Returns\",\"return_description\":\"Free return if products are damaged.\",\"support_mode\":true,\"support_title\":\"Support 24\\/7\",\"support_description\":\"24\\/7 and 365 days support is available.\",\"safety_security_mode\":true,\"safety_security_title\":\"100% Safe & Secure\",\"safety_security_description\":\"100% safe & secure.\"}'),
(19, 'firebase_settings', '{\"apiKey\":\"your firebase apiKey\",\"authDomain\":\"your firebase authDomain\",\"databaseURL\":\"your firebase databaseURL\",\"projectId\":\"your firebase projectId\",\"storageBucket\":\"your firebase storageBucket\",\"messagingSenderId\":\"your firebase messagingSenderId\",\"appId\":\"your firebase appId\",\"measurementId\":\"your firebase measurementId\"}'),
(20, 'admin_privacy_policy', '<p>Admin ACCESSING, BROWSING OR OTHERWISE USING THE WEBSITE cityecommerce.com, Missed Call Service or mobile application INDICATES user is in AGREEMENT with cityecommerce vegetables & fruits Pvt Ltd for ALL THE TERMS AND CONDITIONS MENTIONED henceforth. User is requested to READ terms and conditions CAREFULLY BEFORE PROCEEDING FURTHER.</span></p><p>User is the person, group of person, company, trust, society, legal entity, legal personality or anyone who visits website, mobile app or gives missed call or places order with Gmartfresh via phone or website or mobile application or browse through website www.Gmartfresh.com.</p><p>Gmartfresh reserves the right to add, alter, change, modify or delete any of these terms and conditions at any time without prior information. The altered terms and conditions becomes binding on the user since the moment same are unloaded on the website www.Gmartfresh.com</p><p>Gmartfresh is in trade of fresh fruits and vegetables and delivers the order to home (user’s desired address) directly.</p><p>That any user who gives missed call/call for order on any number published/used by Gmartfresh.com, consents to receive, accept calls and messages or any after communication from Gmartfresh vegetables & fruits Pvt Ltd for Promotion and Telemarketing Purposes within a week.</p><p>If a customer do not wish to receive any communication from Gmartfresh, please SMS NO OFFERS to 9512512125.</p><p>Gmartfresh accept orders on all seven days and user will receive the delivery next day from date of order placement, as we at Gmartfresh procure the fresh produce from the procurement center and deliver it straight to user.</p><p>There is Minimum Order value of Rs. 200. There are no delivery charges on an order worth Rs. 200 or above. In special cases, if permitted, order value is less then Rs. 200/– , Rs. 40 as shipping charges shall be charged from user.</p><p>Gmartfresh updates the prices on daily basis and the price displayed at our website www.Gmartfresh.com, at the time of placement of order by user he/she/it will be charged as per the price listed at the website www.Gmartfresh.com.</p><p>In the event, though there are remote possibilities, of wrong invoice generation due to any reason, in case it happens Gmartfresh vegetables & fruits Pvt Ltd reserve its right to again raise the correct invoice at the revised amount and same shall be paid by user.</p><p>At times it is difficult to weigh certain vegetables or fruits exactly as per the order or desired quantity of user, hence the delivery might be with five percent variation on both higher or lower side of exact ordered quantity, user are hereby under takes to pay to Gmartfresh vegetables & <span xss=\\\"removed\\\">ACCESSING </span><span xss=\\\"removed\\\">fruits Pvt Ltd as per the final invoice. We at Gmartfresh understands and our endeavor is to always deliver in exact quantity in consonance with quantity ordered but every time it’s not possible but Gmartfresh guarantee the fair deal and weight to all its users. Gmartfresh further assures its users that at no instance delivery weights/quantity vary dramatically from what quantity ordered by user.</span></p><p>If some product is not available or is not of good quality, the same item will not be delivered and will be adjusted accordingly in the invoice; all rights in this regards are reserved with Gmartfresh. Images of Fruits & Vegetables present in the website are for demonstration purpose and may not resemble exactly in size, colour, weight, contrast etc; though we assure our best to maintain the best quality in product, which is being our foremost commitment to the customer.</p><p>All orders placed before 11 PM in the Night will be delivered next day or as per delivery date chosen.</p>'),
(21, 'admin_terms_conditions', '<p>Admin ACCESSING, BROWSING OR OTHERWISE USING THE WEBSITE cityecommerce.com, Missed Call Service or mobile application INDICATES user is in AGREEMENT with cityecommerce vegetables & fruits Pvt Ltd for ALL THE TERMS AND CONDITIONS MENTIONED henceforth. User is requested to READ terms and conditions CAREFULLY BEFORE PROCEEDING FURTHER.</span></p><p>User is the person, group of person, company, trust, society, legal entity, legal personality or anyone who visits website, mobile app or gives missed call or places order with Gmartfresh via phone or website or mobile application or browse through website www.Gmartfresh.com.</p><p>Gmartfresh reserves the right to add, alter, change, modify or delete any of these terms and conditions at any time without prior information. The altered terms and conditions becomes binding on the user since the moment same are unloaded on the website www.Gmartfresh.com</p><p>Gmartfresh is in trade of fresh fruits and vegetables and delivers the order to home (user’s desired address) directly.</p><p>That any user who gives missed call/call for order on any number published/used by Gmartfresh.com, consents to receive, accept calls and messages or any after communication from Gmartfresh vegetables & fruits Pvt Ltd for Promotion and Telemarketing Purposes within a week.</p><p>If a customer do not wish to receive any communication from Gmartfresh, please SMS NO OFFERS to 9512512125.</p><p>Gmartfresh accept orders on all seven days and user will receive the delivery next day from date of order placement, as we at Gmartfresh procure the fresh produce from the procurement center and deliver it straight to user.</p><p>There is Minimum Order value of Rs. 200. There are no delivery charges on an order worth Rs. 200 or above. In special cases, if permitted, order value is less then Rs. 200/– , Rs. 40 as shipping charges shall be charged from user.</p><p>Gmartfresh updates the prices on daily basis and the price displayed at our website www.Gmartfresh.com, at the time of placement of order by user he/she/it will be charged as per the price listed at the website www.Gmartfresh.com.</p><p>In the event, though there are remote possibilities, of wrong invoice generation due to any reason, in case it happens Gmartfresh vegetables & fruits Pvt Ltd reserve its right to again raise the correct invoice at the revised amount and same shall be paid by user.</p><p>At times it is difficult to weigh certain vegetables or fruits exactly as per the order or desired quantity of user, hence the delivery might be with five percent variation on both higher or lower side of exact ordered quantity, user are hereby under takes to pay to Gmartfresh vegetables & fruits Pvt Ltd as per the final invoice. We at Gmartfresh understands and our endeavor is to always deliver in exact quantity in consonance with quantity ordered but every time it’s not possible but Gmartfresh guarantee the fair deal and weight to all its users. Gmartfresh further assures its users that at no instance delivery weights/quantity vary dramatically from what quantity ordered by user.</p><p>If some product is not available or is not of good quality, the same item will not be delivered and will be adjusted accordingly in the invoice; all rights in this regards are reserved with Gmartfresh. Images of Fruits & Vegetables present in the website are for demonstration purpose and may not resemble exactly in size, colour, weight, contrast etc; though we assure our best to maintain the best quality in product, which is being our foremost commitment to the customer.</p><p>All orders placed before 11 PM in the Night will be delivered next day or as per delivery date chosen.</p>'),
(23, 'return_policy', 'Return policy'),
(24, 'shipping_policy', 'Shipping Policy');

-- --------------------------------------------------------

--
-- Table structure for table `sliders`
--

CREATE TABLE `sliders` (
  `id` int(11) NOT NULL,
  `type` varchar(16) NOT NULL,
  `type_id` int(11) NOT NULL DEFAULT 0,
  `image` varchar(256) NOT NULL,
  `link` varchar(512) DEFAULT 'NULL',
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `system_notification`
--

CREATE TABLE `system_notification` (
  `id` int(11) NOT NULL,
  `title` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `message` varchar(256) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type` varchar(256) NOT NULL,
  `type_id` int(11) NOT NULL DEFAULT 0,
  `read_by` tinyint(4) DEFAULT 0,
  `date_sent` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `taxes`
--

CREATE TABLE `taxes` (
  `id` int(11) NOT NULL,
  `title` mediumtext DEFAULT NULL,
  `percentage` mediumtext NOT NULL,
  `status` tinyint(2) NOT NULL DEFAULT 1
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `themes`
--

CREATE TABLE `themes` (
  `id` int(11) NOT NULL,
  `name` varchar(32) NOT NULL,
  `slug` varchar(32) NOT NULL,
  `image` varchar(512) DEFAULT NULL,
  `is_default` tinyint(4) NOT NULL DEFAULT 0,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `created_on` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Dumping data for table `themes`
--

INSERT INTO `themes` (`id`, `name`, `slug`, `image`, `is_default`, `status`, `created_on`) VALUES
(1, 'Classic', 'classic', 'classic.jpg', 0, 1, '2021-02-26 14:48:01'),
(2, 'modern', 'modern', 'modern.png', 1, 1, '2023-05-25 10:19:12');

-- --------------------------------------------------------

--
-- Table structure for table `tickets`
--

CREATE TABLE `tickets` (
  `id` int(11) NOT NULL,
  `ticket_type_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `subject` text DEFAULT NULL,
  `email` text DEFAULT NULL,
  `description` text DEFAULT NULL,
  `status` tinyint(4) NOT NULL DEFAULT 0,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_messages`
--

CREATE TABLE `ticket_messages` (
  `id` int(11) NOT NULL,
  `user_type` text DEFAULT NULL,
  `user_id` int(11) NOT NULL,
  `ticket_id` int(11) NOT NULL,
  `message` text DEFAULT NULL,
  `attachments` varchar(512) DEFAULT NULL,
  `last_updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `ticket_types`
--

CREATE TABLE `ticket_types` (
  `id` int(11) NOT NULL,
  `title` text DEFAULT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `time_slots`
--

CREATE TABLE `time_slots` (
  `id` int(11) NOT NULL,
  `title` varchar(256) NOT NULL,
  `from_time` time NOT NULL,
  `to_time` time NOT NULL,
  `last_order_time` time NOT NULL,
  `status` tinyint(4) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `transactions`
--

CREATE TABLE `transactions` (
  `id` int(11) NOT NULL,
  `transaction_type` varchar(16) NOT NULL,
  `user_id` int(11) NOT NULL,
  `order_id` varchar(128) DEFAULT NULL,
  `order_item_id` varchar(256) DEFAULT NULL,
  `type` varchar(64) DEFAULT NULL,
  `txn_id` varchar(256) DEFAULT NULL,
  `payu_txn_id` varchar(512) DEFAULT NULL,
  `amount` double NOT NULL,
  `status` varchar(12) DEFAULT NULL,
  `currency_code` varchar(5) DEFAULT NULL,
  `payer_email` varchar(64) DEFAULT NULL,
  `message` varchar(128) NOT NULL,
  `transaction_date` timestamp NULL DEFAULT current_timestamp(),
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `is_refund` tinyint(4) NOT NULL DEFAULT 0 COMMENT '0 = default , 1= refund'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `updates`
--

CREATE TABLE `updates` (
  `id` int(11) NOT NULL,
  `version` varchar(32) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `updates`
--

INSERT INTO `updates` (`id`, `version`) VALUES
(1, '1.0'),
(2, '1.1'),
(3, '1.1.1'),
(4, '1.1.2'),
(5, '2.0.0'),
(6, '2.0.1'),
(7, '2.0.2'),
(8, '2.0.3'),
(9, '2.0.3.1'),
(10, '2.0.3.2'),
(11, '2.0.4'),
(12, '2.0.5'),
(13, '2.0.5.1'),
(14, '2.0.5.2'),
(15, '2.1.0'),
(16, '2.1.0.1'),
(17, '2.1.1'),
(18, '2.2.0'),
(19, '3.0.0'),
(20, '3.0.1'),
(21, '3.0.2'),
(22, '3.0.3'),
(23, '3.0.4'),
(24, '3.0.4.1'),
(25, '3.0.5'),
(28, '3.0.6'),
(29, '4.0.0'),
(30, '4.0.1'),
(31, '4.0.2'),
(32, '4.0.3'),
(33, '4.0.4'),
(34, '4.0.5'),
(35, '4.0.5.1'),
(36, '4.0.6');

-- --------------------------------------------------------

--
-- Table structure for table `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `ip_address` varchar(45) DEFAULT NULL,
  `username` varchar(100) NOT NULL,
  `password` varchar(255) NOT NULL,
  `email` varchar(254) DEFAULT NULL,
  `mobile` varchar(20) DEFAULT NULL,
  `image` text DEFAULT NULL,
  `balance` double DEFAULT 0,
  `activation_selector` varchar(255) DEFAULT NULL,
  `activation_code` varchar(255) DEFAULT NULL,
  `forgotten_password_selector` varchar(255) DEFAULT NULL,
  `forgotten_password_code` varchar(255) DEFAULT NULL,
  `forgotten_password_time` int(11) DEFAULT NULL,
  `remember_selector` varchar(255) DEFAULT NULL,
  `remember_code` varchar(255) DEFAULT NULL,
  `created_on` int(11) UNSIGNED NOT NULL,
  `last_login` int(11) UNSIGNED DEFAULT NULL,
  `active` tinyint(1) UNSIGNED DEFAULT NULL,
  `company` varchar(100) DEFAULT NULL,
  `address` varchar(255) DEFAULT NULL,
  `bonus_type` varchar(30) DEFAULT 'percentage_per_order',
  `bonus` int(11) DEFAULT NULL,
  `cash_received` double(15,2) NOT NULL DEFAULT 0.00,
  `dob` varchar(16) DEFAULT NULL,
  `country_code` int(11) DEFAULT NULL,
  `city` text DEFAULT NULL,
  `area` text DEFAULT NULL,
  `street` text DEFAULT NULL,
  `pincode` varchar(32) DEFAULT NULL,
  `apikey` varchar(32) DEFAULT NULL,
  `referral_code` varchar(32) DEFAULT NULL,
  `friends_code` varchar(28) DEFAULT NULL,
  `fcm_id` text DEFAULT NULL,
  `latitude` varchar(64) DEFAULT NULL,
  `longitude` varchar(64) DEFAULT NULL,
  `type` varchar(256) NOT NULL DEFAULT 'phone',
  `driving_license` varchar(1024) DEFAULT 'NULL',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users`
--

INSERT INTO `users` (`id`, `ip_address`, `username`, `password`, `email`, `mobile`, `image`, `balance`, `activation_selector`, `activation_code`, `forgotten_password_selector`, `forgotten_password_code`, `forgotten_password_time`, `remember_selector`, `remember_code`, `created_on`, `last_login`, `active`, `company`, `address`, `bonus_type`, `bonus`, `cash_received`, `dob`, `country_code`, `city`, `area`, `street`, `pincode`, `apikey`, `referral_code`, `friends_code`, `fcm_id`, `latitude`, `longitude`, `type`, `driving_license`, `created_at`) VALUES
(1, '127.0.0.1', 'Administrator', '$2y$12$l/pK5YIBwfyNsNMMJ0fY5.X5UWK9JHM1beTk3Xm9GD73rdZxX0vC6', 'admin@gmail.com', '9876543210', NULL, 0, NULL, NULL, NULL, NULL, NULL, NULL, NULL, 1268889823, 1692964301, 1, 'ADMIN', NULL, 'percentage_per_order', NULL, 0.00, NULL, 91, '44', '138', NULL, NULL, NULL, NULL, NULL, 'dJXa6kH3Tzm6NBGwON5fhe:APA91bEFYijAUaRSRliyj0JXMTFm7SRGtXBFWoIOwH8f7VwkdG5xy0JsUpBH8sqO-_dGGZFxkP1oocj3kpKh-gOfkVDsaiqUYE_lunE7dlCqec9W-iL4kda6vO7qtOn7pFsAk6D2qLwz', NULL, NULL, 'phone', 'NULL', '2020-06-30 10:20:08');

-- --------------------------------------------------------

--
-- Table structure for table `users_groups`
--

CREATE TABLE `users_groups` (
  `id` int(11) UNSIGNED NOT NULL,
  `user_id` int(11) UNSIGNED NOT NULL,
  `group_id` mediumint(8) UNSIGNED NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `users_groups`
--

INSERT INTO `users_groups` (`id`, `user_id`, `group_id`) VALUES
(1, 1, 1);

-- --------------------------------------------------------

--
-- Table structure for table `user_fcm`
--

CREATE TABLE `user_fcm` (
  `id` int(11) NOT NULL,
  `fcm_id` varchar(1024) NOT NULL,
  `date_added` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

-- --------------------------------------------------------

--
-- Table structure for table `user_permissions`
--

CREATE TABLE `user_permissions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `role` int(11) NOT NULL,
  `permissions` mediumtext DEFAULT NULL,
  `created_by` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data for table `user_permissions`
--

INSERT INTO `user_permissions` (`id`, `user_id`, `role`, `permissions`, `created_by`) VALUES
(1, 1, 0, NULL, '2020-11-18 04:44:05');

-- --------------------------------------------------------

--
-- Table structure for table `wallet_transactions`
--

CREATE TABLE `wallet_transactions` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` varchar(8) NOT NULL COMMENT 'credit | debit',
  `amount` double NOT NULL,
  `message` varchar(512) NOT NULL,
  `status` tinyint(4) NOT NULL,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp(),
  `last_updated` timestamp NULL DEFAULT NULL ON UPDATE current_timestamp()
) ENGINE=MyISAM DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Table structure for table `zipcodes`
--

CREATE TABLE `zipcodes` (
  `id` int(11) NOT NULL,
  `zipcode` varchar(512) DEFAULT NULL,
  `city_id` int(11) NOT NULL,
  `minimum_free_delivery_order_amount` double NOT NULL DEFAULT 0,
  `delivery_charges` double DEFAULT 0,
  `date_created` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `addresses`
--
ALTER TABLE `addresses`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `areas`
--
ALTER TABLE `areas`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attributes`
--
ALTER TABLE `attributes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `attribute_set_id` (`attribute_set_id`);

--
-- Indexes for table `attribute_set`
--
ALTER TABLE `attribute_set`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `attribute_values`
--
ALTER TABLE `attribute_values`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `brands`
--
ALTER TABLE `brands`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_variant_id` (`product_variant_id`);

--
-- Indexes for table `categories`
--
ALTER TABLE `categories`
  ADD PRIMARY KEY (`id`),
  ADD KEY `parent_id` (`parent_id`);

--
-- Indexes for table `cities`
--
ALTER TABLE `cities`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `client_api_keys`
--
ALTER TABLE `client_api_keys`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `countries`
--
ALTER TABLE `countries`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `custom_notifications`
--
ALTER TABLE `custom_notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `delivery_boy_notifications`
--
ALTER TABLE `delivery_boy_notifications`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delivery_boy_id` (`delivery_boy_id`),
  ADD KEY `order_id` (`order_id`);

--
-- Indexes for table `digital_orders_mails`
--
ALTER TABLE `digital_orders_mails`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `faqs`
--
ALTER TABLE `faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `favorites`
--
ALTER TABLE `favorites`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `flash_sale`
--
ALTER TABLE `flash_sale`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `fund_transfers`
--
ALTER TABLE `fund_transfers`
  ADD PRIMARY KEY (`id`),
  ADD KEY `delivery_boy_id` (`delivery_boy_id`);

--
-- Indexes for table `groups`
--
ALTER TABLE `groups`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `languages`
--
ALTER TABLE `languages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `login_attempts`
--
ALTER TABLE `login_attempts`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `media`
--
ALTER TABLE `media`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `notifications`
--
ALTER TABLE `notifications`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offers`
--
ALTER TABLE `offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `offer_sliders`
--
ALTER TABLE `offer_sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `delivery_boy_id` (`delivery_boy_id`);

--
-- Indexes for table `order_bank_transfer`
--
ALTER TABLE `order_bank_transfer`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `order_items`
--
ALTER TABLE `order_items`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `product_variant_id` (`product_variant_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `order_tracking`
--
ALTER TABLE `order_tracking`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `payment_requests`
--
ALTER TABLE `payment_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `pickup_locations`
--
ALTER TABLE `pickup_locations`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `popup_offers`
--
ALTER TABLE `popup_offers`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `products`
--
ALTER TABLE `products`
  ADD PRIMARY KEY (`id`),
  ADD KEY `category_id` (`category_id`);

--
-- Indexes for table `product_attributes`
--
ALTER TABLE `product_attributes`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_faqs`
--
ALTER TABLE `product_faqs`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `product_rating`
--
ALTER TABLE `product_rating`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `product_variants`
--
ALTER TABLE `product_variants`
  ADD PRIMARY KEY (`id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `promo_codes`
--
ALTER TABLE `promo_codes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `return_requests`
--
ALTER TABLE `return_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `product_id` (`product_id`);

--
-- Indexes for table `sections`
--
ALTER TABLE `sections`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `settings`
--
ALTER TABLE `settings`
  ADD PRIMARY KEY (`id`),
  ADD KEY `variable` (`variable`);

--
-- Indexes for table `sliders`
--
ALTER TABLE `sliders`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `system_notification`
--
ALTER TABLE `system_notification`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `taxes`
--
ALTER TABLE `taxes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `themes`
--
ALTER TABLE `themes`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `tickets`
--
ALTER TABLE `tickets`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_messages`
--
ALTER TABLE `ticket_messages`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `ticket_types`
--
ALTER TABLE `ticket_types`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `time_slots`
--
ALTER TABLE `time_slots`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `transactions`
--
ALTER TABLE `transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `order_id` (`order_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `updates`
--
ALTER TABLE `updates`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD KEY `mobile` (`mobile`),
  ADD KEY `email` (`email`);

--
-- Indexes for table `users_groups`
--
ALTER TABLE `users_groups`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `uc_users_groups` (`user_id`,`group_id`),
  ADD KEY `fk_users_groups_users1_idx` (`user_id`),
  ADD KEY `fk_users_groups_groups1_idx` (`group_id`);

--
-- Indexes for table `user_fcm`
--
ALTER TABLE `user_fcm`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user_permissions`
--
ALTER TABLE `user_permissions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `zipcodes`
--
ALTER TABLE `zipcodes`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `addresses`
--
ALTER TABLE `addresses`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `areas`
--
ALTER TABLE `areas`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attributes`
--
ALTER TABLE `attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attribute_set`
--
ALTER TABLE `attribute_set`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `attribute_values`
--
ALTER TABLE `attribute_values`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `brands`
--
ALTER TABLE `brands`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `categories`
--
ALTER TABLE `categories`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=111;

--
-- AUTO_INCREMENT for table `cities`
--
ALTER TABLE `cities`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `client_api_keys`
--
ALTER TABLE `client_api_keys`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `countries`
--
ALTER TABLE `countries`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `custom_notifications`
--
ALTER TABLE `custom_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `delivery_boy_notifications`
--
ALTER TABLE `delivery_boy_notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `digital_orders_mails`
--
ALTER TABLE `digital_orders_mails`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `faqs`
--
ALTER TABLE `faqs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `favorites`
--
ALTER TABLE `favorites`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `flash_sale`
--
ALTER TABLE `flash_sale`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `fund_transfers`
--
ALTER TABLE `fund_transfers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `groups`
--
ALTER TABLE `groups`
  MODIFY `id` mediumint(8) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `languages`
--
ALTER TABLE `languages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `login_attempts`
--
ALTER TABLE `login_attempts`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `media`
--
ALTER TABLE `media`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=88;

--
-- AUTO_INCREMENT for table `notifications`
--
ALTER TABLE `notifications`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offers`
--
ALTER TABLE `offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `offer_sliders`
--
ALTER TABLE `offer_sliders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_bank_transfer`
--
ALTER TABLE `order_bank_transfer`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_items`
--
ALTER TABLE `order_items`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `order_tracking`
--
ALTER TABLE `order_tracking`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `payment_requests`
--
ALTER TABLE `payment_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `pickup_locations`
--
ALTER TABLE `pickup_locations`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `popup_offers`
--
ALTER TABLE `popup_offers`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `products`
--
ALTER TABLE `products`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_attributes`
--
ALTER TABLE `product_attributes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_faqs`
--
ALTER TABLE `product_faqs`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_rating`
--
ALTER TABLE `product_rating`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `product_variants`
--
ALTER TABLE `product_variants`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `promo_codes`
--
ALTER TABLE `promo_codes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `return_requests`
--
ALTER TABLE `return_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `sections`
--
ALTER TABLE `sections`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `settings`
--
ALTER TABLE `settings`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=25;

--
-- AUTO_INCREMENT for table `sliders`
--
ALTER TABLE `sliders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `system_notification`
--
ALTER TABLE `system_notification`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `taxes`
--
ALTER TABLE `taxes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `themes`
--
ALTER TABLE `themes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- AUTO_INCREMENT for table `tickets`
--
ALTER TABLE `tickets`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_messages`
--
ALTER TABLE `ticket_messages`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ticket_types`
--
ALTER TABLE `ticket_types`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `time_slots`
--
ALTER TABLE `time_slots`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `transactions`
--
ALTER TABLE `transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `updates`
--
ALTER TABLE `updates`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=37;

--
-- AUTO_INCREMENT for table `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=156;

--
-- AUTO_INCREMENT for table `users_groups`
--
ALTER TABLE `users_groups`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=143;

--
-- AUTO_INCREMENT for table `user_fcm`
--
ALTER TABLE `user_fcm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `user_permissions`
--
ALTER TABLE `user_permissions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT for table `wallet_transactions`
--
ALTER TABLE `wallet_transactions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `zipcodes`
--
ALTER TABLE `zipcodes`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
