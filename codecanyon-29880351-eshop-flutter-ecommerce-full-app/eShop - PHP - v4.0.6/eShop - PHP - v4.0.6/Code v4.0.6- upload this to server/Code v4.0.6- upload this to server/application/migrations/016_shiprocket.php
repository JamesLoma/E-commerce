<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Migration_shiprocket extends CI_Migration
{
    public function up()
    {
        // adding fields in address table 

        $fields = array(
            'city' => array(
                'type'           => 'VARCHAR',
                'constraint'     => '256',
                'NULL'           => TRUE,
                'after'          => 'city_id'
            ),
            'area' => array(
                'type'           => 'VARCHAR',
                'constraint'     => '256',
                'NULL'           => TRUE,
                'after'          => 'city'
            ),

        );
        $this->dbforge->add_column('addresses', $fields);

        // adding field in offer slider table

        $fields = array(
            'row_order' => array(
                'type'           => 'INT',
                'constraint'     => '11',
                'default'        => 0,
                'after'          => 'offer_ids'
            ),

        );
        $this->dbforge->add_column('offer_sliders', $fields);

        //adding fields in products table

        $fields = array(
            'shipping_method' => array(
                'type'           => 'INT ',
                'constraint'     => '11',
                'NULL'           => TRUE,
                'default'        => NULL,
                'after'          => 'deliverable_zipcodes'
            ),
            'pickup_location' => array(
                'type'           => 'INT ',
                'constraint'     => '512',
                'NULL'           => TRUE,
                'default'        => NULL,
                'after'          => 'shipping_method'
            ),

        );
        $this->dbforge->add_column('products', $fields);


        //adding fields in product variants table 

        $fields = array(
            'weight' => array(
                'type'           => 'FLOAT ',
                'NULL'           => FALSE,
                'default'        => NULL,
                'after'          => 'stock'
            ),
            'height' => array(
                'type'           => 'FLOAT ',
                'NULL'           => FALSE,
                'after'          => 'weight'
            ),
            'breadth' => array(
                'type'           => 'FLOAT ',
                'NULL'           => FALSE,
                'after'          => 'height'
            ),
            'length' => array(
                'type'           => 'FLOAT ',
                'NULL'           => FALSE,
                'after'          => 'breadth'
            )
        );
        $this->dbforge->add_column('product_variants', $fields);


        //adding fields in order_tracking table 


        $fields = array(
            'order_item_id' => array(
                'type'           => 'mediumtext ',
                'NULL'           => FALSE,
                'after'          => 'order_id'
            ),
            'shiprocket_order_id' => array(
                'type'           => 'INT ',
                'constraint'     => '11',
                'NULL'           => TRUE,
                'after'          => 'order_item_id'
            ),
            'shipment_id' => array(
                'type'           => 'INT ',
                'constraint'     => '11',
                'NULL'           => TRUE,
                'after'          => 'shiprocket_order_id'
            ),
            'courier_company_id' => array(
                'type'           => 'INT ',
                'constraint'     => '11',
                'NULL'           => TRUE,
                'default'        => NULL,
                'after'          => 'shipment_id'
            ),
            'awb_code' => array(
                'type'           => 'VARCHAR',
                'constraint'     => '256',
                'NULL'           => TRUE,
                'default'        => NULL,
                'after'          => 'courier_company_id'
            ),
            'pickup_status' => array(
                'type'           => 'INT ',
                'constraint'     => '11',
                'NULL'           => FALSE,
                'after'          => 'awb_code'
            ),
            'pickup_scheduled_date' => array(
                'type'           => 'VARCHAR',
                'constraint'     => '256',
                'NULL'           => FALSE,
                'after'          => 'pickup_status'
            ),
            'pickup_token_number' => array(
                'type'           => 'VARCHAR',
                'constraint'     => '256',
                'NULL'           => FALSE,
                'after'          => 'pickup_scheduled_date'
            ),
            'status' => array(
                'type'           => 'INT ',
                'constraint'     => '11',
                'NULL'           => FALSE,
                'after'          => 'pickup_token_number'
            ),
            'others' => array(
                'type'           => 'VARCHAR',
                'constraint'     => '256',
                'after'          => 'status'
            ),
            'pickup_generated_date' => array(
                'type'           => 'VARCHAR',
                'constraint'     => '256',
                'NULL'           => FALSE,
                'after'          => 'others'
            ),
            'data' => array(
                'type'           => 'VARCHAR',
                'constraint'     => '256',
                'NULL'           => FALSE,
                'after'          => 'pickup_generated_date'
            ),
            'date' => array(
                'type'           => 'VARCHAR',
                'constraint'     => '256',
                'NULL'           => FALSE,
                'after'          => 'data'
            ),
            'manifest_url' => array(
                'type'           => 'VARCHAR',
                'constraint'     => '256',
                'NULL'           => FALSE,
                'after'          => 'date'
            ),
            'label_url' => array(
                'type'           => 'VARCHAR',
                'constraint'     => '256',
                'NULL'           => FALSE,
                'after'          => 'manifest_url'
            ),
            'invoice_url' => array(
                'type'           => 'VARCHAR',
                'constraint'     => '256',
                'NULL'           => FALSE,
                'after'          => 'label_url'
            ),
            'is_canceled' => array(
                'type'           => 'INT ',
                'constraint'     => '11',
                'after'          => 'date'
            ),

        );
        $this->dbforge->add_column('order_tracking', $fields);


        // create new table pickup_locations


        $this->dbforge->add_field([
            'id' => array(
                'type'           => 'INT',
                'constraint'     => '11',
                'auto_increment' => TRUE,
                'NULL'           => FALSE
            ),
            'pickup_location' => array(
                'type'           => 'VARCHAR',
                'constraint'     => '512',
                'NULL'           => FALSE
            ),
            'name' => array(
                'type'           => 'VARCHAR',
                'constraint'     => '512',
                'NULL'           => FALSE
            ),
            'email' => array(
                'type'           => 'VARCHAR',
                'constraint'     => '512',
                'NULL'           => FALSE
            ),
            'phone' => array(
                'type'           => 'VARCHAR',
                'constraint'     => '28',
                'NULL'           => FALSE
            ),
            'address' => array(
                'type'           => 'TEXT',
                'NULL'           => FALSE
            ),
            'address_2' => array(
                'type'           => 'TEXT',
                'NULL'           => FALSE
            ),
            'city' => array(
                'type'           => 'VARCHAR',
                'constraint'     => '56',
                'NULL'           => FALSE
            ),
            'state' => array(
                'type'           => 'VARCHAR',
                'constraint'     => '56',
                'NULL'           => FALSE
            ),
            'country' => array(
                'type'           => 'VARCHAR',
                'constraint'     => '56',
                'NULL'           => FALSE
            ),
            'pin_code' => array(
                'type'           => 'VARCHAR',
                'constraint'     => '56',
                'NULL'           => FALSE
            ),
            'latitude' => array(
                'type'           => 'VARCHAR',
                'constraint'     => '128',
                'NULL'           => TRUE,
                'default'        => NULL,
            ),
            'longitude' => array(
                'type'           => 'VARCHAR',
                'constraint'     => '128',
                'NULL'           => TRUE,
                'default'        => NULL,
            ),
            'status' => array(
                'type'           => 'tinyint',
                'constraint'     => '4',
                'NULL'           => FALSE,
                'default'        => 0,
            ),
            'date_created TIMESTAMP default CURRENT_TIMESTAMP',

        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('pickup_locations');
    }

    public function down()
    {
        //drop table pickup locations
        $this->dbforge->drop_table('pickup_locations');

        // drop colums from products table

        $this->dbforge->drop_column('products', 'shipping_method');
        $this->dbforge->drop_column('products', 'pickup_location');

        // drop colums from address table

        $this->dbforge->drop_column('addresses', 'city');
        $this->dbforge->drop_column('addresses', 'area');

        // drop colums from product varinats table

        $this->dbforge->drop_column('product_variants', 'weight');
        $this->dbforge->drop_column('product_variants', 'height');
        $this->dbforge->drop_column('product_variants', 'breadth');
        $this->dbforge->drop_column('product_variants', 'length');

        // drop colums from order tracking

        $this->dbforge->drop_column('order_tracking', 'order_item_id');
        $this->dbforge->drop_column('order_tracking', 'shiprocket_order_id');
        $this->dbforge->drop_column('order_tracking', 'shipment_id');
        $this->dbforge->drop_column('order_tracking', 'courier_company_id');
        $this->dbforge->drop_column('order_tracking', 'awb_code');
        $this->dbforge->drop_column('order_tracking', 'pickup_status');
        $this->dbforge->drop_column('order_tracking', 'pickup_scheduled_date');
        $this->dbforge->drop_column('order_tracking', 'pickup_token_number');
        $this->dbforge->drop_column('order_tracking', 'status');
        $this->dbforge->drop_column('order_tracking', 'others');
        $this->dbforge->drop_column('order_tracking', 'pickup_generated_date');
        $this->dbforge->drop_column('order_tracking', 'data');
        $this->dbforge->drop_column('order_tracking', 'date');
        $this->dbforge->drop_column('order_tracking', 'manifest_url');
        $this->dbforge->drop_column('order_tracking', 'label_url');
        $this->dbforge->drop_column('order_tracking', 'invoice_url');
        $this->dbforge->drop_column('order_tracking', 'is_canceled');
    }
}
