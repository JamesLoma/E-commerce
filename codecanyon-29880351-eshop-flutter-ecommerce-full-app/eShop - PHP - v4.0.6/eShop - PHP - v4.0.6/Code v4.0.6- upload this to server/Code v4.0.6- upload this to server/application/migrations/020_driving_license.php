<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Migration_driving_license extends CI_Migration
{
    public function up()
    {

       /* adding new table user_fcm */
       $this->dbforge->add_field([
        'id' => [
            'type'           => 'INT',
            'constraint'     => '11',
            'auto_increment' => TRUE,
            'NULL'           => FALSE
        ],
        'fcm_id' => [
            'type'           => 'VARCHAR',
            'constraint'     => '1024',
            'NULL'           => FALSE
        ],
        'date_added TIMESTAMP default CURRENT_TIMESTAMP',
    ]);
    $this->dbforge->add_key('id', TRUE);
    $this->dbforge->create_table('user_fcm');

    $fields = array(
        'driving_license' => array(
            'type'           => 'VARCHAR',
            'constraint'     => '1024',
            'NULL'           => TRUE,
            'default'        => 'NULL',
            'after'          => 'type'
        ),
    );
    $this->dbforge->add_column('users', $fields);

    $fields = array(
        'active_status' => array(
            'type'      => 'VARCHAR',
            'constraint' => '1024',
        ),
    );
    $this->dbforge->modify_column('order_items', $fields);
    $fields = array(
        'active_status' => array(
            'type'      => 'VARCHAR',
            'constraint' => '1024',
        ),
    );
    $this->dbforge->modify_column('orders', $fields);

    }

    public function down()
    {
         $this->dbforge->drop_table('user_fcm');
        $this->dbforge->drop_column('users', 'driving_license');
        $this->dbforge->drop_column('order_items', 'active_status');
        $this->dbforge->drop_column('orders', 'active_status');

    }
}
