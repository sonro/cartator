<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191106082853 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE accessor_source_query DROP FOREIGN KEY FK_C21C0FBCACB4594B');
        $this->addSql('CREATE TABLE accessor_source_querier (accessor_id INT NOT NULL, source_querier_id INT NOT NULL, INDEX IDX_23B100442E8A75A9 (accessor_id), INDEX IDX_23B10044F962CC29 (source_querier_id), PRIMARY KEY(accessor_id, source_querier_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE source_querier (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, interface_name VARCHAR(190) NOT NULL, class_name VARCHAR(190) NOT NULL, UNIQUE INDEX UNIQ_B420CF8CEA5E4949 (class_name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE accessor_source_querier ADD CONSTRAINT FK_23B100442E8A75A9 FOREIGN KEY (accessor_id) REFERENCES accessor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE accessor_source_querier ADD CONSTRAINT FK_23B10044F962CC29 FOREIGN KEY (source_querier_id) REFERENCES source_querier (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE accessor_source_query');
        $this->addSql('DROP TABLE source_query');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE accessor_source_querier DROP FOREIGN KEY FK_23B10044F962CC29');
        $this->addSql('CREATE TABLE accessor_source_query (accessor_id INT NOT NULL, source_query_id INT NOT NULL, INDEX IDX_C21C0FBC2E8A75A9 (accessor_id), INDEX IDX_C21C0FBCACB4594B (source_query_id), PRIMARY KEY(accessor_id, source_query_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE source_query (id INT AUTO_INCREMENT NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, interface_name VARCHAR(190) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, class_name VARCHAR(190) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, UNIQUE INDEX UNIQ_BDB56ED4EA5E4949 (class_name), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE accessor_source_query ADD CONSTRAINT FK_C21C0FBC2E8A75A9 FOREIGN KEY (accessor_id) REFERENCES accessor (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE accessor_source_query ADD CONSTRAINT FK_C21C0FBCACB4594B FOREIGN KEY (source_query_id) REFERENCES source_query (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE accessor_source_querier');
        $this->addSql('DROP TABLE source_querier');
    }
}
