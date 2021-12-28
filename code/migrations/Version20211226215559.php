<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211226215559 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE users_vouchers (user_id INT NOT NULL, voucher_id INT NOT NULL, PRIMARY KEY(user_id, voucher_id))');
        $this->addSql('CREATE INDEX IDX_E8542C92A76ED395 ON users_vouchers (user_id)');
        $this->addSql('CREATE INDEX IDX_E8542C9228AA1B6F ON users_vouchers (voucher_id)');
        $this->addSql('CREATE TABLE voucher (id INT NOT NULL, code VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, price NUMERIC(10, 0) DEFAULT \'0\' NOT NULL, quantity_in_stock INT DEFAULT 0 NOT NULL, vaild_from TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, valid_to TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE users_vouchers ADD CONSTRAINT FK_E8542C92A76ED395 FOREIGN KEY (user_id) REFERENCES "user" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE users_vouchers ADD CONSTRAINT FK_E8542C9228AA1B6F FOREIGN KEY (voucher_id) REFERENCES voucher (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "user" ADD email VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD password VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL');
        $this->addSql('ALTER TABLE "user" ADD roles JSON NOT NULL');
        $this->addSql('COMMENT ON COLUMN "user".created_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE users_vouchers DROP CONSTRAINT FK_E8542C9228AA1B6F');
        $this->addSql('DROP TABLE users_vouchers');
        $this->addSql('DROP TABLE voucher');
        $this->addSql('ALTER TABLE "user" DROP email');
        $this->addSql('ALTER TABLE "user" DROP password');
        $this->addSql('ALTER TABLE "user" DROP created_at');
        $this->addSql('ALTER TABLE "user" DROP roles');
    }
}
