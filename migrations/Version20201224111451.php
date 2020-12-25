<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201224111451 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address ADD contact_detail_id INT NOT NULL');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F81B62120C0 FOREIGN KEY (contact_detail_id) REFERENCES contact_details (id)');
        $this->addSql('CREATE INDEX IDX_D4E6F81B62120C0 ON address (contact_detail_id)');
        $this->addSql('ALTER TABLE contact_details DROP FOREIGN KEY FK_E8092A0BF5B7AF75');
        $this->addSql('DROP INDEX UNIQ_E8092A0BF5B7AF75 ON contact_details');
        $this->addSql('ALTER TABLE contact_details DROP address_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F81B62120C0');
        $this->addSql('DROP INDEX IDX_D4E6F81B62120C0 ON address');
        $this->addSql('ALTER TABLE address DROP contact_detail_id');
        $this->addSql('ALTER TABLE contact_details ADD address_id INT NOT NULL');
        $this->addSql('ALTER TABLE contact_details ADD CONSTRAINT FK_E8092A0BF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E8092A0BF5B7AF75 ON contact_details (address_id)');
    }
}
