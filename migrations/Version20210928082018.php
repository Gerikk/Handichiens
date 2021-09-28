<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210928082018 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking ADD chien_id_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE booking ADD CONSTRAINT FK_E00CEDDE977D78A1 FOREIGN KEY (chien_id_id) REFERENCES chien (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E00CEDDE977D78A1 ON booking (chien_id_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking DROP FOREIGN KEY FK_E00CEDDE977D78A1');
        $this->addSql('DROP INDEX UNIQ_E00CEDDE977D78A1 ON booking');
        $this->addSql('ALTER TABLE booking DROP chien_id_id');
    }
}
