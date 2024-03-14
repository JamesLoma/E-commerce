<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Migration_address extends CI_Migration
{

    public function up()
    {
        /* adding new column in users status */

    // ALTER TABLE `zipcodes` ADD `city_id` INT NOT NULL AFTER `zipcode`;
    // ALTER TABLE `zipcodes` ADD `minimum_free_delivery_order_amount` DOUBLE NOT NULL DEFAULT '0' AFTER `city_id`;
    // ALTER TABLE `zipcodes` ADD `delivery_charges` DOUBLE NULL DEFAULT '0' AFTER `minimum_free_delivery_order_amount`;

        $fields = array(
            'city_id' => array(
                'type'           => 'INT',
                'constraint'     => '11',
                'NULL'           => FALSE,
                'after'          => 'zipcode'
            ),
            'minimum_free_delivery_order_amount' => array(
                'type'           => 'DOUBLE',
                'NULL'           => FALSE,
                'default'        => '0',
                'after'          => 'city_id'
            ),
            'delivery_charges' => array(
                'type'           => 'DOUBLE',
                'NULL'           => TRUE,
                'default'        => '0',
                'after'          => 'minimum_free_delivery_order_amount'
            ),
        );
        $this->dbforge->add_column('zipcodes', $fields);


    // ALTER TABLE `addresses` ADD `system_pincode` TINYINT NOT NULL DEFAULT '1' AFTER `pincode`;

        $fields = array(
            'system_pincode' => array(
                'type'           => 'TINYINT',
                'constraint'     => '4',
                'NULL'           => FALSE,
                'default'        => '1',
                'after'          => 'pincode'
            ),
        );
        $this->dbforge->add_column('addresses', $fields);

    }
    public function down()
    {
        $this->dbforge->drop_column('city_id', 'zipcodes');
        $this->dbforge->drop_column('minimum_free_delivery_order_amount', 'zipcodes');
        $this->dbforge->drop_column('delivery_charges', 'zipcodes');
        $this->dbforge->drop_column('system_pincode', 'addresses');
    }
}
