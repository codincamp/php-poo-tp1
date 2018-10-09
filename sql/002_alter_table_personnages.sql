ALTER TABLE `personnages`
    ADD `experience` INT(3) UNSIGNED NOT NULL DEFAULT '0' AFTER `degats`,
    ADD `level` INT(3) UNSIGNED NOT NULL DEFAULT '0' AFTER `experience`; 