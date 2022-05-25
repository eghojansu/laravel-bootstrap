<?php

namespace Database\Seeders;

use App\Extended\Seeder;
use App\Models\Acperm;
use App\Models\Acrole;
use App\Models\Acrolep;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Acrole::upsert(array(
            array('roleid' => 'su'),
        ), array('roleid'));
        Acperm::upsert(array(
            array('permid' => Acperm::PERM_ADM),
        ), array('permid'));
        Acrolep::upsert(array(
            array('roleid' => 'su', 'permid' => Acperm::PERM_ADM),
        ), array('permid', 'roleid'));
    }
}
