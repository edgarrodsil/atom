<?php


/**
 * This class defines the structure of the 'aip' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    lib.model.map
 */
class AipTableMap extends TableMap {

	/**
	 * The (dot-path) name of this class
	 */
	const CLASS_NAME = 'lib.model.map.AipTableMap';

	/**
	 * Initialize the table attributes, columns and validators
	 * Relations are not initialized by this method since they are lazy loaded
	 *
	 * @return     void
	 * @throws     PropelException
	 */
	public function initialize()
	{
	  // attributes
		$this->setName('aip');
		$this->setPhpName('aip');
		$this->setClassname('QubitAip');
		$this->setPackage('lib.model');
		$this->setUseIdGenerator(false);
		// columns
		$this->addForeignPrimaryKey('ID', 'id', 'INTEGER' , 'object', 'ID', true, null, null);
		$this->addForeignKey('INFORMATION_OBJECT_ID', 'informationObjectId', 'INTEGER', 'information_object', 'ID', false, null, null);
		$this->addForeignKey('AIP_TYPE_ID', 'aipTypeId', 'INTEGER', 'term', 'ID', false, null, null);
		$this->addColumn('OBJECT_UUID', 'objectUuid', 'VARCHAR', false, 255, null);
		$this->addColumn('AIP_UUID', 'aipUuid', 'VARCHAR', false, 255, null);
		// validators
	} // initialize()

	/**
	 * Build the RelationMap objects for this table relationships
	 */
	public function buildRelations()
	{
    $this->addRelation('object', 'object', RelationMap::MANY_TO_ONE, array('id' => 'id', ), 'CASCADE', null);
    $this->addRelation('informationObject', 'informationObject', RelationMap::MANY_TO_ONE, array('information_object_id' => 'id', ), null, null);
    $this->addRelation('term', 'term', RelationMap::MANY_TO_ONE, array('aip_type_id' => 'id', ), 'SET NULL', null);
	} // buildRelations()

} // AipTableMap
