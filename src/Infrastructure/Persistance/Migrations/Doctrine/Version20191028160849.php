<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191028160849 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `database` (id INT AUTO_INCREMENT NOT NULL, db_user_id INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, db_name VARCHAR(190) NOT NULL, db_host VARCHAR(190) NOT NULL, INDEX IDX_C953062EFF1788DF (db_user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE db_user (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, username VARCHAR(190) NOT NULL, password VARCHAR(190) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE installation (id INT AUTO_INCREMENT NOT NULL, database_id INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, name VARCHAR(190) NOT NULL, db_table_prefix VARCHAR(32) NOT NULL, INDEX IDX_1CBA6AB1F0AA09DB (database_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `database` ADD CONSTRAINT FK_C953062EFF1788DF FOREIGN KEY (db_user_id) REFERENCES db_user (id)');
        $this->addSql('ALTER TABLE installation ADD CONSTRAINT FK_1CBA6AB1F0AA09DB FOREIGN KEY (database_id) REFERENCES `database` (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE installation DROP FOREIGN KEY FK_1CBA6AB1F0AA09DB');
        $this->addSql('ALTER TABLE `database` DROP FOREIGN KEY FK_C953062EFF1788DF');
        $this->addSql('DROP TABLE `database`');
        $this->addSql('DROP TABLE db_user');
        $this->addSql('DROP TABLE installation');
    }
}
