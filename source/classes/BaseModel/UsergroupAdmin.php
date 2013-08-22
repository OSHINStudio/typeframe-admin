<?php
/**
 * Base model for the usergroup_admin table
 * This class was automatically generated from the database. Instead of
 * modifying it directly, extend it to add new functionality.
 */
class BaseModel_UsergroupAdmin extends Dbi_Model {
	public function __construct() {
		parent::__construct();
		$this->name = 'usergroup_admin';
		$this->prefix = DBI_PREFIX;
		$this->addField('usergroupid', new Dbi_Field('int', array('10', 'unsigned'), '0', false));
		$this->addField('application', new Dbi_Field('varchar', array('32'), '', false));
		$this->addIndex('primary', array(
			'usergroupid', 'application'
		), 'unique');
	}
}
