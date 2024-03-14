<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Migration_countries extends CI_Migration
{

    public function up()
    {
        $sql = file_get_contents(base_url('countries.sql'));
        $explode = explode(';', $sql);
        for ($i = 0; $i < count($explode) - 1; $i++) {
            $this->db->query($explode[$i]);
        }

        /* alter field in promo_codes table */
        $fields = array(
            'list_promocode' => array(
                'type'           => 'TINYINT',
                'constraint'     => '4',
                'NULL'           => TRUE,
                'default'        => 1,
                'after'          => 'is_cashback'
            )
        );
        $this->dbforge->add_column('promo_codes', $fields);
    }
    public function down()
    {
        $this->dbforge->drop_table('countries');
        $this->dbforge->drop_column('promo_codes', 'list_promocode');
    }
}
