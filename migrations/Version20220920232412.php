<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220920232412 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE otp RENAME COLUMN phone_phone TO phone');
        $this->addSql('ALTER TABLE otp RENAME COLUMN code_hash TO code');
        $this->addSql('ALTER TABLE sms DROP updated_at');
        $this->addSql('ALTER TABLE sms ALTER smsru_id DROP NOT NULL');
        $this->addSql('ALTER TABLE sms RENAME COLUMN "to" TO sms_to');
        $this->addSql('ALTER TABLE sms RENAME COLUMN status TO sms_status');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE poscredit.sms ADD updated_at TIMESTAMP(0) WITH TIME ZONE DEFAULT CURRENT_TIMESTAMP NOT NULL');
        $this->addSql('ALTER TABLE poscredit.sms ALTER smsru_id SET NOT NULL');
        $this->addSql('ALTER TABLE poscredit.sms RENAME COLUMN sms_to TO "to"');
        $this->addSql('ALTER TABLE poscredit.sms RENAME COLUMN sms_status TO status');
        $this->addSql('COMMENT ON COLUMN poscredit.sms.updated_at IS \'(DC2Type:datetimetz_immutable)\'');
        $this->addSql('ALTER TABLE poscredit.otp RENAME COLUMN phone TO phone_phone');
        $this->addSql('ALTER TABLE poscredit.otp RENAME COLUMN code TO code_hash');
    }
}
