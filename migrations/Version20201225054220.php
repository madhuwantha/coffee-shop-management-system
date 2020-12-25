<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201225054220 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE coffee_shop ADD contact_detail_id INT NOT NULL');
        $this->addSql('ALTER TABLE coffee_shop ADD CONSTRAINT FK_D7A7935B62120C0 FOREIGN KEY (contact_detail_id) REFERENCES contact_details (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D7A7935B62120C0 ON coffee_shop (contact_detail_id)');
        $this->addSql('ALTER TABLE contact_details DROP FOREIGN KEY FK_E8092A0B4D16C4DD');
        $this->addSql('DROP INDEX IDX_E8092A0B4D16C4DD ON contact_details');
        $this->addSql('ALTER TABLE contact_details DROP shop_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE coffee_shop DROP FOREIGN KEY FK_D7A7935B62120C0');
        $this->addSql('DROP INDEX UNIQ_D7A7935B62120C0 ON coffee_shop');
        $this->addSql('ALTER TABLE coffee_shop DROP contact_detail_id');
        $this->addSql('ALTER TABLE contact_details ADD shop_id INT NOT NULL');
        $this->addSql('ALTER TABLE contact_details ADD CONSTRAINT FK_E8092A0B4D16C4DD FOREIGN KEY (shop_id) REFERENCES coffee_shop (id)');
        $this->addSql('CREATE INDEX IDX_E8092A0B4D16C4DD ON contact_details (shop_id)');
    }
}
