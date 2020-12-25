<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201225052937 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE coffee_shop DROP INDEX UNIQ_D7A79357E3C61F9, ADD INDEX IDX_D7A79357E3C61F9 (owner_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE coffee_shop DROP INDEX IDX_D7A79357E3C61F9, ADD UNIQUE INDEX UNIQ_D7A79357E3C61F9 (owner_id)');
    }
}
