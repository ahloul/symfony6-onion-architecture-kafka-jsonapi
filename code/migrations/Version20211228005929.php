<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211228005929 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER INDEX idx_772b1ecc1392a5d8 RENAME TO IDX_772B1ECC28AA1B6F');
        $this->addSql('ALTER TABLE "user" ADD tier VARCHAR(255) DEFAULT \'free\' NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "user" DROP tier');
        $this->addSql('ALTER INDEX idx_772b1ecc28aa1b6f RENAME TO idx_772b1ecc1392a5d8');
    }
}
