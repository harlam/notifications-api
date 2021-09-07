<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210907110846 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE notification_log_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE notification_log (id INT NOT NULL, notification_channel_id INT NOT NULL REFERENCES notification_channel (id) NOT DEFERRABLE INITIALLY IMMEDIATE, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, message JSONB NOT NULL, result JSONB DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_ED15DF289870488 ON notification_log (notification_channel_id)');
        $this->addSql('COMMENT ON COLUMN notification_log.created_at IS \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE notification_log_id_seq CASCADE');
        $this->addSql('DROP TABLE notification_log');
    }
}
