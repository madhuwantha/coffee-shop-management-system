<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210113140049 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item ADD shop_id INT NOT NULL');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E4D16C4DD FOREIGN KEY (shop_id) REFERENCES coffee_shop (id)');
        $this->addSql('CREATE INDEX IDX_1F1B251E4D16C4DD ON item (shop_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E4D16C4DD');
        $this->addSql('DROP INDEX IDX_1F1B251E4D16C4DD ON item');
        $this->addSql('ALTER TABLE item DROP shop_id');
    }
}
