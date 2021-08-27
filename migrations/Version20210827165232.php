<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20210827165232 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE SEQUENCE notification_channel_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE notification_channel (id INT NOT NULL, key VARCHAR(64) NOT NULL, name VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, params JSONB DEFAULT NULL, PRIMARY KEY(id))');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP SEQUENCE notification_channel_id_seq CASCADE');
        $this->addSql('DROP TABLE notification_channel');
    }
}
