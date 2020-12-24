<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201224102657 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact_details DROP INDEX UNIQ_E8092A0B4D16C4DD, ADD INDEX IDX_E8092A0B4D16C4DD (shop_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact_details DROP INDEX IDX_E8092A0B4D16C4DD, ADD UNIQUE INDEX UNIQ_E8092A0B4D16C4DD (shop_id)');
    }
}
