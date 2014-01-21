<?php

abstract class BaseAip extends QubitObject implements ArrayAccess
{
  const
    DATABASE_NAME = 'propel',

    TABLE_NAME = 'aip',

    ID = 'aip.ID',
    INFORMATION_OBJECT_ID = 'aip.INFORMATION_OBJECT_ID',
    AIP_TYPE_ID = 'aip.AIP_TYPE_ID',
    OBJECT_UUID = 'aip.OBJECT_UUID',
    AIP_UUID = 'aip.AIP_UUID';

  public static function addSelectColumns(Criteria $criteria)
  {
    parent::addSelectColumns($criteria);

    $criteria->addJoin(QubitAip::ID, QubitObject::ID);

    $criteria->addSelectColumn(QubitAip::ID);
    $criteria->addSelectColumn(QubitAip::INFORMATION_OBJECT_ID);
    $criteria->addSelectColumn(QubitAip::AIP_TYPE_ID);
    $criteria->addSelectColumn(QubitAip::OBJECT_UUID);
    $criteria->addSelectColumn(QubitAip::AIP_UUID);

    return $criteria;
  }

  public static function get(Criteria $criteria, array $options = array())
  {
    if (!isset($options['connection']))
    {
      $options['connection'] = Propel::getConnection(QubitAip::DATABASE_NAME);
    }

    self::addSelectColumns($criteria);

    return QubitQuery::createFromCriteria($criteria, 'QubitAip', $options);
  }

  public static function getAll(array $options = array())
  {
    return self::get(new Criteria, $options);
  }

  public static function getOne(Criteria $criteria, array $options = array())
  {
    $criteria->setLimit(1);

    return self::get($criteria, $options)->__get(0, array('defaultValue' => null));
  }

  public static function getById($id, array $options = array())
  {
    $criteria = new Criteria;
    $criteria->add(QubitAip::ID, $id);

    if (1 == count($query = self::get($criteria, $options)))
    {
      return $query[0];
    }
  }

  public function __construct()
  {
    parent::__construct();

    $this->tables[] = Propel::getDatabaseMap(QubitAip::DATABASE_NAME)->getTable(QubitAip::TABLE_NAME);
  }

  public static function addJoininformationObjectCriteria(Criteria $criteria)
  {
    $criteria->addJoin(QubitAip::INFORMATION_OBJECT_ID, QubitInformationObject::ID);

    return $criteria;
  }

  public static function addJoinaipTypeCriteria(Criteria $criteria)
  {
    $criteria->addJoin(QubitAip::AIP_TYPE_ID, QubitTerm::ID);

    return $criteria;
  }
}
