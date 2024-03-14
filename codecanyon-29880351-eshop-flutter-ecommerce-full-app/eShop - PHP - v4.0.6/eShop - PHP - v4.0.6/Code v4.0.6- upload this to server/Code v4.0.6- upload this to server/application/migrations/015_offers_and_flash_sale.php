<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Migration_offers_and_flash_sale extends CI_Migration
{
    public function up()
    {
        /* adding new table custom_notification */
        $this->dbforge->add_field([
            'id' => [
                'type'           => 'INT',
                'constraint'     => '11',
                'auto_increment' => TRUE,
                'NULL'           => FALSE
            ],
            'name' => [
                'type'           => 'VARCHAR',
                'constraint'     => '256',
                'NULL'           => TRUE
            ],
            'slug' => [
                'type'           => 'VARCHAR',
                'constraint'     => '256',
                'NULL'           => TRUE
            ],
            'image' => [
                'type'           => 'TEXT',
            ],
            'status' => [
                'type'           => 'TINYINT',
                'constraint'     => '4',
                'NULL'           => TRUE,
            ],
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('brands');

        $this->dbforge->add_field([
            'id' => [
                'type'           => 'INT',
                'constraint'     => '11',
                'auto_increment' => TRUE,
                'NULL'           => FALSE
            ],
            'style' => [
                'type'           => 'VARCHAR',
                'constraint'     => '256',
                'NULL'           => FALSE
            ],
            'offer_ids' => [
                'type'           => 'TEXT',
                'NULL'           => FALSE
            ],
            'date_added TIMESTAMP default CURRENT_TIMESTAMP',
           
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('offer_sliders');

        $this->dbforge->add_field([
            'id' => [
                'type'           => 'INT',
                'constraint'     => '11',
                'auto_increment' => TRUE,
                'NULL'           => FALSE
            ],
            'title' => [
                'type'           => 'VARCHAR',
                'constraint'     => '512',
                'NULL'           => TRUE
            ],
            'slug' => [
                'type'           => 'VARCHAR',
                'constraint'     => '512',
                'NULL'           => TRUE
            ],
            'short_description' => [
                'type'           => 'VARCHAR',
                'constraint'     => '512',
                'NULL'           => TRUE
            ],
            'discount' => [
                'type'           => 'INT',
                'constraint'     => '11',
                'NULL'           => TRUE,
            ],
            'product_ids' => [
                'type'           => 'VARCHAR',
                'constraint'     => '1024',
                'NULL'           => TRUE,
            ],
            'image' => [
                'type'           => 'VARCHAR',
                'constraint'     => '2048',
                'NULL'           => TRUE,
            ],
            'start_date' => [
                'type'           => 'DATETIME',
                'NULL'           => TRUE,
            ],
            'end_date' => [
                'type'           => 'DATETIME',
                'NULL'           => TRUE,
            ],
            'status' => [
                'type'           => 'TINYINT',
                'constraint'     => '4',
                'NULL'           => TRUE,
            ],
            'date_added TIMESTAMP default CURRENT_TIMESTAMP',
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('flash_sale');


        $fields = array(
            'brand' => array(
                'type'           => 'VARCHAR',
                'constraint'     => '256',
                'NULL'           => TRUE,
                'after'          => 'made_in'
            ),
            'is_on_sale' => [
                'type'           => 'TINYINT',
                'constraint'     => '4',
                'default'        => 0,
                'after'          => 'date_added'
            ],
            'sale_discount' => [
                'type'           => 'INT',
                'constraint'     => '11',
                'default'        => 0,
                'after'          => 'is_on_sale'
            ],
            'sale_start_date' => [
                'type'           => 'DATETIME',
                'NULL'           => TRUE,
                'after'          => 'sale_discount'
            ],
            'sale_end_date' => [
                'type'           => 'DATETIME',
                'NULL'           => TRUE,
                'after'          => 'sale_start_date'
            ],
        );
        $this->dbforge->add_column('products', $fields);

      

        $fields = array(
            'min_discount' => array(
                'type'           => 'INT ',
                'constraint'     => '11',
                'NULL'           => TRUE,
                'default'        => 0,
                'after'          => 'type_id'
            ),
            'max_discount' => array(
                'type'           => 'INT ',
                'constraint'     => '11',
                'NULL'           => TRUE,
                'default'        => 0,
                'after'          => 'min_discount'
            ),
            
        );
        $this->dbforge->add_column('offers', $fields);
    }
    public function down()
    {
        $this->dbforge->drop_table('brands');
        $this->dbforge->drop_table('offer_sliders');
        $this->dbforge->drop_table('flash_sale');
        $this->dbforge->drop_column('products', 'brand');
        $this->dbforge->drop_column('flash_sale', 'image');
        $this->dbforge->drop_column('min_discount', 'offers');
        $this->dbforge->drop_column('max_discount', 'offer_sliders');
        
    }

}
?>