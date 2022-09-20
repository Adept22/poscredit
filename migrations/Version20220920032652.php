<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220920032652 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE poscredit.sms (id UUID NOT NULL, "to" VARCHAR(251) NOT NULL, msg TEXT NOT NULL, smsru_id VARCHAR(16) NOT NULL, status INT DEFAULT -1 NOT NULL, created_at TIMESTAMP(0) WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, updated_at TIMESTAMP(0) WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN poscredit.sms.id IS \'(DC2Type:uuid)\'');
        $this->addSql('COMMENT ON COLUMN poscredit.sms.created_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('COMMENT ON COLUMN poscredit.sms.updated_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('DROP INDEX name_index');
        $this->addSql('ALTER TABLE poscredit.otp ALTER created_at SET DEFAULT CURRENT_TIMESTAMP');
        $this->addSql('ALTER TABLE poscredit.otp RENAME COLUMN phone TO phone_phone');
        $this->addSql('ALTER TABLE poscredit.otp RENAME COLUMN code TO code_hash');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE poscredit.sms');
        $this->addSql('ALTER TABLE poscredit.otp ALTER created_at DROP DEFAULT');
        $this->addSql('ALTER TABLE poscredit.otp RENAME COLUMN phone_phone TO phone');
        $this->addSql('ALTER TABLE poscredit.otp RENAME COLUMN code_hash TO code');
        $this->addSql('CREATE INDEX name_index ON poscredit.otp (phone)');
    }
}
