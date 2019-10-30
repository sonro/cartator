<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191030092118 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE accessor (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, name VARCHAR(190) NOT NULL, class_name VARCHAR(190) NOT NULL, supported_data_types VARCHAR(190) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE accessor_source_app (accessor_id INT NOT NULL, source_app_id INT NOT NULL, INDEX IDX_F8C798732E8A75A9 (accessor_id), INDEX IDX_F8C79873CF7804CB (source_app_id), PRIMARY KEY(accessor_id, source_app_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE accessor_source_app ADD CONSTRAINT FK_F8C798732E8A75A9 FOREIGN KEY (accessor_id) REFERENCES accessor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE accessor_source_app ADD CONSTRAINT FK_F8C79873CF7804CB FOREIGN KEY (source_app_id) REFERENCES source_app (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE accessor_source_app DROP FOREIGN KEY FK_F8C798732E8A75A9');
        $this->addSql('DROP TABLE accessor');
        $this->addSql('DROP TABLE accessor_source_app');
    }
}
