<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210105193724 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE message (id INT AUTO_INCREMENT NOT NULL, sender_id INT NOT NULL, state_id INT DEFAULT NULL, message VARCHAR(5000) DEFAULT NULL, date DATETIME NOT NULL, INDEX IDX_B6BD307FF624B39D (sender_id), INDEX IDX_B6BD307F5D83CC1 (state_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message_received (id INT AUTO_INCREMENT NOT NULL, reciever_id INT DEFAULT NULL, message_id INT DEFAULT NULL, INDEX IDX_C04AFDD65D5C928D (reciever_id), INDEX IDX_C04AFDD6537A1329 (message_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE message_state (id INT AUTO_INCREMENT NOT NULL, state VARCHAR(255) NOT NULL, code VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307FF624B39D FOREIGN KEY (sender_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE message ADD CONSTRAINT FK_B6BD307F5D83CC1 FOREIGN KEY (state_id) REFERENCES message_state (id)');
        $this->addSql('ALTER TABLE message_received ADD CONSTRAINT FK_C04AFDD65D5C928D FOREIGN KEY (reciever_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE message_received ADD CONSTRAINT FK_C04AFDD6537A1329 FOREIGN KEY (message_id) REFERENCES message (id)');
        $this->addSql('ALTER TABLE profile_picture ADD user_id INT NOT NULL');
        $this->addSql('ALTER TABLE profile_picture ADD CONSTRAINT FK_C5659115A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id)');
        $this->addSql('CREATE INDEX IDX_C5659115A76ED395 ON profile_picture (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE message_received DROP FOREIGN KEY FK_C04AFDD6537A1329');
        $this->addSql('ALTER TABLE message DROP FOREIGN KEY FK_B6BD307F5D83CC1');
        $this->addSql('DROP TABLE message');
        $this->addSql('DROP TABLE message_received');
        $this->addSql('DROP TABLE message_state');
        $this->addSql('ALTER TABLE profile_picture DROP FOREIGN KEY FK_C5659115A76ED395');
        $this->addSql('DROP INDEX IDX_C5659115A76ED395 ON profile_picture');
        $this->addSql('ALTER TABLE profile_picture DROP user_id');
    }
}
