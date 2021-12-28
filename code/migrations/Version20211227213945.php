<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211227213945 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE purchase (user_id INT NOT NULL, voucher_id INT NOT NULL, purchased_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, redeemed BOOLEAN DEFAULT \'false\' NOT NULL, PRIMARY KEY(user_id, voucher_id))');
        $this->addSql('CREATE INDEX IDX_6117D13BA76ED395 ON purchase (user_id)');
        $this->addSql('CREATE INDEX IDX_6117D13B28AA1B6F ON purchase (voucher_id)');
        $this->addSql('CREATE TABLE redeem (user_id INT NOT NULL, voucher_id INT NOT NULL, reedemed_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(user_id, voucher_id))');
        $this->addSql('CREATE INDEX IDX_772B1ECCA76ED395 ON redeem (user_id)');
        $this->addSql('CREATE INDEX IDX_772B1ECC1392A5D8 ON redeem (voucher_id)');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13BA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE purchase ADD CONSTRAINT FK_6117D13B28AA1B6F FOREIGN KEY (voucher_id) REFERENCES voucher (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE redeem ADD CONSTRAINT FK_772B1ECCA76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE redeem ADD CONSTRAINT FK_772B1ECC1392A5D8 FOREIGN KEY (voucher_id) REFERENCES voucher (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE purchase');
        $this->addSql('DROP TABLE redeem');
    }
}
