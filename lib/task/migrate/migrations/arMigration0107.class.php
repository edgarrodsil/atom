<?php

/*
 * This file is part of the Access to Memory (AtoM) software.
 *
 * Access to Memory (AtoM) is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Access to Memory (AtoM) is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Access to Memory (AtoM).  If not, see <http://www.gnu.org/licenses/>.
 */

/*
 * Create AIP table, add AIP types taxonomy and terms
 *
 * @package    AccesstoMemory
 * @subpackage migration
 */
class arMigration0107
{
  const
    VERSION = 107, // The new database version
    MIN_MILESTONE = 2; // The minimum milestone required

  /**
   * Upgrade
   *
   * @return bool True if the upgrade succeeded, False otherwise
   */
  public function up($configuration)
  {
    // Create AIP table
    $sql = <<<sql

CREATE TABLE `aip`
(
        `id` INTEGER  NOT NULL,
        `information_object_id` INTEGER  NOT NULL,
        `aip_type_id` INTEGER,
        `object_uuid` VARCHAR(255),
        `aip_uuid` VARCHAR(255),
        PRIMARY KEY (`id`),
        UNIQUE KEY `aip_U_1` (`object_uuid`),
        CONSTRAINT `aip_FK_1`
                FOREIGN KEY (`id`)
                REFERENCES `object` (`id`)
                ON DELETE CASCADE,
        INDEX `aip_FI_2` (`information_object_id`),
        CONSTRAINT `aip_FK_2`
                FOREIGN KEY (`information_object_id`)
                REFERENCES `information_object` (`id`),
        INDEX `aip_FI_3` (`aip_type_id`),
        CONSTRAINT `aip_FK_3`
                FOREIGN KEY (`aip_type_id`)
                REFERENCES `term` (`id`)
                ON DELETE SET NULL
)Engine=InnoDB;

sql;

    QubitPdo::modify($sql);

    // Add "AIP types" taxonomy
    QubitMigrate::bumpTaxonomy(QubitTaxonomy::AIP_TYPE_ID, $configuration);
    $taxonomy = new QubitTaxonomy;
    $taxonomy->id = QubitTaxonomy::AIP_TYPE_ID;
    $taxonomy->parentId = QubitTaxonomy::ROOT_ID;
    $taxonomy->name = 'AIP types';
    $taxonomy->culture = 'en';
    $taxonomy->save();

    // Add "AIP types" terms
    foreach (array(
      QubitTerm::ARTWORK_ID => 'Artwork',
      QubitTerm::SOFTWARE_ID => 'Software',
      QubitTerm::DOCUMENTATION_ID => 'Documentation',
      QubitTerm::UNCLASSIFIED_ID => 'Unclassified') as $id => $value)
    {
      QubitMigrate::bumpTerm($id, $configuration);
      $term = new QubitTerm;
      $term->id = $id;
      $term->parentId = QubitTerm::ROOT_ID;
      $term->taxonomyId = QubitTaxonomy::AIP_TYPE_ID;
      $term->name = $value;
      $term->culture = 'en';
      $term->save();
    }

    return true;
  }
}
