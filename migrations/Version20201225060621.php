<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201225060621 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact_details ADD address_id INT NOT NULL');
        $this->addSql('ALTER TABLE contact_details ADD CONSTRAINT FK_E8092A0BF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E8092A0BF5B7AF75 ON contact_details (address_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact_details DROP FOREIGN KEY FK_E8092A0BF5B7AF75');
        $this->addSql('DROP INDEX UNIQ_E8092A0BF5B7AF75 ON contact_details');
        $this->addSql('ALTER TABLE contact_details DROP address_id');
    }
}
