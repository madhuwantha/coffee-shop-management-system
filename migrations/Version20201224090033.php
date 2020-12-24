<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201224090033 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, line_one VARCHAR(50) DEFAULT NULL, line_two VARCHAR(255) DEFAULT NULL, city VARCHAR(50) NOT NULL, postal_code INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact_details (id INT AUTO_INCREMENT NOT NULL, shop_id INT NOT NULL, address_id INT NOT NULL, email LONGTEXT NOT NULL, phone_number VARCHAR(20) NOT NULL, UNIQUE INDEX UNIQ_E8092A0B4D16C4DD (shop_id), UNIQUE INDEX UNIQ_E8092A0BF5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cover_photo (id INT AUTO_INCREMENT NOT NULL, shop_id INT NOT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_CD55028D4D16C4DD (shop_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profile_picture (id INT AUTO_INCREMENT NOT NULL, path_id INT DEFAULT NULL, INDEX IDX_C5659115D96C566B (path_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slider_image (id INT AUTO_INCREMENT NOT NULL, shop_id INT NOT NULL, path VARCHAR(255) NOT NULL, position INT NOT NULL, INDEX IDX_4389483B4D16C4DD (shop_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contact_details ADD CONSTRAINT FK_E8092A0B4D16C4DD FOREIGN KEY (shop_id) REFERENCES coffee_shop (id)');
        $this->addSql('ALTER TABLE contact_details ADD CONSTRAINT FK_E8092A0BF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE cover_photo ADD CONSTRAINT FK_CD55028D4D16C4DD FOREIGN KEY (shop_id) REFERENCES coffee_shop (id)');
        $this->addSql('ALTER TABLE profile_picture ADD CONSTRAINT FK_C5659115D96C566B FOREIGN KEY (path_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE slider_image ADD CONSTRAINT FK_4389483B4D16C4DD FOREIGN KEY (shop_id) REFERENCES coffee_shop (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact_details DROP FOREIGN KEY FK_E8092A0BF5B7AF75');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE contact_details');
        $this->addSql('DROP TABLE cover_photo');
        $this->addSql('DROP TABLE profile_picture');
        $this->addSql('DROP TABLE slider_image');
    }
}
