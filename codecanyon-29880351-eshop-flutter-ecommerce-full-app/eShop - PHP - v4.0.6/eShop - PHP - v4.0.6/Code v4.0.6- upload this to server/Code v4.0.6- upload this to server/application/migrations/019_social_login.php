<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Migration_social_login extends CI_Migration
{
    public function up()
    {

        $fields = array(
            'type' => array(
                'type'           => 'VARCHAR',
                'constraint'     => '256',
                'NULL'           => FALSE,
                'default'        => 'phone',
                'after'          => 'longitude'
            ),


        );
        $this->dbforge->add_column('users', $fields);
    }

    public function down()
    {
        $this->dbforge->drop_column('users', 'type');
    }
}
