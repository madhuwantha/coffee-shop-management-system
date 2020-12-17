<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201216190240 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, menu_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, level VARCHAR(255) NOT NULL, INDEX IDX_64C19C1CCD7E912 (menu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE coffee_shop (id INT AUTO_INCREMENT NOT NULL, theme_id INT DEFAULT NULL, menu_id INT DEFAULT NULL, owner_id INT NOT NULL, name VARCHAR(255) NOT NULL, city VARCHAR(255) NOT NULL, INDEX IDX_D7A793559027487 (theme_id), UNIQUE INDEX UNIQ_D7A7935CCD7E912 (menu_id), UNIQUE INDEX UNIQ_D7A79357E3C61F9 (owner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gallery (id INT AUTO_INCREMENT NOT NULL, coffee_shop_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_472B783AACCB8DB (coffee_shop_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gallery_image (id INT AUTO_INCREMENT NOT NULL, gallery_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_21A0D47C4E7AF8F (gallery_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gallery_video (id INT AUTO_INCREMENT NOT NULL, gallery_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_985A0A0F4E7AF8F (gallery_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, price VARCHAR(255) NOT NULL, INDEX IDX_1F1B251E12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item_image (id INT AUTO_INCREMENT NOT NULL, item_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_EF9A1F8F126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_category (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE next_category (id INT AUTO_INCREMENT NOT NULL, parent_category_id INT DEFAULT NULL, child_category_id INT DEFAULT NULL, INDEX IDX_3E56552F796A8F92 (parent_category_id), INDEX IDX_3E56552FC8C2FACC (child_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, status_id INT DEFAULT NULL, date DATETIME NOT NULL, total VARCHAR(255) NOT NULL, INDEX IDX_F52993989395C3F3 (customer_id), UNIQUE INDEX UNIQ_F52993986BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_item (id INT AUTO_INCREMENT NOT NULL, item_id INT DEFAULT NULL, order__id INT DEFAULT NULL, date DATETIME NOT NULL, UNIQUE INDEX UNIQ_52EA1F09126F525E (item_id), UNIQUE INDEX UNIQ_52EA1F09251A8A50 (order__id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE coffee_shop ADD CONSTRAINT FK_D7A793559027487 FOREIGN KEY (theme_id) REFERENCES theme (id)');
        $this->addSql('ALTER TABLE coffee_shop ADD CONSTRAINT FK_D7A7935CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE coffee_shop ADD CONSTRAINT FK_D7A79357E3C61F9 FOREIGN KEY (owner_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE gallery ADD CONSTRAINT FK_472B783AACCB8DB FOREIGN KEY (coffee_shop_id) REFERENCES coffee_shop (id)');
        $this->addSql('ALTER TABLE gallery_image ADD CONSTRAINT FK_21A0D47C4E7AF8F FOREIGN KEY (gallery_id) REFERENCES gallery (id)');
        $this->addSql('ALTER TABLE gallery_video ADD CONSTRAINT FK_985A0A0F4E7AF8F FOREIGN KEY (gallery_id) REFERENCES gallery (id)');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE item_image ADD CONSTRAINT FK_EF9A1F8F126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE next_category ADD CONSTRAINT FK_3E56552F796A8F92 FOREIGN KEY (parent_category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE next_category ADD CONSTRAINT FK_3E56552FC8C2FACC FOREIGN KEY (child_category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993989395C3F3 FOREIGN KEY (customer_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993986BF700BD FOREIGN KEY (status_id) REFERENCES order_status (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F09126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F09251A8A50 FOREIGN KEY (order__id) REFERENCES `order` (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E12469DE2');
        $this->addSql('ALTER TABLE next_category DROP FOREIGN KEY FK_3E56552F796A8F92');
        $this->addSql('ALTER TABLE next_category DROP FOREIGN KEY FK_3E56552FC8C2FACC');
        $this->addSql('ALTER TABLE gallery DROP FOREIGN KEY FK_472B783AACCB8DB');
        $this->addSql('ALTER TABLE gallery_image DROP FOREIGN KEY FK_21A0D47C4E7AF8F');
        $this->addSql('ALTER TABLE gallery_video DROP FOREIGN KEY FK_985A0A0F4E7AF8F');
        $this->addSql('ALTER TABLE item_image DROP FOREIGN KEY FK_EF9A1F8F126F525E');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F09126F525E');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1CCD7E912');
        $this->addSql('ALTER TABLE coffee_shop DROP FOREIGN KEY FK_D7A7935CCD7E912');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F09251A8A50');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993986BF700BD');
        $this->addSql('ALTER TABLE coffee_shop DROP FOREIGN KEY FK_D7A793559027487');
        $this->addSql('ALTER TABLE coffee_shop DROP FOREIGN KEY FK_D7A79357E3C61F9');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993989395C3F3');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE coffee_shop');
        $this->addSql('DROP TABLE gallery');
        $this->addSql('DROP TABLE gallery_image');
        $this->addSql('DROP TABLE gallery_video');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE item_image');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE menu_category');
        $this->addSql('DROP TABLE next_category');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_item');
        $this->addSql('DROP TABLE order_status');
        $this->addSql('DROP TABLE theme');
        $this->addSql('DROP TABLE `user`');
    }
}
