<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210117182204 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message ADD reply_to_id INT DEFAULT NULL, ADD is_reply_to TINYINT(1) NOT NULL');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FFFDF7169 FOREIGN KEY (reply_to_id) REFERENCES message (id)');
        $this->addSql('CREATE INDEX IDX_B6BD307FFFDF7169 ON message (reply_to_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FFFDF7169');
        $this->addSql('DROP INDEX IDX_B6BD307FFFDF7169 ON message');
        $this->addSql('ALTER TABLE message DROP reply_to_id, DROP is_reply_to');
    }
}
