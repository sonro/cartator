<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191030075220 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE software DROP FOREIGN KEY FK_77D068CF3E030ACD');
        $this->addSql('ALTER TABLE installation DROP FOREIGN KEY FK_1CBA6AB1F0AA09DB');
        $this->addSql('ALTER TABLE installation DROP FOREIGN KEY FK_1CBA6AB1D7452741');
        $this->addSql('CREATE TABLE source_app (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, name VARCHAR(190) NOT NULL, website VARCHAR(190) NOT NULL, downloads_url VARCHAR(190) NOT NULL, auto_download TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE source_app_version (id INT AUTO_INCREMENT NOT NULL, source_app_id INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, version VARCHAR(32) NOT NULL, download_url VARCHAR(190) NOT NULL, INDEX IDX_6E3E032ECF7804CB (source_app_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE source_db (id INT AUTO_INCREMENT NOT NULL, db_user_id INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, db_name VARCHAR(190) NOT NULL, db_host VARCHAR(190) NOT NULL, INDEX IDX_C9F1C719FF1788DF (db_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE source_app_version ADD CONSTRAINT FK_6E3E032ECF7804CB FOREIGN KEY (source_app_id) REFERENCES source_app (id)');
        $this->addSql('ALTER TABLE source_db ADD CONSTRAINT FK_C9F1C719FF1788DF FOREIGN KEY (db_user_id) REFERENCES db_user (id)');
        $this->addSql('DROP TABLE application');
        $this->addSql('DROP TABLE `database`');
        $this->addSql('DROP TABLE software');
        $this->addSql('DROP INDEX IDX_1CBA6AB1D7452741 ON installation');
        $this->addSql('DROP INDEX IDX_1CBA6AB1F0AA09DB ON installation');
        $this->addSql('ALTER TABLE installation ADD source_db_id INT DEFAULT NULL, ADD source_app_version_id INT DEFAULT NULL, DROP database_id, DROP software_id');
        $this->addSql('ALTER TABLE installation ADD CONSTRAINT FK_1CBA6AB13BB7DE05 FOREIGN KEY (source_db_id) REFERENCES source_db (id)');
        $this->addSql('ALTER TABLE installation ADD CONSTRAINT FK_1CBA6AB1BEDEE0DC FOREIGN KEY (source_app_version_id) REFERENCES source_app_version (id)');
        $this->addSql('CREATE INDEX IDX_1CBA6AB13BB7DE05 ON installation (source_db_id)');
        $this->addSql('CREATE INDEX IDX_1CBA6AB1BEDEE0DC ON installation (source_app_version_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE source_app_version DROP FOREIGN KEY FK_6E3E032ECF7804CB');
        $this->addSql('ALTER TABLE installation DROP FOREIGN KEY FK_1CBA6AB1BEDEE0DC');
        $this->addSql('ALTER TABLE installation DROP FOREIGN KEY FK_1CBA6AB13BB7DE05');
        $this->addSql('CREATE TABLE application (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, name VARCHAR(190) NOT NULL COLLATE utf8mb4_unicode_ci, website VARCHAR(190) NOT NULL COLLATE utf8mb4_unicode_ci, downloads_url VARCHAR(190) NOT NULL COLLATE utf8mb4_unicode_ci, auto_download TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE `database` (id INT AUTO_INCREMENT NOT NULL, db_user_id INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, db_name VARCHAR(190) NOT NULL COLLATE utf8mb4_unicode_ci, db_host VARCHAR(190) NOT NULL COLLATE utf8mb4_unicode_ci, INDEX IDX_C953062EFF1788DF (db_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE software (id INT AUTO_INCREMENT NOT NULL, application_id INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, version VARCHAR(32) NOT NULL COLLATE utf8mb4_unicode_ci, download_url VARCHAR(190) NOT NULL COLLATE utf8mb4_unicode_ci, INDEX IDX_77D068CF3E030ACD (application_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE `database` ADD CONSTRAINT FK_C953062EFF1788DF FOREIGN KEY (db_user_id) REFERENCES db_user (id)');
        $this->addSql('ALTER TABLE software ADD CONSTRAINT FK_77D068CF3E030ACD FOREIGN KEY (application_id) REFERENCES application (id)');
        $this->addSql('DROP TABLE source_app');
        $this->addSql('DROP TABLE source_app_version');
        $this->addSql('DROP TABLE source_db');
        $this->addSql('DROP INDEX IDX_1CBA6AB13BB7DE05 ON installation');
        $this->addSql('DROP INDEX IDX_1CBA6AB1BEDEE0DC ON installation');
        $this->addSql('ALTER TABLE installation ADD database_id INT DEFAULT NULL, ADD software_id INT DEFAULT NULL, DROP source_db_id, DROP source_app_version_id');
        $this->addSql('ALTER TABLE installation ADD CONSTRAINT FK_1CBA6AB1D7452741 FOREIGN KEY (software_id) REFERENCES software (id)');
        $this->addSql('ALTER TABLE installation ADD CONSTRAINT FK_1CBA6AB1F0AA09DB FOREIGN KEY (database_id) REFERENCES `database` (id)');
        $this->addSql('CREATE INDEX IDX_1CBA6AB1D7452741 ON installation (software_id)');
        $this->addSql('CREATE INDEX IDX_1CBA6AB1F0AA09DB ON installation (database_id)');
    }
}
