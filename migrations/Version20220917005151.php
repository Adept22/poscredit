<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220917005151 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA poscredit');
        $this->addSql('CREATE TABLE poscredit.otp (id UUID NOT NULL, phone VARCHAR(11) NOT NULL, code VARCHAR(64) NOT NULL, created_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, expires_at TIMESTAMP(0) WITH TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX name_index ON poscredit.otp (phone)');
        $this->addSql('COMMENT ON COLUMN poscredit.otp.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN poscredit.otp.created_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('COMMENT ON COLUMN poscredit.otp.expires_at IS \'(DC2Type:datetimetz_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE poscredit.otp');
        $this->addSql('DROP SCHEMA poscredit');
    }
}
