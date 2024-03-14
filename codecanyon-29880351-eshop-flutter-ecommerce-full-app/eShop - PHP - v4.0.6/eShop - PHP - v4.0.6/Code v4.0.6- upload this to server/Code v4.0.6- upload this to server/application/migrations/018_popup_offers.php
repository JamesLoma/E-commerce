<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Migration_popup_offers extends CI_Migration
{
    public function up()
    {
        /* adding new table digital_orders_mails */
        $this->dbforge->add_field([
            'id' => [
                'type'           => 'INT',
                'constraint'     => '11',
                'auto_increment' => TRUE,
                'NULL'           => FALSE
            ],
            'type' => [
                'type'           => 'VARCHAR',
                'constraint'     => '256',
                'NULL'           => TRUE
            ],
            'type_id' => [
                'type'           => 'INT',
                'constraint'     => '11',
                'NULL'           => TRUE
            ],
            'min_discount' => [
                'type'           => 'INT',
                'constraint'     => '11',
                'NULL'           => TRUE,
                'default'        => '0'
            ],
            'max_discount' => [
                'type'           => 'INT',
                'constraint'     => '11',
                'NULL'           => TRUE,
                'default'        => '0'
            ],
            'image' => [
                'type'           => 'VARCHAR',
                'constraint'     => '256',
                'NULL'           => TRUE
            ],
            'link' => [
                'type'           => 'VARCHAR',
                'constraint'     => '256',
                'NULL'           => TRUE
            ],
            'status' => [
                'type'           => 'INT',
                'constraint'     => '11',
                'NULL'           => FALSE,
                'default'        => '0'
            ],
            'date_added TIMESTAMP default CURRENT_TIMESTAMP',
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('popup_offers');

        $fields = array(
            'is_specific_users' => array(
                'type'           => 'INT',
                'constraint'     => '11',
                'NULL'           => FALSE,
                'default'        => '0',
                'after'          => 'list_promocode'
            ),
            'users_id' => array(
                'type'           => 'VARCHAR',
                'constraint'     => '256',
                'NULL'           => FALSE,
                'after'          => 'is_specific_users'
            ),


        );
        $this->dbforge->add_column('promo_codes', $fields);

        $fields = array(
            'link' => array(
                'type'           => 'VARCHAR',
                'constraint'     => '512',
                'NULL'           => TRUE,
                'default'        => 'NULL',
                'after'          => 'image'
            ),
        );
        $this->dbforge->add_column('sliders', $fields);

        $fields = array(
            'link' => array(
                'type'           => 'VARCHAR',
                'constraint'     => '512',
                'NULL'           => TRUE,
                'default'        => 'NULL',
                'after'          => 'image'
            ),
        );
        $this->dbforge->add_column('notifications', $fields);

        $fields = array(
            'link' => array(
                'type'           => 'VARCHAR',
                'constraint'     => '512',
                'NULL'           => TRUE,
                'default'        => '0',
                'after'          => 'image'
            ),
        );
        $this->dbforge->add_column('offers', $fields);
    }

    public function down()
    {

        $this->dbforge->drop_table('popup_offers');
        $this->dbforge->drop_column('promo_codes', 'is_specific_users');
        $this->dbforge->drop_column('promo_codes', 'users_id');
        $this->dbforge->drop_column('sliders', 'link');
        $this->dbforge->drop_column('notifications', 'link');
        $this->dbforge->drop_column('offers', 'link');
    }
}
