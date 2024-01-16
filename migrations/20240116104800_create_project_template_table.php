<?php

class CreateProjectTemplateTable extends AbstractMatecatMigration {

    public $sql_up = [ '
        CREATE TABLE `project_templates` (
            `id` INT UNSIGNED NOT NULL AUTO_INCREMENT,
            `name` VARCHAR(255) NOT NULL,
            `is_default` TINYINT(1) NOT NULL DEFAULT  0,
            `uid` INT(11) NOT NULL,
            `id_team` INT(11) NOT NULL,
            `speech2text` TINYINT(1) NOT NULL DEFAULT  0,
            `lexica` TINYINT(1) NOT NULL DEFAULT  0,
            `tag_projection` TINYINT(1) NOT NULL DEFAULT  0,
            `segmentation_rule` VARCHAR(255) DEFAULT NULL,
            `cross_language_matches` TEXT DEFAULT NULL,
            `tm` TEXT DEFAULT NULL,
            `mt` TEXT DEFAULT NULL,
            `payable_rate_template_id` INT(11) DEFAULT NULL,
            `qa_model_template_id` INT(11) DEFAULT NULL,
            `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
            `modified_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
            PRIMARY KEY (`id`),
            UNIQUE INDEX `uid_name_idx` (`uid` ASC, `name` ASC));
    ' ];

    public $sql_down = [ '
        DROP TABLE `project_templates`;
    ' ];
}

