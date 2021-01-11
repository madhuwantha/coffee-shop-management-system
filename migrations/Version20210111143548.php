<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210111143548 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE address (id INT AUTO_INCREMENT NOT NULL, contact_detail_id INT DEFAULT NULL, line_one VARCHAR(50) DEFAULT NULL, line_two VARCHAR(255) DEFAULT NULL, city VARCHAR(50) NOT NULL, postal_code VARCHAR(50) NOT NULL, INDEX IDX_D4E6F81B62120C0 (contact_detail_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, menu_id INT DEFAULT NULL, parent_category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, level VARCHAR(255) NOT NULL, INDEX IDX_64C19C1CCD7E912 (menu_id), INDEX IDX_64C19C1796A8F92 (parent_category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE coffee_shop (id INT AUTO_INCREMENT NOT NULL, theme_id INT DEFAULT NULL, menu_id INT DEFAULT NULL, owner_id INT NOT NULL, contact_detail_id INT DEFAULT NULL, cover_photo_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, about_us VARCHAR(255) NOT NULL, INDEX IDX_D7A793559027487 (theme_id), UNIQUE INDEX UNIQ_D7A7935CCD7E912 (menu_id), INDEX IDX_D7A79357E3C61F9 (owner_id), UNIQUE INDEX UNIQ_D7A7935B62120C0 (contact_detail_id), UNIQUE INDEX UNIQ_D7A7935A69B8AD7 (cover_photo_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE contact_details (id INT AUTO_INCREMENT NOT NULL, address_id INT DEFAULT NULL, email LONGTEXT NOT NULL, phone_number VARCHAR(20) NOT NULL, UNIQUE INDEX UNIQ_E8092A0BF5B7AF75 (address_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cover_photo (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gallery (id INT AUTO_INCREMENT NOT NULL, coffee_shop_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_472B783AACCB8DB (coffee_shop_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gallery_image (id INT AUTO_INCREMENT NOT NULL, gallery_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_21A0D47C4E7AF8F (gallery_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE gallery_video (id INT AUTO_INCREMENT NOT NULL, gallery_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_985A0A0F4E7AF8F (gallery_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, price VARCHAR(255) NOT NULL, INDEX IDX_1F1B251E12469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE item_image (id INT AUTO_INCREMENT NOT NULL, item_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_EF9A1F8F126F525E (item_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE menu_category (id INT AUTO_INCREMENT NOT NULL, menu_id INT DEFAULT NULL, category_id INT DEFAULT NULL, UNIQUE INDEX UNIQ_2A1D5C57CCD7E912 (menu_id), UNIQUE INDEX UNIQ_2A1D5C5712469DE2 (category_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, sender_id INT NOT NULL, state_id INT DEFAULT NULL, message VARCHAR(5000) DEFAULT NULL, date DATETIME NOT NULL, INDEX IDX_B6BD307FF624B39D (sender_id), INDEX IDX_B6BD307F5D83CC1 (state_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message_received (id INT AUTO_INCREMENT NOT NULL, reciever_id INT DEFAULT NULL, message_id INT DEFAULT NULL, INDEX IDX_C04AFDD65D5C928D (reciever_id), INDEX IDX_C04AFDD6537A1329 (message_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message_state (id INT AUTO_INCREMENT NOT NULL, state VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE next_category (id INT AUTO_INCREMENT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, status_id INT DEFAULT NULL, date DATETIME NOT NULL, total VARCHAR(255) NOT NULL, INDEX IDX_F52993989395C3F3 (customer_id), UNIQUE INDEX UNIQ_F52993986BF700BD (status_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_item (id INT AUTO_INCREMENT NOT NULL, item_id INT DEFAULT NULL, order__id INT DEFAULT NULL, date DATETIME NOT NULL, UNIQUE INDEX UNIQ_52EA1F09126F525E (item_id), UNIQUE INDEX UNIQ_52EA1F09251A8A50 (order__id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE order_status (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE profile_picture (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, path VARCHAR(255) NOT NULL, INDEX IDX_C5659115A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE slider_image (id INT AUTO_INCREMENT NOT NULL, shop_id INT NOT NULL, path VARCHAR(255) NOT NULL, position INT NOT NULL, title VARCHAR(255) DEFAULT NULL, sub_title VARCHAR(255) DEFAULT NULL, INDEX IDX_4389483B4D16C4DD (shop_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE address ADD CONSTRAINT FK_D4E6F81B62120C0 FOREIGN KEY (contact_detail_id) REFERENCES contact_details (id)');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE category ADD CONSTRAINT FK_64C19C1796A8F92 FOREIGN KEY (parent_category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE coffee_shop ADD CONSTRAINT FK_D7A793559027487 FOREIGN KEY (theme_id) REFERENCES theme (id)');
        $this->addSql('ALTER TABLE coffee_shop ADD CONSTRAINT FK_D7A7935CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE coffee_shop ADD CONSTRAINT FK_D7A79357E3C61F9 FOREIGN KEY (owner_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE coffee_shop ADD CONSTRAINT FK_D7A7935B62120C0 FOREIGN KEY (contact_detail_id) REFERENCES contact_details (id)');
        $this->addSql('ALTER TABLE coffee_shop ADD CONSTRAINT FK_D7A7935A69B8AD7 FOREIGN KEY (cover_photo_id) REFERENCES cover_photo (id)');
        $this->addSql('ALTER TABLE contact_details ADD CONSTRAINT FK_E8092A0BF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE gallery ADD CONSTRAINT FK_472B783AACCB8DB FOREIGN KEY (coffee_shop_id) REFERENCES coffee_shop (id)');
        $this->addSql('ALTER TABLE gallery_image ADD CONSTRAINT FK_21A0D47C4E7AF8F FOREIGN KEY (gallery_id) REFERENCES gallery (id)');
        $this->addSql('ALTER TABLE gallery_video ADD CONSTRAINT FK_985A0A0F4E7AF8F FOREIGN KEY (gallery_id) REFERENCES gallery (id)');
        $this->addSql('ALTER TABLE item ADD CONSTRAINT FK_1F1B251E12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE item_image ADD CONSTRAINT FK_EF9A1F8F126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE menu_category ADD CONSTRAINT FK_2A1D5C57CCD7E912 FOREIGN KEY (menu_id) REFERENCES menu (id)');
        $this->addSql('ALTER TABLE menu_category ADD CONSTRAINT FK_2A1D5C5712469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF624B39D FOREIGN KEY (sender_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F5D83CC1 FOREIGN KEY (state_id) REFERENCES message_state (id)');
        $this->addSql('ALTER TABLE message_received ADD CONSTRAINT FK_C04AFDD65D5C928D FOREIGN KEY (reciever_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE message_received ADD CONSTRAINT FK_C04AFDD6537A1329 FOREIGN KEY (message_id) REFERENCES message (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993989395C3F3 FOREIGN KEY (customer_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993986BF700BD FOREIGN KEY (status_id) REFERENCES order_status (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F09126F525E FOREIGN KEY (item_id) REFERENCES item (id)');
        $this->addSql('ALTER TABLE order_item ADD CONSTRAINT FK_52EA1F09251A8A50 FOREIGN KEY (order__id) REFERENCES `order` (id)');
        $this->addSql('ALTER TABLE profile_picture ADD CONSTRAINT FK_C5659115A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE slider_image ADD CONSTRAINT FK_4389483B4D16C4DD FOREIGN KEY (shop_id) REFERENCES coffee_shop (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE contact_details DROP FOREIGN KEY FK_E8092A0BF5B7AF75');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1796A8F92');
        $this->addSql('ALTER TABLE item DROP FOREIGN KEY FK_1F1B251E12469DE2');
        $this->addSql('ALTER TABLE menu_category DROP FOREIGN KEY FK_2A1D5C5712469DE2');
        $this->addSql('ALTER TABLE gallery DROP FOREIGN KEY FK_472B783AACCB8DB');
        $this->addSql('ALTER TABLE slider_image DROP FOREIGN KEY FK_4389483B4D16C4DD');
        $this->addSql('ALTER TABLE address DROP FOREIGN KEY FK_D4E6F81B62120C0');
        $this->addSql('ALTER TABLE coffee_shop DROP FOREIGN KEY FK_D7A7935B62120C0');
        $this->addSql('ALTER TABLE coffee_shop DROP FOREIGN KEY FK_D7A7935A69B8AD7');
        $this->addSql('ALTER TABLE gallery_image DROP FOREIGN KEY FK_21A0D47C4E7AF8F');
        $this->addSql('ALTER TABLE gallery_video DROP FOREIGN KEY FK_985A0A0F4E7AF8F');
        $this->addSql('ALTER TABLE item_image DROP FOREIGN KEY FK_EF9A1F8F126F525E');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F09126F525E');
        $this->addSql('ALTER TABLE category DROP FOREIGN KEY FK_64C19C1CCD7E912');
        $this->addSql('ALTER TABLE coffee_shop DROP FOREIGN KEY FK_D7A7935CCD7E912');
        $this->addSql('ALTER TABLE menu_category DROP FOREIGN KEY FK_2A1D5C57CCD7E912');
        $this->addSql('ALTER TABLE message_received DROP FOREIGN KEY FK_C04AFDD6537A1329');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F5D83CC1');
        $this->addSql('ALTER TABLE order_item DROP FOREIGN KEY FK_52EA1F09251A8A50');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993986BF700BD');
        $this->addSql('ALTER TABLE coffee_shop DROP FOREIGN KEY FK_D7A793559027487');
        $this->addSql('ALTER TABLE coffee_shop DROP FOREIGN KEY FK_D7A79357E3C61F9');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307FF624B39D');
        $this->addSql('ALTER TABLE message_received DROP FOREIGN KEY FK_C04AFDD65D5C928D');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993989395C3F3');
        $this->addSql('ALTER TABLE profile_picture DROP FOREIGN KEY FK_C5659115A76ED395');
        $this->addSql('DROP TABLE address');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE coffee_shop');
        $this->addSql('DROP TABLE contact_details');
        $this->addSql('DROP TABLE cover_photo');
        $this->addSql('DROP TABLE gallery');
        $this->addSql('DROP TABLE gallery_image');
        $this->addSql('DROP TABLE gallery_video');
        $this->addSql('DROP TABLE item');
        $this->addSql('DROP TABLE item_image');
        $this->addSql('DROP TABLE menu');
        $this->addSql('DROP TABLE menu_category');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE message_received');
        $this->addSql('DROP TABLE message_state');
        $this->addSql('DROP TABLE next_category');
        $this->addSql('DROP TABLE `order`');
        $this->addSql('DROP TABLE order_item');
        $this->addSql('DROP TABLE order_status');
        $this->addSql('DROP TABLE profile_picture');
        $this->addSql('DROP TABLE slider_image');
        $this->addSql('DROP TABLE theme');
        $this->addSql('DROP TABLE `user`');
    }
}
