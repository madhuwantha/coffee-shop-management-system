<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201225074418 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE coffee_shop ADD cover_photo_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE coffee_shop ADD CONSTRAINT FK_D7A7935A69B8AD7 FOREIGN KEY (cover_photo_id) REFERENCES cover_photo (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_D7A7935A69B8AD7 ON coffee_shop (cover_photo_id)');
        $this->addSql('ALTER TABLE cover_photo DROP FOREIGN KEY FK_CD55028D4D16C4DD');
        $this->addSql('DROP INDEX IDX_CD55028D4D16C4DD ON cover_photo');
        $this->addSql('ALTER TABLE cover_photo DROP shop_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE coffee_shop DROP FOREIGN KEY FK_D7A7935A69B8AD7');
        $this->addSql('DROP INDEX UNIQ_D7A7935A69B8AD7 ON coffee_shop');
        $this->addSql('ALTER TABLE coffee_shop DROP cover_photo_id');
        $this->addSql('ALTER TABLE cover_photo ADD shop_id INT NOT NULL');
        $this->addSql('ALTER TABLE cover_photo ADD CONSTRAINT FK_CD55028D4D16C4DD FOREIGN KEY (shop_id) REFERENCES coffee_shop (id)');
        $this->addSql('CREATE INDEX IDX_CD55028D4D16C4DD ON cover_photo (shop_id)');
    }
}
