<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Migration_custom_notification extends CI_Migration
{
    public function up()
    {
        /* adding new table custom_notification */
        $this->dbforge->add_field([
            'id' => [
                'type'           => 'INT',
                'constraint'     => '11',
                'auto_increment' => TRUE,
                'NULL'           => TRUE
            ],
            'title' => [
                'type'           => 'VARCHAR',
                'constraint'     => '128',
                'NULL'           => TRUE
            ],
            'message' => [
                'type'           => 'VARCHAR',
                'constraint'     => '512',
                'NULL'           => TRUE
            ],
            'type' => [
                'type'           => 'VARCHAR',
                'constraint'     => '64',
                'NULL'           => TRUE
            ],
            'date_sent TIMESTAMP default CURRENT_TIMESTAMP',
        ]);
        $this->dbforge->add_key('id', TRUE);
        $this->dbforge->create_table('custom_notifications');

        $fields = array(
            'order_item_id' => array(
                'type'           => 'INT',
                'constraint'     => '11',
                'NULL'           => TRUE,
                'after'          => 'order_id'
            ),
            'is_refund' => array(
                'type'           => 'TINYINT',
                'constraint'     => '4',
                'NULL'           => TRUE,
                'default'        => '0',
                'after'          => 'date_created'
            )
        );
        $this->dbforge->add_column('transactions', $fields);
    }
    public function down()
    {
        $this->dbforge->drop_table('custom_notifications');
        $this->dbforge->drop_column('transactions', 'order_item_id');
        $this->dbforge->drop_column('transactions', 'is_refund');
        
    }

}
?>