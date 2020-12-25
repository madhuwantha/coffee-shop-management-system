<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201225075500 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profile_picture DROP FOREIGN KEY FK_C5659115D96C566B');
        $this->addSql('DROP INDEX IDX_C5659115D96C566B ON profile_picture');
        $this->addSql('ALTER TABLE profile_picture ADD path VARCHAR(255) NOT NULL, DROP path_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE profile_picture ADD path_id INT DEFAULT NULL, DROP path');
        $this->addSql('ALTER TABLE profile_picture ADD CONSTRAINT FK_C5659115D96C566B FOREIGN KEY (path_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_C5659115D96C566B ON profile_picture (path_id)');
    }
}
